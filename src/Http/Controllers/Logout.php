<?php

namespace Igniter\Orange\Http\Controllers;

use Igniter\User\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Redirect;

class Logout extends Controller
{
    public function __invoke()
    {
        $user = Auth::getUser();

        Auth::logout();

        session()->invalidate();

        session()->regenerateToken();

        if ($user) {
            Event::fire('igniter.user.logout', [$user]);
        }

        flash()->success(lang('igniter.user::default.alert_logout_success'));

        return Redirect::back();
    }
}