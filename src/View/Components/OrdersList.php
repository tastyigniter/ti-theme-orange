<?php

namespace Igniter\Orange\View\Components;

use Igniter\User\Facades\Auth;
use Illuminate\View\Component;

class OrdersList extends Component
{
    public function __construct(
        public int $itemsPerPage = 20,
        public string $sortOrder = 'created_at desc',
        public string $orderPage = 'account'.DIRECTORY_SEPARATOR.'order',
    ) {
    }

    protected function loadOrders()
    {
        if (!$customer = Auth::customer()) {
            return [];
        }

        return $customer->orders()->with(['location', 'status'])
            ->whereProcessed(true)
            ->listFrontEnd([
                'page' => request()->input('page', 1),
                'pageLimit' => $this->itemsPerPage,
                'sort' => $this->sortOrder,
                'customer' => $customer,
            ]);
    }

    public function render()
    {
        return view('igniter-orange::components.orders-list', [
            'orders' => $this->loadOrders(),
        ]);
    }
}
