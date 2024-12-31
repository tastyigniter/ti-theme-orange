<?php

namespace Igniter\Orange\Tests\View\Components;

use Igniter\Frontend\Models\Banner;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Orange\Data\BannerData;
use Igniter\Orange\View\Components\BannerPreview;

it('initializes banner preview component correctly', function() {
    $component = new BannerPreview('banner_code', 960, 360);

    expect(class_uses_recursive($component))->toContain(ConfigurableComponent::class)
        ->and($component->code)->toBe('banner_code')
        ->and($component->width)->toBe(960)
        ->and($component->height)->toBe(360);
});

it('returns correct component meta', function() {
    $meta = BannerPreview::componentMeta();

    expect($meta['code'])->toBe('igniter-orange::banner-preview')
        ->and($meta['name'])->toBe('igniter.orange::default.component_banner_preview_title')
        ->and($meta['description'])->toBe('igniter.orange::default.component_banner_preview_desc');
});

it('defines properties correctly', function() {
    $component = new BannerPreview();
    $properties = $component->defineProperties();

    expect($properties['code']['label'])->toBe('lang:igniter.frontend::default.banners.label_banner')
        ->and($properties['code']['type'])->toBe('select')
        ->and($properties['code']['validationRule'])->toBe('required|alpha_dash')
        ->and($properties['width']['label'])->toBe('lang:igniter.frontend::default.banners.label_width')
        ->and($properties['width']['type'])->toBe('number')
        ->and($properties['width']['validationRule'])->toBe('required|integer')
        ->and($properties['height']['label'])->toBe('lang:igniter.frontend::default.banners.label_height')
        ->and($properties['height']['type'])->toBe('number')
        ->and($properties['height']['validationRule'])->toBe('required|integer');
});

it('returns correct code options', function() {
    Banner::create(['name' => 'Banner 1', 'code' => 'banner1', 'status' => 1]);

    $options = BannerPreview::getCodeOptions();

    expect($options->all())->toContain('Banner 1');
});

it('renders view with banner data', function() {
    $banner = Banner::create(['name' => 'Banner 1', 'code' => 'banner_code', 'status' => 1]);

    $bannerData = new BannerData($banner);
    $bannerData->imageWidth = 960;
    $bannerData->imageHeight = 360;

    $component = new BannerPreview('banner_code', 960, 360);
    $component->render();
    $view = $component->render();

    expect($view->getData()['bannerData']->code)->toBe($bannerData->code);
});

it('should render returns true when banner is loaded', function() {
    Banner::create(['name' => 'Banner 1', 'code' => 'banner_code', 'status' => 1]);

    $component = new BannerPreview('banner_code', 960, 360);
    $shouldRender = $component->shouldRender();

    expect($shouldRender)->toBeTrue();
});

it('should render returns false when banner is not loaded', function() {
    $component = new BannerPreview('invalid_code', 960, 360);
    $shouldRender = $component->shouldRender();

    expect($shouldRender)->toBeFalse();
});
