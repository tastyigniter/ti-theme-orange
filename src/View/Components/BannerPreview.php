<?php

namespace Igniter\Orange\View\Components;

use Igniter\Frontend\Models\Banners as BannerModel;
use Igniter\Main\Helpers\ImageHelper;
use Illuminate\View\Component;

class BannerPreview extends Component
{
    public $banner;

    public function defineProperties(): array
    {
        return [
            'banner_id' => [
                'label' => 'lang:igniter.frontend::default.banners.column_banner',
                'type' => 'select',
                'validationRule' => 'required|integer',
            ],
            'width' => [
                'label' => 'lang:igniter.frontend::default.banners.label_width',
                'span' => 'left',
                'type' => 'number',
                'default' => 960,
                'validationRule' => 'required|integer',
            ],
            'height' => [
                'label' => 'lang:igniter.frontend::default.banners.label_height',
                'span' => 'right',
                'type' => 'text',
                'default' => 360,
                'validationRule' => 'required|integer',
            ],
        ];
    }

    public static function getBannerIdOptions()
    {
        return BannerModel::whereIsEnabled()->dropdown('name');
    }

    public function onRender()
    {
        $this->page['banner'] = $this->loadBanner();
    }

    protected function loadBanner()
    {
        if (isset($this->banner)) {
            return $this->banner;
        }

        $model = BannerModel::query()->isEnabled()
            ->where('banner_id', $this->property('banner_id'))->first();

        if (!$model) {
            return null;
        }

        $banner = new \stdClass;
        $banner->id = 'banner-slideshow-'.uniqid();
        $banner->type = $model->type;
        $banner->isCustom = ($model->type == 'custom');
        $banner->clickUrl = site_url($model->click_url);
        $banner->altText = $model->alt_text;
        $banner->value = $this->prepareImages($model);

        return $this->banner = $banner;
    }

    protected function prepareImages(BannerModel $banner)
    {
        if ($banner->type == 'custom') {
            return $banner->custom_code;
        }

        $images = array_filter($banner->image_code);

        return array_map(function ($path) {
            $imageHeight = $this->property('width');
            $imageWidth = $this->property('height');

            return [
                'name' => basename($path),
                'height' => $imageHeight,
                'width' => $imageWidth,
                'url' => ImageHelper::resize($path, [
                    'width' => $imageWidth,
                    'height' => $imageHeight,
                ]),
            ];
        }, $images);
    }

    public function render()
    {
        return view('igniter-orange::components.banner-preview');
    }
}
