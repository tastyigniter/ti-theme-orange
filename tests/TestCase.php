<?php

namespace Igniter\Orange\Tests;

use Igniter\Main\Classes\ThemeManager;

abstract class TestCase extends \SamPoyigi\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        $app->booted(function($app) {
            $themeManager = $app[ThemeManager::class];
            $theme = $themeManager->loadTheme(__DIR__.'/../');
            $themeManager->bootTheme($theme);
        });

        return parent::getPackageProviders($app);
    }
}
