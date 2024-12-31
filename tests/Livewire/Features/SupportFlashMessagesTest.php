<?php

namespace Igniter\Orange\Tests\Livewire\Features;

use Igniter\Orange\Livewire\Features\SupportFlashMessages;

it('handles exception and stops propagation when not in debug mode', function() {
    config()->set('app.debug', false);
    $component = new SupportFlashMessages();

    $stopPropagation = function() {
        return true;
    };

    $e = new \Exception('Test exception');
    $component->exception($e, $stopPropagation);

    expect(flash()->messages())->toHaveCount(1);
});

it('does not dispatch flash messages on dehydrate when not a livewire request', function() {
    $component = new SupportFlashMessages();

    $context = [];
    $result = $component->dehydrate($context);

    expect($result)->toBeNull();
});

it('dispatches flash messages on dehydrate', function() {
    request()->headers->set('X-Livewire', true);

    $component = new SupportFlashMessages();
    $component->setComponent(new class
    {
        public function dispatch($event, $messages)
        {
            expect($event)->toBe('flashMessageAdded')
                ->and($messages)->toHaveCount(1);
        }
    });

    flash()->error('Test error message');

    $context = [];
    $component->dehydrate($context);
});
