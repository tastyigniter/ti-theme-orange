<?php

namespace Igniter\Orange\View\Components;

use Igniter\User\Facades\Auth;
use Illuminate\View\Component;

class ListOrders extends Component
{
    public int $itemsPerPage = 20;

    public string $sortOrder = 'created_at desc';

    public string $orderPage = 'account'.DIRECTORY_SEPARATOR.'order';

    public function onRun()
    {
        $this->page['orderDateTimeFormat'] = lang('system::lang.moment.date_time_format_short');
        $this->page['orderPage'] = $this->property('orderPage');
        $this->page['customerOrders'] = $this->loadOrders();
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
        return view('igniter-orange::components.list-orders', [
            'orders' => $this->loadOrders(),
        ]);
    }
}
