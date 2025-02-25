<?php

declare(strict_types=1);

namespace Igniter\Orange\Tests\Data;

use Igniter\Frontend\Models\Banner;
use Igniter\Main\Classes\MediaLibrary;
use Igniter\Orange\Data\BannerData;

beforeEach(function(): void {
    $this->attributes = [
        'name' => 'Banner Name',
        'code' => 'banner_code',
        'click_url' => 'http://example.com',
        'alt_text' => 'Alt text',
        'custom_code' => '<div>Custom Code</div>',
        'type' => 'image',
        'image_code' => ['image1.jpg', 'image2.jpg'],
    ];
});

it('initializes banner data correctly', function(): void {
    $model = Banner::create($this->attributes);

    $bannerData = new BannerData($model);

    expect($bannerData->code)->toBe('banner_code')
        ->and($bannerData->id)->toMatch('/^banner_code-'.$model->getKey().'-[a-z0-9]{4}$/')
        ->and($bannerData->clickUrl)->toBe('http://example.com')
        ->and($bannerData->altText)->toBe('Alt text')
        ->and($bannerData->markup)->toBe('<div>Custom Code</div>');
});

it('returns true for custom banner type', function(): void {
    $this->attributes['type'] = 'custom';
    $model = Banner::create($this->attributes);

    $bannerData = new BannerData($model);

    expect($bannerData->isCustom())->toBeTrue();
});

it('returns true for carousel banner type', function(): void {
    $this->attributes['type'] = 'image';
    $this->attributes['image_code'] = ['image1.jpg', 'image2.jpg'];
    $model = Banner::create($this->attributes);

    $bannerData = new BannerData($model);

    expect($bannerData->isCarousel())->toBeTrue();
});

it('returns true for image banner type', function(): void {
    $this->attributes['type'] = 'image';
    $model = Banner::create($this->attributes);

    $bannerData = new BannerData($model);

    expect($bannerData->isImage())->toBeTrue();
});

it('returns resized image URLs', function(): void {
    $this->attributes['image_code'] = ['image1.jpg', 'image2.jpg'];
    $model = Banner::create($this->attributes);

    $bannerData = new BannerData($model);
    $bannerData->imageWidth = 100;
    $bannerData->imageHeight = 200;

    $mediaLibrary = mock(MediaLibrary::class);
    $mediaLibrary->shouldReceive('getMediaThumb')->with('image1.jpg', ['width' => 100, 'height' => 200])->andReturn('resized_image1.jpg');
    $mediaLibrary->shouldReceive('getMediaThumb')->with('image2.jpg', ['width' => 100, 'height' => 200])->andReturn('resized_image2.jpg');
    app()->instance(MediaLibrary::class, $mediaLibrary);

    $result = $bannerData->imageUrls();

    expect($result)->toBe(['resized_image1.jpg', 'resized_image2.jpg']);
});

it('returns empty array when no image codes are present', function(): void {
    $this->attributes['image_code'] = null;
    $model = Banner::create($this->attributes);

    $bannerData = new BannerData($model);

    $result = $bannerData->imageUrls();

    expect($result)->toBe([]);
});
