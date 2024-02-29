<?php

namespace Igniter\Orange;

use Igniter\Cart\Http\Middleware\CartMiddleware;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Igniter;
use Igniter\Local\Http\Middleware\CheckLocation;
use Igniter\Main\Classes\MainController;
use Igniter\Main\Classes\Theme;
use Igniter\Main\Classes\ThemeManager;
use Igniter\Orange\Exceptions\ReportableException;
use Igniter\Orange\Http\Controllers\Logout;
use Igniter\System\Libraries\Assets;
use Igniter\User\Facades\Auth;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Livewire;
use Spatie\GoogleFonts\GoogleFonts;
use Symfony\Component\Finder\Finder;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->app[ExceptionHandler::class]->map(ApplicationException::class, ReportableException::class);
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'igniter-orange');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'igniter.orange');

        Blade::componentNamespace('Igniter\\Orange\\View\\Components', 'igniter-orange');

        $this->loadLivewireComponents();

        Livewire::addPersistentMiddleware([
            CheckLocation::class,
            CartMiddleware::class,
        ]);

        if (!Igniter::runningInAdmin()) {
            ViewFacade::composer('*', function (View $view) {
                $view->with([
                    'theme' => controller()->getTheme(),
                    'page' => controller()->getPage(),
                ]);
            });

            MainController::extend(function ($controller) {
                $controller->bindEvent('page.init', function ($page) {
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

        config()->set('livewire.pagination_theme', 'bootstrap');

        $this->callAfterResolving(GoogleFonts::class, function (GoogleFonts $googleFonts) {
            $themeData = resolve(ThemeManager::class)->getActiveTheme()->getCustomData();
            if (array_get($themeData, 'font-download')) {
                config()->set('google-fonts.fonts.default', array_get($themeData, 'font-url'));
            }
        });

        Event::listen('assets.combiner.afterBuildBundles', function (Assets $assets, Theme $theme) {
            if (array_get($theme->getCustomData(), 'font-download')) {
                config()->set('google-fonts.fonts.default', array_get($theme->getCustomData(), 'font-url'));

                app(GoogleFonts::class)->load('default', forceDownload: true);
            }
        });

        Route::middleware(config('igniter-routes.middleware', []))
            ->domain(config('igniter-routes.domain'))
            ->name('igniter.theme.')
            ->prefix(Igniter::uri())
            ->group(function ($router) {
                $router->get('logout', Logout::class)->name('account.logout');
            });
    }

    protected function loadLivewireComponents(): void
    {
        $components = (new Finder)->files()->in(__DIR__.'/Livewire')
            ->name('*.php')
            ->ignoreDotFiles(true)
            ->ignoreVCS(true);

        foreach ($components as $component) {
            $componentName = Str::of($component->getRelativePathname())->before('.php')->kebab()->replace('/-', '.');
            $componentClass = Str::of($component->getRelativePathname())->before('.php')->replace('/', '\\')->start('Igniter\\Orange\\Livewire\\');

            Livewire::component('igniter-orange::'.$componentName, (string)$componentClass);
        }
    }
}
