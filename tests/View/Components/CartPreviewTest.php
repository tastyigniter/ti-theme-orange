<?php

namespace Igniter\Orange\Tests\View\Components;

use Igniter\Cart\Cart;
use Igniter\Cart\Classes\CartManager;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Orange\View\Components\CartPreview;

it('returns correct component meta', function() {
    $meta = CartPreview::componentMeta();

    expect($meta['code'])->toBe('igniter-orange::cart-preview')
        ->and($meta['name'])->toBe('igniter.orange::default.component_cart_preview_title')
        ->and($meta['description'])->toBe('igniter.orange::default.component_cart_preview_desc');
});

it('renders view with cart data', function() {
    $cart = mock(Cart::class);
    $cartManager = mock(CartManager::class);
    $cartManager->shouldReceive('getCart')->andReturn($cart);
    app()->instance(CartManager::class, $cartManager);

    $component = new CartPreview;
    $view = $component->render();

    expect(class_uses_recursive($component))->toContain(ConfigurableComponent::class)
        ->and($view->getData()['previewMode'])->toBeTrue()
        ->and($view->getData()['cart'])->toBe($cart);
});
