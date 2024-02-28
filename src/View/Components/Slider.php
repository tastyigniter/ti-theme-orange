<?php

namespace Igniter\Orange\View\Components;

use Igniter\Frontend\Models\Slider as SliderModel;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Slider extends Component
{
    public array|Collection $slides = [];

    public function __construct(
        public string $code = 'home-slider',
        public string $height = '60vh',
        public string $effect = 'ease',
        public int $delayInterval = 5000,
        public bool $hideControls = false,
        public bool $hideIndicators = false,
        public bool $hideCaptions = false,
    ) {
    }

    public function render()
    {
        return view('igniter-orange::components.slider', [
            'slides' => $this->slides(),
        ]);
    }

    protected function slides()
    {
        if ($this->code && $slider = SliderModel::whereCode($this->code)->first()) {
            $this->slides = $slider->images;
        }

        return $this->slides;
    }
}
