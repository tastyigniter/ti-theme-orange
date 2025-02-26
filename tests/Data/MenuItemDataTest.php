<?php

declare(strict_types=1);

namespace Igniter\Orange\Tests\Data;

use Carbon\Carbon;
use Igniter\Cart\Models\Mealtime;
use Igniter\Cart\Models\Menu;
use Igniter\Cart\Models\MenuSpecial;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Orange\Data\MenuItemData;

beforeEach(function(): void {
    $this->model = mock(Menu::class)->makePartial();
    $this->model->shouldReceive('getBuyableIdentifier')->andReturn(1);
    $this->model->shouldReceive('getBuyableName')->andReturn('Test Menu');
    $this->model->shouldReceive('getAttribute')->with('menu_description')->andReturn('Test Description');
    $this->model->shouldReceive('getAttribute')->with('menu_price')->andReturn(10.0);
    $this->model->shouldReceive('getAttribute')->with('minimum_qty')->andReturn(1);
});

it('initializes menu item data correctly', function(): void {
    $menuItemData = new MenuItemData($this->model);

    expect($menuItemData->id)->toBe(1)
        ->and($menuItemData->name)->toBe('Test Menu')
        ->and($menuItemData->description)->toBe('Test Description')
        ->and($menuItemData->priceBeforeSpecial)->toBe(10.0)
        ->and($menuItemData->minimumQuantity)->toBe(1);
});

it('returns correct price', function(): void {
    $this->model->shouldReceive('getBuyablePrice')->andReturn(15.0);

    $menuItemData = new MenuItemData($this->model);

    $price = $menuItemData->price();

    expect($price)->toBe(15.0);
});

it('returns true if menu item has ingredients', function(): void {
    $this->model->shouldReceive('extendableGet')->with('ingredients')->andReturn(collect([['status' => 1]]));

    $menuItemData = new MenuItemData($this->model);

    $hasIngredients = $menuItemData->hasIngredients();

    expect($hasIngredients)->toBeTrue();
});

it('returns available ingredients', function(): void {
    $this->model->shouldReceive('extendableGet')->with('ingredients')->andReturn(collect([['status' => 1], ['status' => 0]]));

    $menuItemData = new MenuItemData($this->model);

    $ingredients = $menuItemData->ingredients();

    expect($ingredients->count())->toBe(1);
});

it('returns true if mealtime is available', function(): void {
    Location::shouldReceive('orderDateTime')->andReturn(Carbon::now());
    $this->model->shouldReceive('isAvailable')->andReturn(true);

    $menuItemData = new MenuItemData($this->model);

    $mealtimeIsAvailable = $menuItemData->mealtimeIsAvailable();

    expect($mealtimeIsAvailable)->toBeTrue();
});

it('returns true if menu item has options', function(): void {
    $this->model->shouldReceive('hasOptions')->andReturn(true);

    $menuItemData = new MenuItemData($this->model);

    expect($menuItemData->hasOptions())->toBeTrue();
});

it('returns sorted menu options', function(): void {
    $this->model->shouldReceive('extendableGet')->with('menu_options')->andReturn(collect([['priority' => 2], ['priority' => 1]]));

    $menuItemData = new MenuItemData($this->model);

    $options = $menuItemData->getOptions();

    expect($options->first()['priority'])->toBe(1);
});

it('returns true if menu item has thumb', function(): void {
    $this->model->shouldReceive('hasMedia')->with('thumb')->andReturn(true);

    $menuItemData = new MenuItemData($this->model);

    $hasThumb = $menuItemData->hasThumb();

    expect($hasThumb)->toBeTrue();
});

it('returns correct thumb URL', function(): void {
    $this->model->shouldReceive('getThumbOrBlank')->with([], null)->andReturn('thumb.jpg');

    $menuItemData = new MenuItemData($this->model);

    $thumbUrl = $menuItemData->getThumb();

    expect($thumbUrl)->toBe('thumb.jpg');
});

it('returns true if special is active', function(): void {
    $special = mock(MenuSpecial::class)->makePartial();
    $special->shouldReceive('active')->andReturnTrue();
    $this->model->shouldReceive('extendableGet')->with('special')->andReturn($special);

    $menuItemData = new MenuItemData($this->model);

    $specialIsActive = $menuItemData->specialIsActive();

    expect($specialIsActive)->toBeTrue();
});

it('returns correct special days remaining', function(): void {
    $special = mock(MenuSpecial::class)->makePartial();
    $special->shouldReceive('daysRemaining')->andReturn(5);
    $this->model->shouldReceive('extendableGet')->with('special')->andReturn($special);

    $menuItemData = new MenuItemData($this->model);

    $specialDaysRemaining = $menuItemData->specialDaysRemaining();

    expect($specialDaysRemaining)->toBe(5);
});

it('returns correct mealtime titles', function(): void {
    $mealTime = Mealtime::factory()->create([
        'mealtime_name' => 'Breakfast',
        'start_time' => '08:00',
        'end_time' => '10:00',
    ]);
    $this->model->shouldReceive('extendableGet')->with('mealtimes')->andReturn(collect([$mealTime]));

    $menuItemData = new MenuItemData($this->model);

    $mealtimeTitles = $menuItemData->mealtimeTitles();

    expect($mealtimeTitles)->toContain('Breakfast');
});

it('returns correct URL for menu item', function(): void {
    $location = LocationModel::factory()->create(['permalink_slug' => 'test-location']);
    $this->model->shouldReceive('extendableGet')->with('locations')->andReturn(collect([$location]));
    Location::shouldReceive('current')->andReturn($location);

    $menuItemData = new MenuItemData($this->model);

    $url = $menuItemData->getUrl('menu-page');

    expect($url)->toContain('menu-page')
        ->and($url)->toContain('menuId=1');
});
