<?php

declare(strict_types=1);

namespace Igniter\Orange\Tests\View\Components;

use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Local\Models\Review;
use Igniter\Local\Models\ReviewSettings;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\Orange\Data\LocationData;
use Igniter\Orange\Livewire\Concerns\WithReviews;
use Igniter\Orange\View\Components\LocalHeader;
use Igniter\System\Facades\Assets;

it('initializes local header component correctly', function(): void {
    $component = new LocalHeader(true, 320, 160, 10, 'created_at desc', 'local.reviews');

    expect(class_uses_recursive($component))
        ->toContain(ConfigurableComponent::class, UsesPage::class, WithReviews::class)
        ->and($component->showThumb)->toBeTrue()
        ->and($component->localThumbWidth)->toBe(320)
        ->and($component->localThumbHeight)->toBe(160)
        ->and($component->reviewPerPage)->toBe(10)
        ->and($component->reviewSortOrder)->toBe('created_at desc')
        ->and($component->reviewsPage)->toBe('local.reviews');
});

it('adds js on mount', function(): void {
    Assets::shouldReceive('addCss')->with('igniter.local::/css/starrating.css', 'starrating-css')->once();
    Assets::shouldReceive('addJs')->with('igniter.local::/js/starrating.js', 'starrating-js')->once();

    $component = new LocalHeader;
    $component->mountListReviews();
});

it('returns correct component meta', function(): void {
    $meta = LocalHeader::componentMeta();

    expect($meta['code'])->toBe('igniter-orange::local-header')
        ->and($meta['name'])->toBe('igniter.orange::default.component_local_header_title')
        ->and($meta['description'])->toBe('igniter.orange::default.component_local_header_desc');
});

it('defines properties correctly', function(): void {
    $component = new LocalHeader;
    $properties = $component->defineProperties();

    expect($properties['showThumb']['label'])->toBe('Display the location image thumb.')
        ->and($properties['showThumb']['type'])->toBe('switch')
        ->and($properties['localThumbWidth']['label'])->toBe('Location thumb width')
        ->and($properties['localThumbWidth']['type'])->toBe('number')
        ->and($properties['localThumbHeight']['label'])->toBe('Location thumb height')
        ->and($properties['localThumbHeight']['type'])->toBe('number')
        ->and($properties['reviewPerPage']['label'])->toBe('Number of reviews to display per page')
        ->and($properties['reviewPerPage']['type'])->toBe('number')
        ->and($properties['reviewPerPage']['validationRule'])->toBe('integer|min:1')
        ->and($properties['reviewSortOrder']['label'])->toBe('Default sort order of reviews.')
        ->and($properties['reviewSortOrder']['type'])->toBe('select')
        ->and($properties['reviewSortOrder']['validationRule'])->toBe('required|string')
        ->and($properties['reviewsPage']['label'])->toBe('Page to redirect to when the "see more reviews" link is clicked.')
        ->and($properties['reviewsPage']['type'])->toBe('select')
        ->and($properties['reviewsPage']['validationRule'])->toBe('required|regex:/^[a-z0-9\-_\.]+$/i');
});

it('should render returns true when location is set', function(): void {
    $location = LocationModel::factory()->create();
    Location::shouldReceive('current')->andReturn($location);

    $component = new LocalHeader;
    $shouldRender = $component->shouldRender();

    expect($shouldRender)->toBeTrue();
});

it('should render returns false when location is not set', function(): void {
    Location::shouldReceive('current')->andReturn(null);

    $component = new LocalHeader;
    $shouldRender = $component->shouldRender();

    expect($shouldRender)->toBeFalse();
});

it('renders view with location and review data', function(): void {
    $location = LocationModel::factory()->create();
    Location::shouldReceive('current')->andReturn($location);
    ReviewSettings::set('allow_reviews', true);

    $view = (new LocalHeader)->render();

    expect($view->getData()['locationInfo'])->toBeInstanceOf(LocationData::class)
        ->and($view->getData()['allowReviews'])->toBeTrue();
});

it('lists reviews correctly', function(): void {
    $location = LocationModel::factory()->create();
    Location::shouldReceive('current')->andReturn($location);
    Review::factory()->for($location)->count(5)->create(['review_status' => 1]);

    $reviews = (new LocalHeader)->listReviews();

    expect($reviews->count())->toBe(5);
});

it('lists empty reviews when no current location', function(): void {
    Location::shouldReceive('current')->andReturn(null);

    expect((new LocalHeader)->listReviews())->toBeNull();
});

it('returns order schedule when current page is menus', function(): void {
    $location = LocationModel::factory()->create();
    Location::setModel($location);

    $component = new LocalHeader;
    $component->currentPage = 'local.menus';

    $locationInfo = LocationData::current();
    $schedule = $component->currentSchedule($locationInfo);

    expect($schedule)->toBe($locationInfo->orderType()->getSchedule());
});

it('returns opening schedule when current page is not menus', function(): void {
    $location = LocationModel::factory()->create();
    Location::setModel($location);

    $component = new LocalHeader;
    $component->currentPage = 'local.info';

    $locationInfo = LocationData::current();
    $schedule = $component->currentSchedule($locationInfo);

    expect($schedule)->toBe($locationInfo->openingSchedule());
});

