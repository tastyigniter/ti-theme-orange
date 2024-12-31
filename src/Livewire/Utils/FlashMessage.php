<?php

namespace Igniter\Orange\Livewire\Utils;

use Igniter\Flame\Flash\Facades\Flash;
use Igniter\Flame\Flash\Message;
use Livewire\Component;

class FlashMessage extends Component
{
    public array $messages = [];

    public function mount()
    {
        $this->messages = Flash::all()->map(function(Message $message) {
            return (object)$message->toArray();
        })->all();
    }

    public function render()
    {
        return view('igniter-orange::livewire.utils.flash-message');
    }
}
