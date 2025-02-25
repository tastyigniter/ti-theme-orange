<?php

declare(strict_types=1);

namespace Igniter\Orange\Tests\View\Components;

use Igniter\Main\Template\Page;
use Igniter\Orange\View\Components\Nav;
use Igniter\Pages\Classes\MenuManager;
use Igniter\Pages\Models\Menu;

it('initializes nav component correctly', function(): void {
    $page = mock(Page::class)->makePartial();
    $page->shouldReceive('getId')->andReturn('page-id');
    controller()->runPage($page);

    $component = new Nav('main-menu');

    expect($component->code)->toBe('main-menu')
        ->and($component->activePage)->toBe(controller()->getPage()->getId());
});

it('renders view with menu items', function(): void {
    $menu = Menu::create([
        'code' => 'main-menu',
        'theme_code' => 'igniter-orange',
    ]);
    $menuManager = mock(MenuManager::class);
    $menuManager->shouldReceive('generateReferences')->andReturn(['item1', 'item2']);
    app()->instance(MenuManager::class, $menuManager);

    $view = (new Nav('main-menu'))->render();

    expect($view->getData()['menuItems'])->toBe(['item1', 'item2']);
});
