<?php

namespace Igniter\Orange\Livewire\Pages;

use Igniter\Cart\Facades\Cart;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\User\Facades\AdminAuth;
use Illuminate\Support\Facades\Redirect;

class LocalMenu extends \Livewire\Component
{
    public bool $forceRedirect = true;

    public string $defaultLocationParam = 'local';

    public string $localNotFoundPage = 'home';

    public string $goBackPage = 'locations';

    public string $cartPage = 'cart';

    public ?float $cartTotal = null;

    public function render()
    {
        return view('igniter-orange::livewire.pages.local-menu');
    }

    public function mount()
    {
        $this->cartTotal = Cart::total();

        if ($redirect = $this->checkLocationParam()) {
            return $redirect;
        }

        if ($this->currentLocationIsDisabled()) {
            flash()->error(lang('igniter.local::default.alert_location_required'));

            return Redirect::to(page_url($this->property('redirect')));
        }
    }

    protected function checkLocationParam()
    {
        if (!$this->forceRedirect) {
            return;
        }

        $param = request()->route()->parameter('location', $this->defaultLocationParam);
        if (is_single_location() && $param === $this->defaultLocationParam) {
            return;
        }

        if (LocationModel::whereSlug($param)->whereIsEnabled()->exists()) {
            return;
        }

        //        return $this->redirect(page_url($this->localNotFoundPage));
    }

    protected function currentLocationIsDisabled()
    {
        return !Location::current()?->isEnabled() && !AdminAuth::getUser()?->hasPermission('Admin.Locations');
    }
}
