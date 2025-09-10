<?php

declare(strict_types=1);

namespace Igniter\Orange\Tests\Contracts;

use Igniter\Orange\Contracts\ModalComponent;
use InvalidArgumentException;
use Livewire\Features\SupportEvents\Event;

it('closes modal with events', function(): void {
    $modalComponent = new class extends ModalComponent
    {
        public function dispatch($event, ...$params): Event
        {
            expect(in_array($event, ['closeModal', 'event1', 'event2']))->toBeTrue();

            if ($event === 'closeModal') {
                expect($params)->toHaveCount(3)
                    ->and($params)->toBe(['force' => true, 'skipPreviousModals' => 2, 'destroySkipped' => true]);
            }

            if ($event === 'event1') {
                expect($params)->toHaveCount(1)
                    ->and($params)->toBe(['param1']);
            }

            if ($event === 'event2') {
                expect($params)->toHaveCount(1)
                    ->and($params)->toBe(['param2']);
            }

            return new Event($event, $params);
        }
    };

    $modalComponent->destroySkippedModals()
        ->skipPreviousModals(2, true)
        ->forceClose();

    $modalComponent->closeModalWithEvents([
        'component' => ['event1', ['param1']],
        ['event2', ['param2']],
    ]);
});

it('returns correct modal max width class', function(): void {
    config()->set('igniter-orange.modal_defaults.modal_max_width', 'lg');

    $class = ModalComponent::modalMaxWidthClass();

    expect($class)->toBe('sm:max-w-md md:max-w-lg');
});

it('throws exception for invalid modal max width', function(): void {
    config()->set('igniter-orange.modal_defaults.modal_max_width', 'invalid');

    expect(fn(): string => ModalComponent::modalMaxWidthClass())
        ->toThrow(InvalidArgumentException::class, 'Modal max width [invalid] is invalid.');
});

it('returns correct close modal on click away setting', function(): void {
    config()->set('igniter-orange.modal_defaults.close_modal_on_click_away', false);

    $result = ModalComponent::closeModalOnClickAway();

    expect($result)->toBeFalse();
});

it('returns correct close modal on escape setting', function(): void {
    config()->set('igniter-orange.modal_defaults.close_modal_on_escape', false);

    $result = ModalComponent::closeModalOnEscape();

    expect($result)->toBeFalse();
});

it('returns correct close modal on escape is forceful setting', function(): void {
    config()->set('igniter-orange.modal_defaults.close_modal_on_escape_is_forceful', false);

    $result = ModalComponent::closeModalOnEscapeIsForceful();

    expect($result)->toBeFalse();
});

it('returns correct dispatch close event setting', function(): void {
    config()->set('igniter-orange.modal_defaults.dispatch_close_event', true);

    $result = ModalComponent::dispatchCloseEvent();

    expect($result)->toBeTrue();
});

it('returns correct destroy on close setting', function(): void {
    config()->set('igniter-orange.modal_defaults.destroy_on_close', true);

    $result = ModalComponent::destroyOnClose();

    expect($result)->toBeTrue();
});
