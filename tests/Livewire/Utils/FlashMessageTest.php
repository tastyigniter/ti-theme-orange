<?php

namespace Igniter\Orange\Tests\Livewire\Utils;

use Igniter\Flame\Flash\Facades\Flash;
use Igniter\Flame\Flash\Message;
use Igniter\Orange\Livewire\Utils\FlashMessage;
use Livewire\Livewire;

it('initializes flash messages correctly', function() {
    Flash::shouldReceive('all')->andReturn(collect([
        new Message([
            'level' => 'info',
            'message' => 'Info message',
        ]),
        new Message([
            'level' => 'success',
            'message' => 'Success message',
        ]),
    ]));

    Livewire::test(FlashMessage::class)
        ->assertSet('messages', [
            (object)[
                'level' => 'info',
                'message' => 'Info message',
                'title' => null,
                'important' => false,
                'overlay' => false,
            ],
            (object)[
                'level' => 'success',
                'message' => 'Success message',
                'title' => null,
                'important' => false,
                'overlay' => false,
            ],
        ]);
});

it('renders flash message view', function() {
    Livewire::test(FlashMessage::class)
        ->assertViewIs('igniter-orange::livewire.utils.flash-message');
});
