<?php

namespace Igniter\Orange\Tests;

use Igniter\Main\Classes\ThemeManager;
use Spatie\GoogleFonts\GoogleFontsServiceProvider;

abstract class TestCase extends \SamPoyigi\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        $app->booted(function($app) {
            $themeManager = $app[ThemeManager::class];
            $theme = $themeManager->loadTheme(__DIR__.'/../');
            $themeManager->bootTheme($theme);
        });

        return array_merge(parent::getPackageProviders($app), [
            GoogleFontsServiceProvider::class,
            \Igniter\Orange\ServiceProvider::class,
        ]);
    }
}
