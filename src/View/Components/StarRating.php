<?php

namespace Igniter\Orange\View\Components;

use Illuminate\View\Component;

class StarRating extends Component
{
    public function __construct(
        public int $score = 0,
    )
    {
    }

    public function render()
    {
        return view('igniter-orange::components.star-rating');
    }
}
