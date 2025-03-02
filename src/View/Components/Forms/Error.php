<?php

namespace Igniter\Orange\View\Components\Forms;

use Illuminate\Support\ViewErrorBag;
use Illuminate\View\Component;
use Illuminate\View\View;

class Error extends Component
{
    public function __construct(public string $field, public string $bag = 'default')
    {
    }

    public function render(): View
    {
        return view('igniter-orange::components.forms.error');
    }

    public function messages(ViewErrorBag $errors): array
    {
        $bag = $errors->getBag($this->bag);

        return $bag->has($this->field) ? $bag->get($this->field) : [];
    }
}
