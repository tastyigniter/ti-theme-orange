<?php

namespace Igniter\Orange\Livewire;

use Igniter\Cart\Classes\CartManager;
use Igniter\Local\Facades\Location;
use Igniter\Orange\Contracts\ModalComponent;
use Igniter\Orange\Data\MenuItemData;
use Livewire\Livewire;

class CartItemModal extends ModalComponent
{
    public ?int $menuId = null;

    public ?string $rowId = null;

    public ?int $quantity = null;

    public ?string $comment = null;

    public ?array $menuOptions = [];

    public float $price = 0;

    public float $total = 0;

    public ?int $minQuantity = null;

    /** Show cart menu item image in the popup */
    public bool $showThumb = true;

    /** Cart item image width */
    public int $thumbWidth = 720;

    /** Cart item image height */
    public int $thumbHeight = 300;

    /** Whether to hide zero prices on options */
    public bool $hideZeroOptionPrices = false;

    public bool $checkStockCheckout = true;

    /**
     * @var \Igniter\Cart\Classes\CartManager
     */
    protected $cartManager;

    protected ?\Igniter\Cart\CartItem $cartItem = null;

    protected ?MenuItemData $menuItemData = null;

    public function render()
    {
        return view('igniter-orange::livewire.cart-item-modal', [
            'cartItem' => $this->getCartItem(),
            'menuItemData' => $this->getMenuItemData(),
        ]);
    }

    public function mount(int $menuId, ?string $rowId = null)
    {
        $this->menuId = $menuId;
        $this->rowId = $rowId;

        $this->getCartItem();
        $this->getMenuItemData();

        $this->minQuantity = $this->menuItemData->minimumQuantity;
        $this->price = $this->cartItem->price ?? $this->menuItemData->price();
        $this->quantity = $this->cartItem->qty ?? $this->menuItemData->minimumQuantity;
        $this->comment = $this->cartItem?->comment;
    }

    public function boot()
    {
        $this->cartManager = resolve(CartManager::class);
    }

    public function onSave()
    {
        $this->cartManager->addOrUpdateCartItem([
            'menuId' => $this->menuId,
            'rowId' => $this->rowId,
            'quantity' => $this->quantity,
            'comment' => $this->comment,
            'menu_options' => $this->menuOptions,
        ]);

        return $this->redirect(Livewire::originalUrl(), navigate: true);
    }

    public function getLocationId()
    {
        return Location::getId();
    }

    public function getOptionQuantityTypeValue($menuOptionValueId)
    {
        $value = 0;
        if ($this->cartItem && $this->cartItem->hasOptionValue($menuOptionValueId)) {
            $this->cartItem->options->search(function ($option) use ($menuOptionValueId, &$value) {
                $option->values->each(function ($opt) use ($menuOptionValueId, &$value) {
                    if ($opt->id == $menuOptionValueId) {
                        $value = $opt->qty;
                    }
                });
            });
        }

        return $value;
    }

    protected function getCartItem(): ?\Igniter\Cart\CartItem
    {
        if (!is_null($this->cartItem)) {
            return $this->cartItem;
        }

        return $this->cartItem = $this->rowId ? $this->cartManager->getCartItem($this->rowId) : null;
    }

    protected function getMenuItemData(): MenuItemData
    {
        if (!is_null($this->menuItemData)) {
            return $this->menuItemData;
        }

        return $this->menuItemData = new MenuItemData($this->cartManager->findMenuItem($this->menuId));
    }
}
