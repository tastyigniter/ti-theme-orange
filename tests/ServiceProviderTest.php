<?php

declare(strict_types=1);

namespace Igniter\Orange\Tests;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Widgets\Form;
use Igniter\Main\Classes\ThemeManager;
use Igniter\Main\Http\Middleware\CheckInitialSetup;
use Igniter\Main\Models\Theme;
use Igniter\Main\Template\Page;
use Igniter\Orange\Actions\EnsureUniqueProcess;
use Igniter\Orange\ServiceProvider;
use Igniter\User\Models\Customer;
use Illuminate\Contracts\Foundation\Application;
use stdClass;

it('registers support for flash messages', function(): void {
    $app = mock(Application::class);
    $app->shouldReceive('runningUnitTests')->once()->andReturnFalse();
    $app->shouldReceive('singleton')->once()->with(EnsureUniqueProcess::class);
    $serviceProvider = new ServiceProvider($app);

    $serviceProvider->register();
});

it('redirects unauthorised user when page requires authentication', function(): void {
    $this
        ->withoutMiddleware(CheckInitialSetup::class)
        ->get(route('igniter.theme.account.account'))
        ->assertRedirect(route('igniter.theme.account.login'));
});

it('redirects authorised user when page does not require authentication', function(): void {
    $customer = Customer::factory()->create();

    $this
        ->withoutMiddleware(CheckInitialSetup::class)
        ->actingAs($customer, 'igniter-customer')
        ->get(route('igniter.theme.account.register'))
        ->assertRedirect(route('igniter.theme.home'));
});

it('configures Google Fonts correctly', function(): void {
    $fontUrl = 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap';
    $themeModel = Theme::factory()->create([
        'code' => 'tests-theme',
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

function makeFieldsRecordingForm(mixed $fileSource): Form
{
    return new class($fileSource) extends Form
    {
        public array $addedFields = [];

        public string $addedToArea = '';

        public function __construct(mixed $fileSource)
        {
            $this->controller = new class extends AdminController {};
            $this->data = (object)['fileSource' => $fileSource];
        }

        public function addFields(array $fields, string $addToArea = ''): void
        {
            $this->addedFields = $fields;
            $this->addedToArea = $addToArea;
        }
    };
}

it('adds page security fields to page settings forms', function(): void {
    $widget = makeFieldsRecordingForm(Page::on('igniter-orange'));

    event('admin.form.extendFields', [$widget]);

    expect($widget->addedToArea)->toBe('primary')
        ->and($widget->addedFields['settings[security]']['default'])->toBe('all')
        ->and(array_keys($widget->addedFields['settings[security]']['options']))->toBe(['all', 'customer', 'guest'])
        ->and($widget->addedFields['settings[securityRedirectPage]']['default'])->toBe('account.login')
        ->and($widget->addedFields['settings[securityRedirectPage]']['options']())->toBeArray();
});

it('skips page security fields when form has no page file source', function(): void {
    $widget = makeFieldsRecordingForm(new stdClass);

    event('admin.form.extendFields', [$widget]);

    expect($widget->addedFields)->toBe([]);
});
