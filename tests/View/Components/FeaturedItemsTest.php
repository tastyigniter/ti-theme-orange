<?php

namespace Igniter\Orange\Tests\View\Components;

use Igniter\Cart\Models\Menu;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Orange\View\Components\FeaturedItems;

it('initializes featured items component correctly', function() {
    $component = new FeaturedItems('Featured Menus', [1, 2, 3], 6, 3, true, 400, 300);

    expect(class_uses_recursive($component))->toContain(ConfigurableComponent::class)
        ->and($component->title)->toBe('Featured Menus')
        ->and($component->items)->toBe([1, 2, 3])
        ->and($component->limit)->toBe(6)
        ->and($component->itemsPerRow)->toBe(3)
        ->and($component->showThumb)->toBeTrue()
        ->and($component->itemWidth)->toBe(400)
        ->and($component->itemHeight)->toBe(300);
});

it('returns correct component meta', function() {
    $meta = FeaturedItems::componentMeta();

    expect($meta['code'])->toBe('igniter-orange::featured-items')
        ->and($meta['name'])->toBe('igniter.orange::default.component_featured_items_title')
        ->and($meta['description'])->toBe('igniter.orange::default.component_featured_items_desc');
});

it('defines properties correctly', function() {
    $component = new FeaturedItems();
    $properties = $component->defineProperties();

    expect($properties['title']['label'])->toBe('Title')
        ->and($properties['title']['type'])->toBe('text')
        ->and($properties['title']['validationRule'])->toBe('string')
        ->and($properties['items']['label'])->toBe('lang:igniter.frontend::default.featured.label_menus')
        ->and($properties['items']['type'])->toBe('selectlist')
        ->and($properties['items']['validationRule'])->toBe('required|array')
        ->and($properties['limit']['label'])->toBe('lang:igniter.frontend::default.featured.label_limit')
        ->and($properties['limit']['type'])->toBe('number')
        ->and($properties['limit']['validationRule'])->toBe('required|integer')
        ->and($properties['itemsPerRow']['label'])->toBe('lang:igniter.frontend::default.featured.label_items_per_row')
        ->and($properties['itemsPerRow']['type'])->toBe('select')
        ->and($properties['itemsPerRow']['validationRule'])->toBe('required|integer')
        ->and($properties['showThumb']['label'])->toBe('Show thumbnail image')
        ->and($properties['showThumb']['type'])->toBe('switch')
        ->and($properties['showThumb']['validationRule'])->toBe('required|boolean')
        ->and($properties['itemWidth']['label'])->toBe('lang:igniter.frontend::default.featured.label_dimension_w')
        ->and($properties['itemWidth']['type'])->toBe('number')
        ->and($properties['itemWidth']['validationRule'])->toBe('integer')
        ->and($properties['itemHeight']['label'])->toBe('lang:igniter.frontend::default.featured.label_dimension_h')
        ->and($properties['itemHeight']['type'])->toBe('number')
        ->and($properties['itemHeight']['validationRule'])->toBe('integer');
});

it('returns correct items options', function() {
    Menu::factory()->create(['menu_name' => 'Menu 1', 'menu_status' => 1]);

    $options = FeaturedItems::getItemsOptions();

    expect($options->all())->toContain('Menu 1');
});

it('renders view with featured items', function() {
    $menus = Menu::factory()->count(3)->create(['menu_status' => 1]);

    $component = new FeaturedItems(items: $menus->pluck('menu_id')->all());
    $view = $component->render();

    expect($view->getData()['featuredItems'])->toHaveCount(3);
});
