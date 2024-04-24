<?php

namespace Igniter\Orange\Livewire;

use Igniter\Local\Models\ReviewSettings;
use Igniter\User\Facades\Auth;
use Livewire\WithPagination;

class ReservationList extends \Livewire\Component
{
    use WithPagination;

    public int $itemsPerPage = 20;

    public string $sortOrder = 'created_at desc';

    public function render()
    {
        return view('igniter-orange::livewire.reservation-list', [
            'allowReviews' => ReviewSettings::allowReviews(),
            'reservations' => $this->loadReservations(),
        ]);
    }

    protected function loadReservations()
    {
        if (!$customer = Auth::customer()) {
            return [];
        }

        return $customer->reservations()
            ->with(['location', 'status', 'tables'])
            ->listFrontEnd([
                'page' => $this->getPage(),
                'pageLimit' => $this->itemsPerPage,
                'sort' => $this->sortOrder,
            ]);
    }
}
