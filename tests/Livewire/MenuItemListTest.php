<?php

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Admin\Classes\FormField;
use Igniter\Admin\Widgets\Form;
use Igniter\Cart\Models\Menu;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Main\Http\Controllers\Themes;
use Igniter\Main\Models\Theme;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Orange\Livewire\MenuItemList;
use Livewire\Livewire;
use Livewire\WithPagination;

beforeEach(function() {
    $this->location = LocationModel::factory()->create();
    Location::setModel($this->location);
});

it('initialize component correctly', function() {
    $component = new MenuItemList();

    expect(class_uses_recursive($component))
        ->toContain(ConfigurableComponent::class, WithPagination::class)
        ->and($component->isGrouped)->toBeTrue()
        ->and($component->collapseCategoriesAfter)->toBe(5)
        ->and($component->itemsPerPage)->toBe(200)
        ->and($component->sortOrder)->toBe('menu_priority asc')
        ->and($component->showThumb)->toBeFalse()
        ->and($component->menuThumbWidth)->toBe(95)
        ->and($component->menuThumbHeight)->toBe(80)
        ->and($component->categoryThumbWidth)->toBe(1240)
        ->and($component->categoryThumbHeight)->toBe(256)
        ->and($component->allergenThumbWidth)->toBe(28)
        ->and($component->allergenThumbHeight)->toBe(28)
        ->and($component->selectedCategorySlug)->toBe('')
        ->and($component->hideMenuSearch)->toBeFalse()
        ->and($component->menuSearchTerm)->toBe('')
        ->and($component->selectedMenuId)->toBe('');
});

it('returns correct component meta', function() {
    $meta = MenuItemList::componentMeta();

    expect($meta['code'])->toBe('igniter-orange::menu-item-list')
        ->and($meta['name'])->toBe('igniter.orange::default.component_menu_item_list_title')
        ->and($meta['description'])->toBe('igniter.orange::default.component_menu_item_list_desc');
});

it('defines properties correctly', function() {
    $component = new MenuItemList();
    $properties = $component->defineProperties();

    expect(array_keys($properties))->toContain(
        'isGrouped',
        'collapseCategoriesAfter',
        'itemsPerPage',
        'sortOrder',
        'showThumb',
        'menuThumbWidth',
        'menuThumbHeight',
        'categoryThumbWidth',
        'categoryThumbHeight',
        'allergenThumbWidth',
        'allergenThumbHeight',
        'hideMenuSearch',
    );
});

it('returns correct sorted order options', function() {
    $form = new Form(resolve(Themes::class), [
        'model' => new Theme,
    ]);
    $field = new FormField('sortOrder', 'Sort Order');
    $field->displayAs('select', [
        'property' => 'sortOrder',
    ]);

    $options = MenuItemList::getPropertyOptions($form, $field);

    expect($options)->toBeArray()->not->toBeEmpty();
});

it('returns empty array for unknown property', function() {
    $form = new Form(resolve(Themes::class), [
        'model' => new Theme,
    ]);
    $field = new FormField('sortOrder', 'Sort Order');
    $field->displayAs('select', [
        'property' => 'unknownProperty',
    ]);

    $options = MenuItemList::getPropertyOptions($form, $field);

    expect($options)->toBe([]);
});

it('mounts component correctly', function() {
    Livewire::test(MenuItemList::class)
        ->assertSet('selectedCategorySlug', '');
});

it('loads menu items correctly when pagination is disabled', function() {
    $menu = Menu::factory()->hasCategories(3)->create();

    Livewire::test(MenuItemList::class)
        ->set('showThumb', true)
        ->set('itemsPerPage', -1)
        ->assertSet('selectedCategorySlug', '')
        ->assertViewHas('menuList')
        ->assertViewHas('menuListCategories')
        ->assertSee($menu->menu_name);
});

it('adds to cart', function() {
    Livewire::test(MenuItemList::class)
        ->call('onAddToCart', 1, 1, false)
        ->assertDispatched('cart-box:add-item');
});

it('loads add to cart popup', function() {
    Livewire::test(MenuItemList::class)
        ->call('onAddToCart', 1, 1, true)
        ->assertDispatched('openModal');
});
