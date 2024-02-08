<?php

namespace Igniter\Orange\Livewire;

use Igniter\Frontend\Models\CaptchaSettings;
use Livewire\Component;

class Captcha extends Component
{
    /**
     * Settings instance
     * @var \Igniter\Frontend\Models\CaptchaSettings
     */
    public $settings;

    /**
     * Prepares variables for the widget rendering
     */
    public function onRun()
    {
        $this->settings = CaptchaSettings::instance();
        $this->page['captchaSettings'] = $this->settings;
    }
}
