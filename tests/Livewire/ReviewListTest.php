<?php

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Admin\Classes\FormField;
use Igniter\Admin\Widgets\Form;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Main\Http\Controllers\Themes;
use Igniter\Main\Models\Theme;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Orange\Livewire\Concerns\WithReviews;
use Igniter\Orange\Livewire\ReviewList;
use Livewire\Livewire;

it('initialize component correctly', function() {
    $component = new ReviewList();

    expect(class_uses_recursive($component))
        ->toContain(ConfigurableComponent::class, WithReviews::class)
        ->and($component->itemPerPage)->toBe(20)
        ->and($component->sortOrder)->toBe('created_at desc');
});

it('returns correct component meta', function() {
    $meta = ReviewList::componentMeta();

    expect($meta['code'])->toBe('igniter-orange::review-list')
        ->and($meta['name'])->toBe('igniter.orange::default.component_review_list_title')
        ->and($meta['description'])->toBe('igniter.orange::default.component_review_list_desc');
});

it('defines properties correctly', function() {
    $component = new ReviewList();
    $properties = $component->defineProperties();

    expect(array_keys($properties))->toContain(
        'itemPerPage',
        'sortOrder',
    );
});

it('returns correct sorted order options', function() {
    $form = new Form(resolve(Themes::class), [
        'model' => new Theme,
    ]);
    $field = new FormField('sortOrder', 'Sort Order');
    $field->displayAs('select', [
        'property' => 'sortOrder',
    ]);

    $options = ReviewList::getPropertyOptions($form, $field);

    expect($options)->toBeArray()->not->toBeEmpty();
});

it('returns empty array for unknown property', function() {
    $form = new Form(resolve(Themes::class), [
        'model' => new Theme,
    ]);
    $field = new FormField('unknown', 'Unknown');
    $field->displayAs('text', [
        'property' => 'unknown',
    ]);

    $options = ReviewList::getPropertyOptions($form, $field);

    expect($options)->toBe([]);
});

it('mounts and renders correctly', function() {
    $location = LocationModel::factory()->create();
    Location::setModel($location);

    Livewire::test(ReviewList::class)->assertSee('Customer reviews');
});
