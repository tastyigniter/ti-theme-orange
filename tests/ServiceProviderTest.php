<?php

namespace Igniter\Orange\Tests;

use Igniter\Main\Classes\ThemeManager;
use Igniter\Main\Models\Theme;
use Igniter\Orange\ServiceProvider;
use Igniter\User\Models\Customer;
use Illuminate\Contracts\Foundation\Application;

it('registers support for flash messages', function() {
    $app = mock(Application::class);
    $app->shouldReceive('runningUnitTests')->once()->andReturnFalse();
    $serviceProvider = new ServiceProvider($app);

    $serviceProvider->register();
});

it('redirects unauthorised user when page requires authentication', function() {
    $this
        ->get(route('igniter.theme.account.account'))
        ->assertRedirect(route('igniter.theme.home'));
});

it('redirects authorised user when page does not require authentication', function() {
    $customer = Customer::factory()->create();

    $this
        ->actingAs($customer, 'igniter-customer')
        ->get(route('igniter.theme.account.register'))
        ->assertRedirect(route('igniter.theme.home'));
});

it('configures Google Fonts correctly', function() {
    $fontUrl = 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap';
    $themeModel = Theme::create([
        'name' => 'test-theme',
        'code' => 'test-theme',
        'version' => '1.0.0',
        'description' => 'Test theme',
        'data' => [
            'font-download' => true,
            'font-url' => $fontUrl,
        ],
    ]);
    $assets = resolve('assets');
    $theme = resolve(ThemeManager::class)->getActiveTheme();
    $theme->name = $themeModel->code;

    event('assets.combiner.afterBuildBundles', [$assets, $theme]);

    expect(config('google-fonts.fonts.default'))
        ->toBe($fontUrl);
});
