<?php

namespace Igniter\Orange\View\Components;

use Igniter\Cart\Classes\CartManager;
use Illuminate\View\Component;

class CartPreview extends Component
{
    public function render()
    {
        return view('igniter-orange::components.cart-preview', [
            'pageIsCheckout' => true,
            'cart' => resolve(CartManager::class)->getCart(),
        ]);
    }
}
