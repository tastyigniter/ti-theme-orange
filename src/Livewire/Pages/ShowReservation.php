<?php

namespace Igniter\Orange\Livewire\Pages;

use Igniter\Local\Facades\Location;
use Igniter\Reservation\Classes\BookingManager;
use Livewire\Component;

class ShowReservation extends Component
{
    /**
     * @var \Igniter\Reservation\Classes\BookingManager
     */
    protected $manager;

    public $hash;

    public function render()
    {
        return view('igniter-orange::livewire.pages.show-reservation', [
            'reservation' => $this->manager->getReservationByHash($this->hash),
        ]);
    }

    public function boot()
    {
        $this->manager = resolve(BookingManager::class);
        $this->manager->useLocation(Location::current());
    }

    public function mount()
    {
        $this->hash = request()->route()->parameter('hash');
    }
}
