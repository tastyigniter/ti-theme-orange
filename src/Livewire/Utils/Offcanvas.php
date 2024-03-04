<?php

namespace Igniter\Orange\Livewire\Utils;

use Igniter\Orange\Contracts\OffcanvasComponentInterface;
use Igniter\System\Facades\Assets;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Mechanisms\ComponentRegistry;
use ReflectionClass;

class Offcanvas extends Component
{
    public ?string $activeOffcanvas;

    public array $components = [];

    public function mount()
    {
        Assets::addJs('igniter-orange::/js/offcanvas.js', 'offcanvas-js');
    }

    #[On('openOffcanvas')]
    public function openOffcanvas($component, $arguments = []): void
    {
        $requiredInterface = OffcanvasComponentInterface::class;
        $componentClass = app(ComponentRegistry::class)->getClass($component);
        $reflect = new ReflectionClass($componentClass);

        if ($reflect->implementsInterface($requiredInterface) === false) {
            throw new \LogicException("[$componentClass] does not implement [$requiredInterface] interface.");
        }

        $id = md5($component.serialize($arguments));

        $this->components[$id] = [
            'name' => $component,
            'arguments' => $arguments,
        ];

        $this->activeOffcanvas = $id;

        $this->dispatch('activeOffcanvasComponentChanged', id: $id);
    }

    #[On('destroyOffcanvas')]
    public function destroyOffcanvas($id): void
    {
        unset($this->components[$id]);
    }

    public function render()
    {
        return view('igniter-orange::livewire.utils.offcanvas');
    }
}