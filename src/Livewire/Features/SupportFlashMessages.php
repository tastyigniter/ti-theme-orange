<?php

namespace Igniter\Orange\Livewire\Features;

use Igniter\Flame\Flash\Message;
use Illuminate\Validation\ValidationException;
use Livewire\ComponentHook;
use Livewire\Mechanisms\HandleRequests\HandleRequests;

class SupportFlashMessages extends ComponentHook
{
    public function exception($e, $stopPropagation)
    {
        if (!config('app.debug') && !app()->runningUnitTests() && !$e instanceof ValidationException) {
            flash()->error($e->getMessage())->important();
            $stopPropagation();
        }
    }

    public function dehydrate($context)
    {
        if (!app(HandleRequests::class)->isLivewireRequest()) {
            return;
        }

        $messages = app('flash')->all();

        if ($messages->isNotEmpty()) {
            $this->component->dispatch('flashMessageAdded', $messages->map(function(Message $message) {
                return (object)$message->toArray();
            })->all());
        }
    }
}
