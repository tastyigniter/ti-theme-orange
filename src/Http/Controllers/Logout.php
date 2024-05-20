<?php

namespace Igniter\Orange\Http\Controllers;

use Igniter\Cart\Facades\Cart;
use Igniter\User\Actions\LogoutUser;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;

class Logout extends Controller
{
    public function __invoke()
    {
        Cart::keepSession(function() {
            resolve(LogoutUser::class)->handle();
        });

        return Redirect::back();
    }
}
