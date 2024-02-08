<?php

namespace Igniter\Orange\View\Components;

use Illuminate\View\Component;

class AccountLinks extends Component
{
    public function __construct(public string $activePage = '')
    {
        $this->activePage = controller()->getPage()->getId();
    }

    public function render()
    {
        return view('igniter-orange::components.account-links');
    }
}
