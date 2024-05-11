<?php

namespace Igniter\Orange\Http\Controllers;

use Igniter\User\Actions\LogoutUser;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;

class Logout extends Controller
{
    public function __invoke()
    {
        resolve(LogoutUser::class)->handle();

        return Redirect::back();
    }
}
