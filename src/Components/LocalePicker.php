<?php

namespace Igniter\Orange\Components;

use Igniter\System\Classes\BaseComponent;
use Igniter\System\Models\Language;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class LocalePicker extends BaseComponent
{
    /**
     * @var \Igniter\Flame\Translation\Localization Translator object.
     */
    protected $localization;

    /**
     * @var array Collection of supported locales.
     */
    public $locales;

    /**
     * @var string The active locale code.
     */
    public $activeLocale;

    /**
     * @var string The active locale name.
     */
    public $activeLocaleName;

    /**
     * @var string The active locale code before switching.
     */
    public $oldLocale;

    public function initialize()
    {
        $this->localization = app('translator.localization');
    }

    public function onRun()
    {
        if ($redirect = $this->redirectForceUrl()) {
            return $redirect;
        }

        $this->addCss('css/locale-picker.css');

        $this->locales = Language::listSupported();
        $this->activeLocale = $this->localization->getLocale();
        $this->activeLocaleName = array_get($this->locales, $this->activeLocale);
    }

    public function onSwitchLocale()
    {
        if (!$locale = post('locale')) {
            return;
        }

        $this->oldLocale = $this->localization->getLocale();

        $this->localization->setLocale($locale);

        return Redirect::to($this->controller->currentPageUrl());
    }

    protected function redirectForceUrl()
    {
        if (Request::ajax() || $this->localization->loadLocaleFromRequest()) {
            return;
        }
    }
}
