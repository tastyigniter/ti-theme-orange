<?php

declare(strict_types=1);

namespace Igniter\Orange\Tests\Actions;

use Igniter\Cart\Models\Category;
use Igniter\Cart\Models\Menu;
use Igniter\Orange\Actions\ListMenuItems;
use Igniter\Orange\Data\MenuItemData;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

it('returns paginated menu items as MenuItemData when pageLimit > 0', function(): void {
    $category = Category::factory()->create();
    $menuItem = Menu::factory()->create();
    $menuItem->categories()->attach($category);

    $action = new ListMenuItems;
    $result = $action->handle(['pageLimit' => 20])->getList();

    expect($result)->toBeInstanceOf(LengthAwarePaginator::class)
        ->and($result->first())->toBeInstanceOf(MenuItemData::class);
});

it('returns grouped items when isGrouped is true and no category specified', function(): void {
    $category = Category::factory()->create(['priority' => 2]);
    $menuItem = Menu::factory()->create();
    $menuItem->categories()->attach($category);

    $action = new ListMenuItems;
    $result = $action->handle([
        'isGrouped' => true,
        'category' => '',
        'pageLimit' => 20,
    ])->getList();

    expect($result)->toBeInstanceOf(LengthAwarePaginator::class)
        ->and($result->keys()->all())->toContain($category->getKey())
        ->and(array_first($result->get($category->getKey())))->toBeInstanceOf(MenuItemData::class)
        ->and($action->getCategoryList())->toHaveKey($category->getKey());
});

it('groups items without categories under key 0', function(): void {
    Menu::factory()->create();

    $result = (new ListMenuItems)->handle([
        'isGrouped' => true,
        'category' => '',
        'pageLimit' => 20,
    ])->getList();

    expect($result->keys()->first())->toBe(0);
});

it('returns full unpaginated collection when pageLimit is 0', function(): void {
    Menu::factory()->create();

    $action = new ListMenuItems;
    $result = $action->handle([])->getList();

    expect($result)->toBeInstanceOf(Collection::class)
        ->and($result->first())->toBeInstanceOf(MenuItemData::class);
});
