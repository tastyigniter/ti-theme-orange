<?php

namespace Igniter\Orange\Tests\View\Components;

use Igniter\Local\Facades\Location;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Orange\View\Components\Fulfillment;

it('initializes fulfillment component correctly', function() {
    $component = new Fulfillment(true);

    expect(class_uses_recursive($component))->toContain(ConfigurableComponent::class)
        ->and($component->previewMode)->toBeTrue();
});

it('returns correct component meta', function() {
    $meta = Fulfillment::componentMeta();

    expect($meta['code'])->toBe('igniter-orange::fulfillment')
        ->and($meta['name'])->toBe('igniter.orange::default.component_fulfillment_title')
        ->and($meta['description'])->toBe('igniter.orange::default.component_fulfillment_desc');
});

it('defines properties correctly', function() {
    $component = new Fulfillment();
    $properties = $component->defineProperties();

    expect($properties['previewMode']['label'])->toBe('Render the component in preview mode')
        ->and($properties['previewMode']['type'])->toBe('switch');
});

it('renders view with fulfillment data', function() {
    Location::shouldReceive('orderTimeIsAsap')->andReturn(true);
    Location::shouldReceive('getOrderType')->andReturn('delivery');
    Location::shouldReceive('orderDateTime')->andReturn('2023-10-10 12:00:00');

    $component = new Fulfillment();
    $view = $component->render();

    expect($view->getData()['isAsap'])->toBeTrue()
        ->and($view->getData()['activeOrderType'])->toBe('delivery')
        ->and($view->getData()['orderDateTime'])->toBe('2023-10-10 12:00:00');
});
