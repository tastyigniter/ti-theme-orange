<?php

namespace Igniter\Orange\View\Components;

use Igniter\Local\Models\Review as ReviewModel;
use Illuminate\View\Component;

class StarRating extends Component
{
    protected static ?array $hints = null;

    public function __construct(
        public string $name = '',
        public float $score = 0,
        public float $max = 5,
        public bool $readOnly = true,
    ) {
        $this->max = max(1, count($this->getHints()));
    }

    public function render()
    {
        return view('igniter-orange::components.star-rating', [
            'hints' => $this->getHints(),
        ]);
    }

    protected function getHints()
    {
        return self::$hints ??= ReviewModel::make()->getRatingOptions();
    }
}
