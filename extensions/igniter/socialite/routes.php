<?php

Route::any('igniter/socialite/{provider}/{action}', [
    'as' => 'igniter_socialite_provider',
    'middleware' => ['web'],
    function ($provider, $action) {
        return \Igniter\Socialite\Classes\ProviderManager::runEntryPoint($provider, $action);
    },
])->where('provider', '[a-zA-Z-]+')->where('action', '[a-zA-Z]+');
