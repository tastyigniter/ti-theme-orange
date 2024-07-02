<?php

namespace Igniter\Orange\Tests;

it('renders homepage correctly', function() {
    $this->get('/')->assertSee('Find a restaurant near you');
})->todo();

it('renders menu page correctly', function() {
    $this->get('/menu')->assertSee('Menu');
})->todo();
