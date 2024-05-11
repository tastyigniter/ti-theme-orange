<?php

namespace Igniter\Orange\Livewire;

use Igniter\Frontend\Models\CaptchaSettings;
use Livewire\Component;

class Captcha extends Component
{
    public string $apiKey = '';

    public string $lang = '';

    public string $version = '';

    public string $theme = '';

    public function mount()
    {
        $this->apiKey = CaptchaSettings::get('api_site_key');
        $this->lang = CaptchaSettings::get('lang', 'en');
        $this->version = CaptchaSettings::get('version', 'v2');
        $this->theme = CaptchaSettings::get('theme', 'light');
    }

    public function render()
    {
        return view('igniter-orange::livewire.captcha');
    }
}
