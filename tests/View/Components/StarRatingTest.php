<?php

declare(strict_types=1);

namespace Igniter\Orange\Tests\View\Components;

use Igniter\Orange\View\Components\StarRating;
use Illuminate\Support\Facades\Blade;

it('initializes star rating component correctly', function(): void {
    $component = new StarRating('rating', 4.5, 5, true);

    expect($component->name)->toBe('rating')
        ->and($component->score)->toBe(4.5)
        ->and($component->max)->toBe(5.0)
        ->and($component->readOnly)->toBeTrue();
});

it('renders view with hints', function(): void {
    $view = (new StarRating)->render();

    expect($view->getData()['hints'])->toBe(['Poor', 'Average', 'Good', 'Very Good', 'Excellent']);
});

it('renders all stars filled for a full score', function(): void {
    $html = Blade::render('<x-igniter-orange::star-rating name="rating" :score="5.0" />');

    expect(substr_count($html, 'class="fa-star fa"'))->toBe(5)
        ->and($html)->not->toContain('class="fa-star fa far"')
        ->and($html)->not->toContain('class="fa-star far"');
});
