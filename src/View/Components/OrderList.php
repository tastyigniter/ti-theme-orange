<?php

namespace Igniter\Orange\View\Components;

use Igniter\Cart\Models\Order;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\User\Facades\Auth;
use Illuminate\View\Component;

class OrderList extends Component
{
    use ConfigurableComponent;
    use UsesPage;

    public function __construct(
        public int $itemsPerPage = 20,
        public string $sortOrder = 'created_at desc',
        public string $orderPage = 'account.order',
    ) {}

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::order-list',
            'name' => 'igniter.orange::default.component_order_list_title',
            'description' => 'igniter.orange::default.component_order_list_desc',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'itemsPerPage' => [
                'label' => 'Number of orders to display per page',
                'type' => 'number',
            ],
            'sortOrder' => [
                'label' => 'Default sort order of orders.',
                'type' => 'select',
            ],
            'orderPage' => [
                'label' => 'Page to redirect to when an order is clicked.',
                'type' => 'select',
                'options' => [static::class, 'getThemePageOptions'],
            ],
        ];
    }

    public static function getSortOrderOptions()
    {
        return collect(Order::make()->queryModifierGetSorts())->mapWithKeys(function($value, $key) {
            return [$value => $value];
        })->all();
    }

    protected function loadOrders()
    {
        if (!$customer = Auth::customer()) {
            return [];
        }

        return $customer->orders()
            ->with(['location', 'status'])
            ->whereProcessed(true)
            ->listFrontEnd([
                'page' => request()->input('page', 1),
                'pageLimit' => $this->itemsPerPage,
                'sort' => $this->sortOrder,
            ]);
    }

    public function render()
    {
        return view('igniter-orange::components.order-list', [
            'orders' => $this->loadOrders(),
        ]);
    }
}
