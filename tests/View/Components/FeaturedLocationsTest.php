<?php

declare(strict_types=1);

namespace Igniter\Orange\Tests\View\Components;

use Igniter\Local\Classes\FeaturedLocations as FeaturedLocationIds;
use Igniter\Local\Models\Location;
use Igniter\Orange\View\Components\FeaturedLocations;
use Illuminate\Support\Facades\Event;

beforeEach(fn() => resolve(FeaturedLocationIds::class)->clearCache());
afterEach(fn() => resolve(FeaturedLocationIds::class)->clearCache());

it('returns component meta and properties', function(): void {
    expect(FeaturedLocations::componentMeta()['code'])->toBe('igniter-orange::featured-locations')
        ->and(array_keys((new FeaturedLocations)->defineProperties()))->toBe(['title', 'limit', 'itemsPerRow', 'showThumb', 'menusPage']);
});

it('shows up to the limit of enabled featured locations', function(): void {
    $featured = Location::factory()->count(3)->create(['location_status' => true]);
    $disabled = Location::factory()->create(['location_status' => false]);
    Location::factory()->create(['location_name' => 'Not featured', 'location_status' => true]);
    Event::listen('igniter.local.featuredLocationIds', fn(): array => [...$featured->modelKeys(), $disabled->getKey()]);

    $locations = (new FeaturedLocations(limit: 2))->loadLocations();

    expect($locations)->toHaveCount(2)
        ->and(array_diff($locations->pluck('id')->all(), $featured->modelKeys()))->toBe([]);
});

it('renders nothing without featured locations', function(): void {
    expect((new FeaturedLocations)->loadLocations())->toBeEmpty();
});

it('renders featured locations', function(): void {
    $location = Location::factory()->create(['location_name' => 'Starry Kitchen', 'location_status' => true]);
    Event::listen('igniter.local.featuredLocationIds', fn(): array => [$location->getKey()]);

    $this->blade('<x-igniter-orange::featured-locations />')
        ->assertSee('Starry Kitchen')
        ->assertSee(lang('igniter.orange::default.text_featured'));
});
