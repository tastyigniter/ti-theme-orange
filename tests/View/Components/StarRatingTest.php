<?php

namespace Igniter\Orange\Tests\View\Components;

use Igniter\Orange\View\Components\StarRating;

it('initializes star rating component correctly', function() {
    $component = new StarRating('rating', 4.5, 5, true);

    expect($component->name)->toBe('rating')
        ->and($component->score)->toBe(4.5)
        ->and($component->max)->toBe(5.0)
        ->and($component->readOnly)->toBeTrue();
});

it('renders view with hints', function() {
    $view = (new StarRating)->render();

    expect($view->getData()['hints'])->toBe(['Poor', 'Average', 'Good', 'Very Good', 'Excellent']);
});
