<?php

namespace Igniter\Orange\View\Components;

use Igniter\Frontend\Models\Banner;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Orange\Data\BannerData;
use Illuminate\View\Component;

class BannerPreview extends Component
{
    use ConfigurableComponent;

    protected ?BannerData $banner = null;

    public function __construct(
        public string $code = '',
        public int $width = 960,
        public int $height = 360,
    ) {}

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::banner-preview',
            'name' => 'igniter.orange::default.component_banner_preview_title',
            'description' => 'igniter.orange::default.component_banner_preview_desc',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'code' => [
                'label' => 'lang:igniter.frontend::default.banners.label_banner',
                'type' => 'select',
                'validationRule' => 'required|alpha_dash',
            ],
            'width' => [
                'label' => 'lang:igniter.frontend::default.banners.label_width',
                'span' => 'left',
                'type' => 'number',
                'validationRule' => 'required|integer',
            ],
            'height' => [
                'label' => 'lang:igniter.frontend::default.banners.label_height',
                'span' => 'right',
                'type' => 'number',
                'validationRule' => 'required|integer',
            ],
        ];
    }

    public static function getCodeOptions()
    {
        return Banner::whereIsEnabled()->dropdown('name');
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

        return $this->banner = $model ? tap(new BannerData($model), function($bannerData) {
            $bannerData->imageWidth = $this->width;
            $bannerData->imageHeight = $this->height;
        }) : null;
    }
}
