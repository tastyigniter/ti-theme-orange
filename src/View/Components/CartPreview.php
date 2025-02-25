<?php

declare(strict_types=1);

namespace Igniter\Orange\View\Components;

use Override;
use Igniter\Cart\Classes\CartManager;
use Igniter\Main\Traits\ConfigurableComponent;
use Illuminate\View\Component;

final class CartPreview extends Component
{
    use ConfigurableComponent;

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::cart-preview',
            'name' => 'igniter.orange::default.component_cart_preview_title',
            'description' => 'igniter.orange::default.component_cart_preview_desc',
        ];
    }

    #[Override]
    public function render()
    {
        return view('igniter-orange::components.cart-preview', [
            'previewMode' => true,
            'cart' => resolve(CartManager::class)->getCart(),
        ]);
    }
}
