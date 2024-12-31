<?php

namespace Igniter\Orange\Tests\Livewire\Utils;

use Igniter\Orange\Livewire\OrderPreview;
use Igniter\Orange\Livewire\Utils\Modal;
use Igniter\System\Facades\Assets;
use Livewire\Livewire;

it('initializes modal component correctly', function() {
    Livewire::test(Modal::class)
        ->assertSet('component', null)
        ->assertSet('arguments', [])
        ->assertSet('activeModal', null);
});

it('adds modal.js asset on mount', function() {
    Assets::shouldReceive('addJs')->with('igniter-orange::/js/modal.js', 'modal-js')->once();

    Livewire::test(Modal::class);
});

it('shows modal with correct component and arguments', function() {
    Livewire::test(Modal::class)
        ->call('showModal', OrderPreview::class, ['arg1' => 'value1'])
        ->assertSet('component', OrderPreview::class)
        ->assertSet('arguments', ['arg1' => 'value1'])
        ->assertSet('activeModal', 'orange-modal-'.md5(OrderPreview::class.serialize(['arg1' => 'value1'])));
});

it('resets modal correctly', function() {
    Livewire::test(Modal::class)
        ->call('showModal', OrderPreview::class, ['arg1' => 'value1'])
        ->call('resetModal')
        ->assertSet('component', null)
        ->assertSet('arguments', [])
        ->assertSet('activeModal', null);
});

it('renders modal view', function() {
    Livewire::test(Modal::class)
        ->assertViewIs('igniter-orange::livewire.utils.modal');
});
