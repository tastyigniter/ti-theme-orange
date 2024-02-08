<?php

namespace Igniter\Orange\Livewire;

use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Review as ReviewModel;
use Igniter\Orange\Contracts\ModalComponent;
use Illuminate\View\View;
use Livewire\WithPagination;

class LocalReviewsModal extends ModalComponent
{
    use WithPagination;

    public string $name;

    public int $itemPerPage = 20;

    public string $sortOrder = 'menu_priority asc';

    public string $menusPage = 'local'.DIRECTORY_SEPARATOR.'menus';

    public function render(): View
    {
        return view('igniter-orange::livewire.local-reviews-modal', [
            'reviewRatingHints' => ReviewModel::make()->getRatingOptions(),
            'reviewList' => $this->loadReviewList(),
        ]);
    }

    public function mount()
    {
        $this->name = Location::current()->getName();
    }

    protected function loadReviewList()
    {
        if (!$location = Location::current()) {
            return null;
        }

        return ReviewModel::with(['customer', 'customer.address'])
            ->isApproved()
            ->listFrontEnd([
                'page' => $this->getPage(),
                'pageLimit' => $this->itemPerPage,
                'sort' => $this->sortOrder,
                'location' => $location->getKey(),
            ]);
    }

    public function initialize()
    {
        $this->addCss('../formwidgets/starrating/assets/vendor/raty/jquery.raty.css', 'jquery-raty-css');
        $this->addJs('../formwidgets/starrating/assets/vendor/raty/jquery.raty.js', 'jquery-raty-js');

        $this->addCss('../formwidgets/starrating/assets/css/starrating.css', 'starrating-css');
        $this->addJs('../formwidgets/starrating/assets/js/starrating.js', 'starrating-js');
    }
}
