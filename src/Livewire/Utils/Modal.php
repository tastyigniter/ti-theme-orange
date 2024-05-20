<?php

namespace Igniter\Orange\Livewire\Utils;

use Igniter\Orange\Contracts\ModalComponentInterface;
use Igniter\System\Facades\Assets;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Reflector;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Mechanisms\ComponentRegistry;
use ReflectionClass;

class Modal extends Component
{
    public ?string $activeComponent;

    public array $components = [];

    public function mount()
    {
        Assets::addJs('igniter-orange::/js/modal.js', 'modal-js');
    }

    public function resetState(): void
    {
        $this->components = [];
        $this->activeComponent = null;
    }

    #[On('openModal')]
    public function openModal($component, $arguments = [], $modalAttributes = []): void
    {
        $requiredInterface = ModalComponentInterface::class;
        $componentClass = app(ComponentRegistry::class)->getClass($component);
        $reflect = new ReflectionClass($componentClass);

        if ($reflect->implementsInterface($requiredInterface) === false) {
            throw new \LogicException("[$componentClass] does not implement [$requiredInterface] interface.");
        }

        $id = md5($component.serialize($arguments));

        $arguments = collect($arguments)
            ->merge($this->resolveComponentProps($arguments, new $componentClass()))
            ->all();

        $this->components[$id] = [
            'name' => $component,
            'arguments' => $arguments,
            'modalAttributes' => array_merge([
                'closeOnClickAway' => $componentClass::closeModalOnClickAway(),
                'closeOnEscape' => $componentClass::closeModalOnEscape(),
                'closeOnEscapeIsForceful' => $componentClass::closeModalOnEscapeIsForceful(),
                'dispatchCloseEvent' => $componentClass::dispatchCloseEvent(),
                'destroyOnClose' => $componentClass::destroyOnClose(),
                'maxWidth' => $componentClass::modalMaxWidth(),
                'maxWidthClass' => $componentClass::modalMaxWidthClass(),
            ], $modalAttributes),
        ];

        $this->activeComponent = $id;

        $this->dispatch('activeModalComponentChanged', id: $id);
    }

    public function resolveComponentProps(array $attributes, Component $component)
    {
        return $this->getPublicPropertyTypes($component)
            ->intersectByKeys($attributes)
            ->map(function($className, $propName) use ($attributes) {
                return $this->resolveParameter($attributes, $propName, $className);
            });
    }

    protected function resolveParameter($attributes, $parameterName, $parameterClassName)
    {
        $parameterValue = $attributes[$parameterName];

        if ($parameterValue instanceof UrlRoutable) {
            return $parameterValue;
        }

        if (enum_exists($parameterClassName)) {
            $enum = $parameterClassName::tryFrom($parameterValue);

            if ($enum !== null) {
                return $enum;
            }
        }

        $instance = app()->make($parameterClassName);

        if (!$model = $instance->resolveRouteBinding($parameterValue)) {
            throw (new ModelNotFoundException())->setModel(get_class($instance), [$parameterValue]);
        }

        return $model;
    }

    public function getPublicPropertyTypes($component)
    {
        return collect($component->all())
            ->map(function($value, $name) use ($component) {
                return Reflector::getParameterClassName(new \ReflectionProperty($component, $name));
            })
            ->filter();
    }

    #[On('destroyComponent')]
    public function destroyComponent($id): void
    {
        unset($this->components[$id]);
    }

    public function render(): View
    {
        return view('igniter-orange::livewire.utils.modal');
    }
}
