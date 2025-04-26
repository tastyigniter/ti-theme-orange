<?php

declare(strict_types=1);

namespace Igniter\Orange\Tests\Livewire\Features;

use Exception;
use Igniter\Orange\Livewire\Features\SupportFlashMessages;
use Livewire\Features\SupportRedirects\Redirector;
use Livewire\Mechanisms\HandleComponents\ComponentContext;

it('handles exception and stops propagation when not in debug mode', function(): void {
    config()->set('app.debug', false);
    $component = new SupportFlashMessages;

    $stopPropagation = fn(): true => true;

    $e = new Exception('Test exception');
    $component->exception($e, $stopPropagation);

    expect(flash()->messages())->toHaveCount(1);
});

it('does not dispatch flash messages event on dehydrate when not a livewire request', function(): void {
    $component = new SupportFlashMessages;

    $context = [];
    $result = $component->dehydrate($context);

    expect($result)->toBeNull();
});

it('does not dispatch flash messages event on livewire request redirect', function(): void {
    request()->headers->set('X-Livewire', 'true');

    $component = new SupportFlashMessages;

    $context = new ComponentContext(null, false);
    $context->effects = [
        'returns' => [
            new Redirector(resolve('url')),
        ],
    ];
    $result = $component->dehydrate($context);

    expect($result)->toBeNull();
});

it('dispatches flash messages on dehydrate', function(): void {
    request()->headers->set('X-Livewire', 'true');

    $component = new SupportFlashMessages;
    $component->setComponent(new class
    {
        public function dispatch($event, $messages): void
        {
            expect($event)->toBe('flashMessageAdded')
                ->and($messages)->toHaveCount(1);
        }
    });

    flash()->error('Test error message');

    $context = [];
    $component->dehydrate($context);
});
