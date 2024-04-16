<?php

namespace Igniter\Frontend\Models;

use Igniter\Flame\Database\Model;

class CaptchaSettings extends Model
{
    public $implement = [\System\Actions\SettingsModel::class];

    // A unique code
    public $settingsCode = 'igniter_frontend_captchasettings';

    // Reference to field configuration
    public $settingsFieldsConfig = 'captchasettings';
}
