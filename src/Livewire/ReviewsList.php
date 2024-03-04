<?php

namespace Igniter\Orange\Livewire;

use Igniter\Local\Models\Review as ReviewModel;
use Igniter\Orange\Livewire\Concerns\WithReviews;
use Illuminate\View\View;
use Livewire\Component;

class ReviewsList extends Component
{
    use WithReviews;

    public function render(): View
    {
        return view('igniter-orange::livewire.reviews-list', [
            'reviewRatingHints' => ReviewModel::make()->getRatingOptions(),
            'reviewList' => $this->loadReviewList(),
        ]);
    }
}
