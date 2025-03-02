<?php

declare(strict_types=1);

namespace Igniter\Orange\View\Components;

use Override;
use Igniter\Local\Facades\Location;
use Igniter\Main\Traits\ConfigurableComponent;
use Illuminate\View\Component;

final class Fulfillment extends Component
{
    use ConfigurableComponent;

    public function __construct(
        public bool $previewMode = false,
    ) {}

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::fulfillment',
            'name' => 'igniter.orange::default.component_fulfillment_title',
            'description' => 'igniter.orange::default.component_fulfillment_desc',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'previewMode' => [
                'label' => 'Render the component in preview mode',
                'type' => 'switch',
            ],
        ];
    }

    #[Override]
    public function render()
    {
        return view('igniter-orange::components.fulfillment', [
            'isAsap' => Location::orderTimeIsAsap(),
            'activeOrderType' => Location::getOrderType(),
            'orderDateTime' => Location::orderDateTime(),
        ]);
    }
}
