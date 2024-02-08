<?php

namespace Igniter\Orange\View\Components\Forms;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Form extends Component
{
    /** @var string|null */
    public $action;

    /** @var string */
    public $method;

    /** @var bool */
    public $hasFiles;

    public function __construct(?string $action = null, string $method = 'POST', bool $hasFiles = false)
    {
        $this->action = $action;
        $this->method = strtoupper($method);
        $this->hasFiles = $hasFiles;
    }

    public function render(): View
    {
        return view('igniter-orange::components.forms.form');
    }
}
