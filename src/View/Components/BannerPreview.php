<?php

namespace Igniter\Orange\View\Components;

use Igniter\Frontend\Models\Banner;
use Igniter\Orange\Data\BannerData;
use Illuminate\View\Component;

class BannerPreview extends Component
{
    protected ?BannerData $banner = null;

    public function __construct(
        public string $code,
        public int $width = 960,
        public int $height = 360,
    ) {
    }

    public function render()
    {
        return view('igniter-orange::components.banner-preview', [
            'bannerData' => $this->loadBanner(),
        ]);
    }

    public function shouldRender()
    {
        return $this->loadBanner() !== null;
    }

    protected function loadBanner()
    {
        if (isset($this->banner)) {
            return $this->banner;
        }

        $model = Banner::query()->isEnabled()->whereCode($this->code)->first();

        return $this->banner = $model ? tap(new BannerData($model), function ($bannerData) {
            $bannerData->imageWidth = $this->width;
            $bannerData->imageHeight = $this->height;
        }) : null;
    }
}
