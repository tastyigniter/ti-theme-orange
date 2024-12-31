<?php

namespace Igniter\Orange\Tests\View\Components;

use Igniter\Cart\Models\Category;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\Orange\View\Components\CategoryList;
use Illuminate\Routing\Route;

it('initializes category list component correctly', function() {
    $component = new CategoryList('local.menus', true, false);

    expect(class_uses_recursive($component))->toContain(ConfigurableComponent::class, UsesPage::class)
        ->and($component->menusPage)->toBe('local.menus')
        ->and($component->hideEmpty)->toBeTrue()
        ->and($component->useLinkAnchor)->toBeFalse();
});

it('returns correct component meta', function() {
    $meta = CategoryList::componentMeta();

    expect($meta['code'])->toBe('igniter-orange::category-list')
        ->and($meta['name'])->toBe('igniter.orange::default.component_category_list_title')
        ->and($meta['description'])->toBe('igniter.orange::default.component_category_list_desc');
});

it('defines properties correctly', function() {
    $component = new CategoryList();
    $properties = $component->defineProperties();

    expect($properties['menusPage']['label'])->toBe('Page to redirect to when a category is clicked.')
        ->and($properties['menusPage']['type'])->toBe('select')
        ->and($properties['menusPage']['validationRule'])->toBe('required|regex:/^[a-z0-9\-_\.]+$/i')
        ->and($properties['hideEmpty']['label'])->toBe('Hide empty categories with no menu items')
        ->and($properties['hideEmpty']['type'])->toBe('switch')
        ->and($properties['hideEmpty']['validationRule'])->toBe('required|boolean')
        ->and($properties['useLinkAnchor']['label'])->toBe('Use link anchor for category links')
        ->and($properties['useLinkAnchor']['type'])->toBe('switch')
        ->and($properties['useLinkAnchor']['validationRule'])->toBe('required|boolean');
});

it('loads categories correctly', function() {
    $categories = Category::factory()->count(5)->create(['status' => true]);
    $route = new Route('GET', 'test', []);
    $route->bind(request());
    $route->setParameter('category', 'test-category');
    request()->setRouteResolver(fn() => $route);
    Location::shouldReceive('current')->andReturn(LocationModel::factory()->create());

    $component = new CategoryList();
    $loadedCategories = $component->render()['categories'];

    expect($loadedCategories->pluck('name')->all())->toContain(...$categories->pluck('name')->all());
});

it('finds selected category correctly', function() {
    $category = Category::factory()->create(['status' => true, 'permalink_slug' => 'test-category']);
    $route = new Route('GET', 'test', []);
    $route->bind(request());
    $route->setParameter('category', 'test-category');
    request()->setRouteResolver(fn() => $route);
    Location::shouldReceive('current')->andReturn(LocationModel::factory()->create());

    $component = new CategoryList();
    $component->render();
    $selectedCategory = $component->render()['selectedCategory'];

    expect($selectedCategory->name)->toBe($category->name);
});

it('returns null when no category is selected', function() {
    $route = new Route('GET', 'test', []);
    $route->bind(request());
    $route->setParameter('category', '');
    request()->setRouteResolver(fn() => $route);

    $component = new CategoryList();
    $selectedCategory = $component->render()['selectedCategory'];

    expect($selectedCategory)->toBeNull();
});
