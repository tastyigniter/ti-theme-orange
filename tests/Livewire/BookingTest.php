<?php

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Cart\Classes\AbstractOrderType;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Local\Models\WorkingHour;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\Orange\Livewire\Booking;
use Igniter\User\Models\Customer;
use Livewire\Livewire;

beforeEach(function() {
    $location = LocationModel::factory()->create();
    $orderTypeMock = $this->mock(AbstractOrderType::class);
    $orderTypeMock->shouldReceive('getSchedule')->andReturn($location->newWorkingSchedule(LocationModel::DELIVERY, 5));
    $orderTypeMock->shouldReceive('getCode')->andReturn(LocationModel::DELIVERY);
    Location::shouldReceive('current')->andReturn($location);
    Location::shouldReceive('getOrderType')->andReturn($orderTypeMock);
});

it('initialize component correctly', function() {
    $component = new Booking();

    expect(class_uses_recursive($component))
        ->toContain(ConfigurableComponent::class, UsesPage::class)
        ->and(Booking::STEP_PICKER)->toBe('picker')
        ->and(Booking::STEP_TIMESLOT)->toBe('timeslot')
        ->and(Booking::STEP_BOOKING)->toBe('booking')
        ->and($component->useCalendarView)->toBeTrue()
        ->and($component->telephoneIsRequired)->toBeTrue()
        ->and($component->weekStartOn)->toBe(0)
        ->and($component->minGuestSize)->toBe(2)
        ->and($component->maxGuestSize)->toBe(20)
        ->and($component->noOfSlots)->toBe(6)
        ->and($component->successPage)->toBe('reservation.success')
        ->and($component->calendarLocale)->toBeNull()
        ->and($component->pickerStep)->toBe('start')
        ->and($component->date)->toBeNull()
        ->and($component->guest)->toBeNull()
        ->and($component->time)->toBeNull();
});

it('returns correct component meta', function() {
    $meta = Booking::componentMeta();

    expect($meta['code'])->toBe('igniter-orange::booking')
        ->and($meta['name'])->toBe('igniter.orange::default.component_booking_title')
        ->and($meta['description'])->toBe('igniter.orange::default.component_booking_desc');
});

it('defines properties correctly', function() {
    $component = new Booking();
    $properties = $component->defineProperties();

    expect(array_keys($properties))->toContain(
        'useCalendarView',
        'weekStartOn',
        'minGuestSize',
        'maxGuestSize',
        'noOfSlots',
        'telephoneIsRequired',
        'successPage',
    );
});

it('mounts as customer correctly', function() {
    app()->setLocale('fr');
    $this->customer = Customer::factory()->create();
    $component = Livewire::actingAs($this->customer, 'igniter-customer')
        ->test(Booking::class)
        ->assertNotSet('startDate', null)
        ->assertNotSet('endDate', null)
        ->assertNotSet('guest', null)
        ->assertNotSet('date', null)
        ->assertSet('form.firstName', $this->customer->first_name)
        ->assertSet('form.lastName', $this->customer->last_name)
        ->assertSet('form.email', $this->customer->email)
        ->assertSet('form.telephone', $this->customer->telephone);

    expect($component->get('guest'))->toBe($component->get('minGuestSize'));
});

it('mounts as guest correctly', function() {
    $component = Livewire::test(Booking::class)
        ->assertNotSet('startDate', null)
        ->assertNotSet('endDate', null)
        ->assertNotSet('guest', null)
        ->assertNotSet('date', null)
        ->assertSet('form.firstName', null)
        ->assertSet('form.lastName', null)
        ->assertSet('form.email', null)
        ->assertSet('form.telephone', null);

    expect($component->get('guest'))->toBe($component->get('minGuestSize'));
});

it('updates date and reset timeslots', function() {
    $component = Livewire::test(Booking::class);

    expect($component->get('timeslots')->isNotEmpty())->toBeTrue();

    $component->set('date', '2022-12-31');

    expect($component->get('timeslots')->isEmpty())->toBeTrue();
});

it('returns reduced timeslots', function() {
    $component = Livewire::test(Booking::class);

    expect($component->get('reducedTimeslots'))->toHaveLength($component->get('noOfSlots'));
});

it('returns disabled dates', function() {
    Location::current()->reloadRelations();

    WorkingHour::query()
        ->where('type', LocationModel::OPENING)
        ->where('weekday', 1)
        ->update(['status' => 0]);

    $component = Livewire::test(Booking::class);

    expect($component->get('disabledDates'))->not->toBeEmpty();
});

it('returns available dates', function() {
    Location::current()->reloadRelations();

    $component = Livewire::test(Booking::class);

    expect($component->get('dates'))->toHaveCount(29);
});

it('saves and validate booking', function() {
    Livewire::test(Booking::class)
        ->set('guest', 5)
        ->set('date', '2022-12-31')
        ->set('time', '12:00')
        ->call('onSave')
        ->assertSet('pickerStep', Booking::STEP_TIMESLOT);
});

it('selects time and move to booking step', function() {
    Livewire::test(Booking::class)
        ->set('guest', 5)
        ->set('date', '2022-12-31')
        ->set('time', '12:00')
        ->call('onSelectTime', '12:00')
        ->assertSet('pickerStep', Booking::STEP_BOOKING);
});

it('completes booking and reset', function() {
    Livewire::test(Booking::class)
        ->set('guest', 5)
        ->set('date', '2022-12-31')
        ->set('time', '12:00')
        ->set('form.firstName', 'John')
        ->set('form.lastName', 'Doe')
        ->set('form.email', 'john@email.com')
        ->set('form.telephone', '1234567890')
        ->call('onComplete')
        ->assertRedirect()
        ->assertSet('guest', null)
        ->assertSet('date', null)
        ->assertSet('time', null);
});
