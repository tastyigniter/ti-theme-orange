<?php

declare(strict_types=1);

namespace Igniter\Orange\Livewire\Utils;

use stdClass;
use Igniter\Flame\Flash\Facades\Flash;
use Igniter\Flame\Flash\Message;
use Livewire\Component;

final class FlashMessage extends Component
{
    public array $messages = [];

    public function mount(): void
    {
        $this->messages = Flash::all()->map(fn(Message $message): stdClass => (object)$message->toArray())->all();
    }

    public function render()
    {
        return view('igniter-orange::livewire.utils.flash-message');
    }
}
