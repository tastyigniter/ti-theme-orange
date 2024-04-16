<?php

namespace Igniter\Frontend\Components;

use Igniter\Frontend\Models\CaptchaSettings;
use System\Classes\BaseComponent;

class Captcha extends BaseComponent
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
