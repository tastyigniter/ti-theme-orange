<?php

namespace Igniter\Orange\Http\Controllers;

use Igniter\Cart\Facades\Cart;
use Igniter\User\Actions\LogoutCustomer;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;

class Logout extends Controller
{
    public function __invoke()
    {
        Cart::keepSession(function() {
            resolve(LogoutCustomer::class)->handle();
        });

        return Redirect::back();
    }
}
