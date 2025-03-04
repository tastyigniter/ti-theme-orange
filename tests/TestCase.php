<?php

declare(strict_types=1);

namespace Igniter\Orange\Tests;

use Igniter\Main\Classes\ThemeManager;
use Igniter\Orange\ServiceProvider;
use Illuminate\Foundation\Application;
use Override;
use Spatie\GoogleFonts\GoogleFontsServiceProvider;

abstract class TestCase extends \SamPoyigi\Testbench\TestCase
{
    #[Override]
    protected function getPackageProviders($app)
    {
        $app->booted(function(Application $app): void {
            $themeManager = $app[ThemeManager::class];
            $theme = $themeManager->loadTheme(__DIR__.'/../');
            $themeManager->bootTheme($theme);
        });

        return array_merge(parent::getPackageProviders($app), [
            GoogleFontsServiceProvider::class,
            ServiceProvider::class,
        ]);
    }
}
