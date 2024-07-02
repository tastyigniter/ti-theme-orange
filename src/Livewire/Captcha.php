<?php

namespace Igniter\Orange\Livewire;

use Igniter\Frontend\Models\CaptchaSettings;
use Igniter\Main\Traits\ConfigurableComponent;
use Livewire\Component;

class Captcha extends Component
{
    use ConfigurableComponent;

    public string $apiKey = '';

    public string $lang = '';

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::captcha',
            'name' => 'igniter.orange::default.component_captcha_title',
            'description' => 'igniter.orange::default.component_captcha_desc',
        ];
    }

    public function mount()
    {
        $this->apiKey = CaptchaSettings::get('api_site_key', '');
        $this->lang = CaptchaSettings::get('lang', 'en');
    }

    public function render()
    {
        return view('igniter-orange::livewire.captcha');
    }
}
