<?php

declare(strict_types=1);

namespace Igniter\Orange\Tests\View\Components;

use Igniter\Frontend\Models\Slider as SliderModel;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Orange\View\Components\Slider;

it('initializes slider component correctly', function(): void {
    $component = new Slider('home-slider', '60vh', 'ease', 5000, false, false, false);

    expect(class_uses_recursive($component))->toContain(ConfigurableComponent::class)
        ->and($component->code)->toBe('home-slider')
        ->and($component->height)->toBe('60vh')
        ->and($component->effect)->toBe('ease')
        ->and($component->delayInterval)->toBe(5000)
        ->and($component->hideControls)->toBeFalse()
        ->and($component->hideIndicators)->toBeFalse()
        ->and($component->hideCaptions)->toBeFalse();
});

it('returns correct component meta', function(): void {
    $meta = Slider::componentMeta();

    expect($meta['code'])->toBe('igniter-orange::slider')
        ->and($meta['name'])->toBe('igniter.orange::default.component_slider_title')
        ->and($meta['description'])->toBe('igniter.orange::default.component_slider_desc');
});

it('defines properties correctly', function(): void {
    $component = new Slider;
    $properties = $component->defineProperties();

    expect($properties['code']['label'])->toBe('lang:igniter.frontend::default.slider.label_slider')
        ->and($properties['code']['type'])->toBe('select')
        ->and($properties['code']['validationRule'])->toBe('required|alpha_dash')
        ->and($properties['height']['label'])->toBe('lang:igniter.frontend::default.banners.label_height')
        ->and($properties['height']['type'])->toBe('text')
        ->and($properties['height']['validationRule'])->toBe('required|string')
        ->and($properties['effect']['label'])->toBe('lang:igniter.frontend::default.slider.label_effect')
        ->and($properties['effect']['type'])->toBe('text')
        ->and($properties['effect']['validationRule'])->toBe('required|string')
        ->and($properties['delayInterval']['label'])->toBe('lang:igniter.frontend::default.slider.label_interval')
        ->and($properties['delayInterval']['type'])->toBe('number')
        ->and($properties['delayInterval']['validationRule'])->toBe('required|integer')
        ->and($properties['hideControls']['label'])->toBe('lang:igniter.frontend::default.slider.label_hide_controls')
        ->and($properties['hideControls']['type'])->toBe('switch')
        ->and($properties['hideControls']['validationRule'])->toBe('required|boolean')
        ->and($properties['hideIndicators']['label'])->toBe('lang:igniter.frontend::default.slider.label_hide_indicators')
        ->and($properties['hideIndicators']['type'])->toBe('switch')
        ->and($properties['hideIndicators']['validationRule'])->toBe('required|boolean')
        ->and($properties['hideCaptions']['label'])->toBe('lang:igniter.frontend::default.slider.label_hide_captions')
        ->and($properties['hideCaptions']['type'])->toBe('switch')
        ->and($properties['hideCaptions']['validationRule'])->toBe('required|boolean');
});

it('returns correct code options', function(): void {
    SliderModel::create(['name' => 'Test Slider', 'code' => 'test-slider']);

    $options = Slider::getCodeOptions();

    expect($options)->toHaveKey('test-slider')->toContain('Test Slider');
});

it('renders view with slides', function(): void {
    $slider = SliderModel::create([
        'name' => 'Test Slider',
        'code' => 'test-slider',
        'images' => ['slide1', 'slide2'],
    ]);
    app()->instance(SliderModel::class, $slider);

    $slides = (new Slider('test-slider'))->render()['slides'];

    expect($slides)->toBeCollection();
});

it('renders empty array when slider code is invalid', function(): void {
    $component = new Slider('invalid-code');
    $slides = $component->render()['slides'];

    expect($slides)->toBe([]);
});
