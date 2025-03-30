<?php

declare(strict_types=1);

namespace Igniter\Orange\Tests\Data;

use Carbon\Carbon;
use Igniter\Cart\Classes\AbstractOrderType;
use Igniter\Cart\Classes\OrderTypes;
use Igniter\Local\Classes\CoveredArea;
use Igniter\Local\Classes\ScheduleItem;
use Igniter\Local\Classes\WorkingSchedule;
use Igniter\Local\Facades\Location as LocationFacade;
use Igniter\Local\Models\Location;
use Igniter\Local\Models\LocationArea;
use Igniter\Orange\Data\LocationData;
use Illuminate\Support\Collection;

beforeEach(function(): void {
    $this->model = mock(Location::class)->makePartial();
    $this->model->shouldReceive('getKey')->andReturn(1);
    $this->model->shouldReceive('getName')->andReturn('Test Location');
    $this->model->shouldReceive('getDescription')->andReturn('Test Description');
    $this->model->shouldReceive('getAddress')->andReturn(['address' => '123 Test St']);
    $this->model->shouldReceive('hasDelivery')->andReturn(true);
    $this->model->shouldReceive('hasCollection')->andReturn(true);
    $this->model->shouldReceive('newWorkingSchedule')->andReturn(mock(WorkingSchedule::class));
    $this->model->shouldReceive('getAttribute')->with('permalink_slug')->andReturn('test-location');
});

it('initializes location data correctly', function(): void {
    $locationData = new LocationData($this->model);

    expect($locationData->id)->toBe(1)
        ->and($locationData->name)->toBe('Test Location')
        ->and($locationData->description)->toBe('Test Description')
        ->and($locationData->address)->toBe(['address' => '123 Test St'])
        ->and($locationData->hasDelivery)->toBeTrue()
        ->and($locationData->hasCollection)->toBeTrue()
        ->and($locationData->openingSchedule)->toBeInstanceOf(WorkingSchedule::class);
});

it('returns current location data', function(): void {
    LocationFacade::shouldReceive('current')->andReturn($this->model);

    $locationData = LocationData::current();

    expect($locationData)->toBeInstanceOf(LocationData::class);
});

it('returns correct URL for location page', function(): void {
    $this->model->shouldReceive('getAttribute')->with('permalink_slug')->andReturn('test-location');

    $locationData = new LocationData($this->model);

    $url = $locationData->url('location-page');

    expect($url)->toBe(page_url('location-page', ['location' => 'test-location']));
});

it('returns correct distance', function(): void {
    $this->model->shouldReceive('getAttribute')->with('distance')->andReturn(10);

    $locationData = new LocationData($this->model);

    $distance = $locationData->distance();

    expect($distance)->toBe(10);
});

it('returns gallery collection', function(): void {
    $this->model->shouldReceive('getGallery')->andReturn(collect(['image1.jpg', 'image2.jpg']));

    $locationData = new LocationData($this->model);

    $gallery = $locationData->gallery();

    expect($gallery)->toBeInstanceOf(Collection::class)
        ->and($gallery->all())->toBe(['image1.jpg', 'image2.jpg']);
});

it('returns true if location has gallery', function(): void {
    $this->model->shouldReceive('hasGallery')->andReturn(true);

    $locationData = new LocationData($this->model);

    $hasGallery = $locationData->hasGallery();

    expect($hasGallery)->toBeTrue();
});

it('returns true if location has thumb', function(): void {
    $this->model->shouldReceive('hasMedia')->with('thumb')->andReturn(true);

    $locationData = new LocationData($this->model);

    $hasThumb = $locationData->hasThumb();

    expect($hasThumb)->toBeTrue();
});

it('returns correct thumb URL', function(): void {
    $this->model->shouldReceive('getThumbOrBlank')->with([], null)->andReturn('thumb.jpg');

    $locationData = new LocationData($this->model);

    $thumbUrl = $locationData->getThumb();

    expect($thumbUrl)->toBe('thumb.jpg');
});

it('returns correct order type', function(): void {
    LocationFacade::shouldReceive('getOrderType')->andReturn(mock(AbstractOrderType::class));

    $locationData = new LocationData($this->model);

    $orderType = $locationData->orderType();

    expect($orderType)->toBeInstanceOf(AbstractOrderType::class);
});

it('returns correct last order time', function(): void {
    $workingSchedule = mock(WorkingSchedule::class);
    $workingSchedule->shouldReceive('getCloseTime')->andReturn('2023-12-31 23:59:59');
    $orderType = mock(AbstractOrderType::class);
    $orderType->shouldReceive('getSchedule')->andReturn($workingSchedule);
    LocationFacade::shouldReceive('getOrderType')->andReturn($orderType);

    $locationData = new LocationData($this->model);
    $lastOrderTime = $locationData->lastOrderTime();

    expect($lastOrderTime)->toBeInstanceOf(Carbon::class)
        ->and($lastOrderTime->toDateTimeString())->toBe('2023-12-31 23:59:59');
});

it('returns correct order types collection', function(): void {
    $this->model->shouldReceive('availableOrderTypes')->andReturn(collect(['delivery', 'collection']));

    $locationData = new LocationData($this->model);

    $orderTypes = $locationData->orderTypes();

    expect($orderTypes)->toBeInstanceOf(Collection::class)
        ->and($orderTypes->all())->toBe(['delivery', 'collection']);
});

it('returns correct reviews score', function(): void {
    $model = Location::factory()->create();
    $model->reviews()->create([
        'customer_id' => 1,
        'quality' => 5,
        'service' => 5,
        'delivery' => 4,
        'review_status' => true,
    ]);

    $locationData = new LocationData($model);

    $reviewsScore = $locationData->reviewsScore();

    expect(round($reviewsScore, 1))->toBe(4.7);
});

it('returns correct reviews count', function(): void {
    $this->model->shouldReceive('getAttribute')->with('reviews_count')->andReturn(10);

    $locationData = new LocationData($this->model);

    $reviewsCount = $locationData->reviewsCount();

    expect($reviewsCount)->toBe(10);
});

it('returns delivery areas collection', function(): void {
    $locationArea = LocationArea::factory()->create();
    $this->model->shouldReceive('listDeliveryAreas')->andReturn(collect([$locationArea]));

    $locationData = new LocationData($this->model);

    $deliveryAreas = $locationData->deliveryAreas();

    expect($deliveryAreas)->toBeInstanceOf(Collection::class)
        ->and($deliveryAreas->first())->toBeInstanceOf(CoveredArea::class);
});

it('returns correct payments array', function(): void {
    $this->model->shouldReceive('listAvailablePayments')->andReturn(collect([['name' => 'Cash'], ['name' => 'Card']]));

    $locationData = new LocationData($this->model);

    $locationData->payments();

    // Call again to test cache
    $payments = $locationData->payments();

    expect($payments)->toBe(['Cash', 'Card']);
});

it('returns schedules collection grouped by day', function(): void {
    $this->model->shouldReceive('getWorkingHours')->andReturn(collect([
        (object)['day' => Carbon::now()->startOfWeek(), 'hours' => '9:00-17:00'],
        (object)['day' => Carbon::now()->startOfWeek()->addDay(), 'hours' => '10:00-18:00'],
    ]));

    $locationData = new LocationData($this->model);

    $schedules = $locationData->schedules();

    expect($schedules)->toBeInstanceOf(Collection::class)
        ->and($schedules->keys()->all())->toBe([
            Carbon::now()->startOfWeek()->isoFormat('dddd'),
            Carbon::now()->startOfWeek()->addDay()->isoFormat('dddd'),
        ]);
});

it('returns correct schedule types array', function(): void {
    $orderTypes = mock(OrderTypes::class);
    $orderTypes->shouldReceive('listOrderTypes')->andReturn([
        'delivery' => ['name' => 'Delivery'],
        'collection' => ['name' => 'Collection'],
    ]);
    app()->instance(OrderTypes::class, $orderTypes);

    $locationData = new LocationData($this->model);

    $scheduleTypes = $locationData->scheduleTypes();

    expect($scheduleTypes)->toBeArray()
        ->and($scheduleTypes)->toHaveKey(Location::OPENING)
        ->and($scheduleTypes[Location::OPENING]['name'])->toBe('igniter.local::default.text_opening');
});

it('returns correct schedule items array', function(): void {
    $scheduleItem = ScheduleItem::create('delivery', [
        'type' => 'daily',
        'open' => '09:00',
        'close' => '17:00',
    ]);
    $this->model->shouldReceive('createScheduleItem')->andReturn($scheduleItem);
    $orderTypes = mock(OrderTypes::class);
    $orderTypes->shouldReceive('listOrderTypes')->andReturn([
        'delivery' => ['name' => 'Delivery'],
        'collection' => ['name' => 'Collection'],
    ]);
    app()->instance(OrderTypes::class, $orderTypes);

    $locationData = new LocationData($this->model);

    $scheduleItems = $locationData->scheduleItems();

    expect($scheduleItems)->toBeArray()
        ->and($scheduleItems)->toHaveKeys([Location::OPENING, Location::DELIVERY, Location::COLLECTION])
        ->and($scheduleItems[Location::OPENING]['Mon'])->toBeArray()
        ->and($scheduleItems[Location::OPENING]['Mon'][0]['open'])->toBe('09:00 am')
        ->and($scheduleItems[Location::OPENING]['Mon'][0]['close'])->toBe('05:00 pm')
        ->and($scheduleItems[Location::OPENING]['Mon'][0]['status'])->toBeTrue();
});

it('returns correct opening schedule', function(): void {
    $workingSchedule = mock(WorkingSchedule::class);
    $this->model->shouldReceive('newWorkingSchedule')->with(Location::OPENING)->andReturn($workingSchedule);

    $locationData = new LocationData($this->model);

    $openingSchedule = $locationData->openingSchedule();

    expect($openingSchedule)->toBeInstanceOf(WorkingSchedule::class);
});
