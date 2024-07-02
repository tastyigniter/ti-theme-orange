<?php

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Orange\Livewire\Captcha;
use Livewire\Livewire;

it('mounts correctly', function() {
    Livewire::test(Captcha::class)
        ->assertSet('apiKey', '')
        ->assertSet('lang', 'en');
});
