<?php

declare(strict_types=1);

namespace Igniter\Orange\Livewire\Features;

use Igniter\Flame\Flash\Message;
use Illuminate\Validation\ValidationException;
use Livewire\ComponentHook;
use Livewire\Mechanisms\HandleRequests\HandleRequests;
use stdClass;

final class SupportFlashMessages extends ComponentHook
{
    public function exception($e, $stopPropagation): void
    {
        if (!config('app.debug') && !$e instanceof ValidationException) {
            flash()->error($e->getMessage())->important();
            $stopPropagation();
        }
    }

    public function dehydrate($context): void
    {
        if (!app(HandleRequests::class)->isLivewireRequest()) {
            return;
        }

        $messages = app('flash')->all();

        if ($messages->isNotEmpty()) {
            $this->component->dispatch('flashMessageAdded', $messages->map(fn(Message $message): stdClass => (object)$message->toArray())->all());
        }
    }
}
