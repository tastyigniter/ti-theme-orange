<?php

namespace Igniter\Orange;

use Igniter\Admin\Widgets\Form;
use Igniter\Cart\Http\Middleware\CartMiddleware;
use Igniter\Flame\Igniter;
use Igniter\Local\Http\Middleware\CheckLocation;
use Igniter\Main\Classes\MainController;
use Igniter\Main\Classes\Theme;
use Igniter\Main\Classes\ThemeManager;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Orange\Http\Controllers\Logout;
use Igniter\System\Classes\ComponentManager;
use Igniter\System\Libraries\Assets;
use Igniter\User\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Livewire;
use Spatie\GoogleFonts\GoogleFonts;
use Symfony\Component\Finder\Finder;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        Livewire::componentHook(\Igniter\Orange\Livewire\Features\SupportFlashMessages::class);
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'igniter-orange');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'igniter.orange');
        $this->loadBladeComponentsFrom(__DIR__.'/View/Components');
        $this->loadLivewireComponentsFrom(__DIR__.'/Livewire');

        if (!Igniter::runningInAdmin()) {
            ViewFacade::composer('*', function(View $view) {
                $view->with([
                    'theme' => controller()->getTheme(),
                    'page' => controller()->getPage(),
                ]);
            });
        }

        $this->configureLivewire();
        $this->configurePageAuthentication();
        $this->configureGoogleFonts();

        $this->defineRoutes();
    }

    protected function loadLivewireComponentsFrom($path): void
    {
        $configurableComponents = [];

        $components = (new Finder)->files()->in($path)
            ->name('*.php')
            ->ignoreDotFiles(true)
            ->ignoreVCS(true);

        foreach ($components as $component) {
            $componentName = Str::of($component->getRelativePathname())->before('.php')->kebab()->replace(DIRECTORY_SEPARATOR.'-', '.');
            $componentClass = Str::of($component->getRelativePathname())->before('.php')->replace('/', '\\')->start('Igniter\\Orange\\Livewire\\')->toString();

            if (is_subclass_of($componentClass, Component::class)) {
                if (in_array(ConfigurableComponent::class, class_uses_recursive($componentClass))) {
                    $configurableComponents[] = $componentClass;
                } else {
                    Livewire::component('igniter-orange::'.$componentName, $componentClass);
                }
            }
        }

        resolve(ComponentManager::class)->registerCallback(function($manager) use ($configurableComponents) {
            foreach ($configurableComponents as $componentClass) {
                $manager->registerComponent($componentClass, $componentClass::componentMeta());
            }
        });
    }

    protected function loadBladeComponentsFrom($path)
    {
        $components = (new Finder)->files()->in($path)
            ->name('*.php')
            ->ignoreDotFiles(true)
            ->ignoreVCS(true);

        resolve(ComponentManager::class)->registerCallback(function($manager) use ($components) {
            foreach ($components as $component) {
                $componentName = Str::of($component->getRelativePathname())->before('.php')->kebab()->replace(DIRECTORY_SEPARATOR.'-', '.');
                $componentClass = Str::of($component->getRelativePathname())->before('.php')->replace('/', '\\')->start('Igniter\\Orange\\View\\Components\\')->toString();

                if (in_array(ConfigurableComponent::class, class_uses_recursive($componentClass))) {
                    $manager->registerComponent($componentClass, $componentClass::componentMeta());
                } else {
                    Blade::component('igniter-orange::'.$componentName, $componentClass);
                }
            }
        });
    }

    protected function configurePageAuthentication(): void
    {
        if (!Igniter::runningInAdmin()) {
            MainController::extend(function($controller) {
                $controller->bindEvent('page.init', function($page) {
                    if (!isset($page->security) || $page->security == 'all') {
                        return;
                    }

                    $isAuthenticated = Auth::check();
                    if ($page->security == 'customer' && !$isAuthenticated) {
                        return redirect()->guest(page_url('home'));
                    }

                    if ($page->security == 'guest' && $isAuthenticated) {
                        return redirect()->guest(page_url('home'));
                    }
                });
            });
        }

        Event::listen('admin.form.extendFields', function(Form $widget) {
            if (!isset($widget->data->fileSource)) {
                return;
            }

            if (!$widget->data->fileSource instanceof \Igniter\Main\Template\Page) {
                return;
            }

            $widget->addFields([
                'settings[security]' => [
                    'tab' => 'igniter::system.themes.text_tab_meta',
                    'label' => 'igniter.orange::default.label_security',
                    'type' => 'checkboxtoggle',
                    'default' => 'all',
                    'span' => 'right',
                    'options' => [
                        'all' => 'igniter.orange::default.text_all',
                        'customer' => 'igniter.orange::default.text_customer',
                        'guest' => 'igniter.orange::default.text_guest',
                    ],
                    'comment' => 'igniter.orange::default.help_security',
                ],
            ], 'primary');
        });
    }

    protected function configureGoogleFonts(): void
    {
        $this->callAfterResolving(GoogleFonts::class, function(GoogleFonts $googleFonts) {
            $themeData = resolve(ThemeManager::class)->getActiveTheme()->getCustomData();
            if (array_get($themeData, 'font-download')) {
                config()->set('google-fonts.fonts.default', array_get($themeData, 'font-url'));
            }
        });

        Event::listen('assets.combiner.afterBuildBundles', function(Assets $assets, Theme $theme) {
            if (array_get($theme->getCustomData(), 'font-download')) {
                config()->set('google-fonts.fonts.default', array_get($theme->getCustomData(), 'font-url'));

                app(GoogleFonts::class)->load('default', forceDownload: true);
            }
        });
    }

    protected function defineRoutes(): void
    {
        Route::middleware(config('igniter-routes.middleware', []))
            ->domain(config('igniter-routes.domain'))
            ->name('igniter.theme.')
            ->prefix(Igniter::uri())
            ->group(function($router) {
                $router->get('logout', Logout::class)->name('account.logout');
            });
    }

    protected function configureLivewire(): void
    {
        Livewire::addPersistentMiddleware([
            CheckLocation::class,
            CartMiddleware::class,
        ]);

        config()->set('livewire.pagination_theme', 'bootstrap');
    }
}
