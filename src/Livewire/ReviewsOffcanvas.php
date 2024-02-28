<?php

namespace Igniter\Orange\Livewire;

use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Review as ReviewModel;
use Igniter\Orange\Contracts\OffcanvasComponent;
use Igniter\Orange\Livewire\Concerns\WithReviews;
use Illuminate\View\View;
use Livewire\WithPagination;

class ReviewsOffcanvas extends OffcanvasComponent
{
    use WithPagination;
    use WithReviews;

    public string $locationName;

    public function render(): View
    {
        return view('igniter-orange::livewire.reviews-offcanvas', [
            'reviewRatingHints' => ReviewModel::make()->getRatingOptions(),
            'reviewList' => $this->loadReviewList(),
        ]);
    }

    public function mount()
    {
        $this->itemPerPage = 10;
        $this->locationName = Location::current()->getName();
    }
}
