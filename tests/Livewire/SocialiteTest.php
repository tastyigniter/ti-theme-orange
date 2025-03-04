<?php

declare(strict_types=1);

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\Orange\Livewire\Socialite;
use Igniter\Socialite\Classes\ProviderManager;
use Livewire\Livewire;

it('initialize component correctly', function(): void {
    $component = new Socialite;

    expect(class_uses_recursive($component))
        ->toContain(ConfigurableComponent::class, UsesPage::class)
        ->and($component->errorPage)->toBe('account.login')
        ->and($component->successPage)->toBe('account.account')
        ->and($component->confirm)->toBeFalse()
        ->and($component->email)->toBeNull()
        ->and($component->links)->toBeArray();
});

it('returns correct component meta', function(): void {
    $meta = Socialite::componentMeta();

    expect($meta['code'])->toBe('igniter-orange::socialite')
        ->and($meta['name'])->toBe('igniter.orange::default.component_socialite_title')
        ->and($meta['description'])->toBe('igniter.orange::default.component_socialite_desc');
});

it('defines properties correctly', function(): void {
    $component = new Socialite;
    $properties = $component->defineProperties();

    expect(array_keys($properties))->toContain(
        'errorPage',
        'successPage',
        'confirm',
    );
});

it('mounts and loads links', function(): void {
    $providerManager = mock(ProviderManager::class);
    $providerManager->shouldReceive('listProviderLinks')->andReturn(collect([
        'facebook' => 'https://facebook.com',
        'google' => 'https://google.com',
    ]));
    app()->instance(ProviderManager::class, $providerManager);

    Livewire::test(Socialite::class)
        ->assertSet('links', fn($links): bool => is_array($links));
});

it('confirms email', function(): void {
    $providerManager = mock(ProviderManager::class);
    $providerManager->shouldReceive('getProviderData')->andReturn((object)['user' => (object)['email' => 'test@example.com']]);
    $providerManager->shouldReceive('setProviderData')->once();
    $providerManager->shouldReceive('completeCallback')->once()->andReturnTrue();
    $providerManager->shouldReceive('listProviderLinks')->andReturn(collect([
        'facebook' => 'https://facebook.com',
        'google' => 'https://google.com',
    ]));
    app()->instance(ProviderManager::class, $providerManager);

    Livewire::test(Socialite::class)
        ->set('email', 'test@example.com')
        ->set('confirm', true)
        ->call('onConfirmEmail')
        ->assertOk();
});
