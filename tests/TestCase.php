<?php

declare(strict_types=1);

namespace Igniter\Orange\Tests;

use Override;
use Igniter\Orange\ServiceProvider;
use Igniter\Main\Classes\ThemeManager;
use Spatie\GoogleFonts\GoogleFontsServiceProvider;

abstract class TestCase extends \SamPoyigi\Testbench\TestCase
{
    #[Override]
    protected function getPackageProviders($app)
    {
        $app->booted(function(array $app): void {
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
