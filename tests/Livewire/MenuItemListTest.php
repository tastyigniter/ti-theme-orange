<?php

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Orange\Livewire\MenuItemList;
use Livewire\Livewire;

beforeEach(function() {
    $this->location = LocationModel::factory()->create();
    Location::setModel($this->location);
});

it('mounts and prepare props', function() {
    Livewire::test(MenuItemList::class)
        ->assertSet('isGrouped', true)
        ->assertSet('collapseCategoriesAfter', 5)
        ->assertSet('itemsPerPage', 200)
        ->assertSet('sortOrder', 'menu_priority asc')
        ->assertSet('showThumb', true)
        ->assertSet('menuThumbWidth', 95)
        ->assertSet('menuThumbHeight', 80)
        ->assertSet('categoryThumbWidth', 1240)
        ->assertSet('categoryThumbHeight', 256)
        ->assertSet('allergenThumbWidth', 28)
        ->assertSet('allergenThumbHeight', 28)
        ->assertSet('selectedCategorySlug', '')
        ->assertSet('hideMenuSearch', false)
        ->assertSet('menuSearchTerm', '');
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
