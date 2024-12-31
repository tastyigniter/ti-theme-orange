<?php

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Orange\Livewire\Captcha;
use Livewire\Livewire;

it('initialize component correctly', function() {
    $component = new Captcha();

    expect(class_uses_recursive($component))
        ->toContain(ConfigurableComponent::class)
        ->and($component->apiKey)->toBe('')
        ->and($component->lang)->toBe('');
});

it('returns correct component meta', function() {
    $meta = Captcha::componentMeta();

    expect($meta['code'])->toBe('igniter-orange::captcha')
        ->and($meta['name'])->toBe('igniter.orange::default.component_captcha_title')
        ->and($meta['description'])->toBe('igniter.orange::default.component_captcha_desc');
});

it('mounts correctly', function() {
    Livewire::test(Captcha::class)
        ->assertSet('apiKey', '')
        ->assertSet('lang', 'en');
});
