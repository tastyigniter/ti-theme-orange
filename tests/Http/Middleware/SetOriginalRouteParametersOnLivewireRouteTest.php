<?php

declare(strict_types=1);

namespace Igniter\Orange\Tests\Http\Middleware;

use Igniter\Orange\Http\Middleware\SetOriginalRouteParametersOnLivewireRoute;
use Illuminate\Routing\Route;
use Livewire\Livewire;

it('sets original route parameters on livewire request', function(): void {
    $request = request();
    $route = new Route(['GET'], '/', []);
    $route->bind($request);
    $route->setParameter('param1', 'value1');

    $request->setRouteResolver(fn(): Route => $route);

    Livewire::shouldReceive('isLivewireRequest')->andReturnTrue();

    $middleware = new SetOriginalRouteParametersOnLivewireRoute;
    $next = fn($req) => $req;

    $response = $middleware->handle($request, $next);

    expect($response)->toBe($request)
        ->and($route->parameter('param1'))->toBe('value1');
});

it('does not set parameters when not a livewire request', function(): void {
    $request = request();
    $route = new Route(['GET'], '/', []);
    $request->setRouteResolver(fn(): Route => $route);
    Livewire::shouldReceive('isLivewireRequest')->andReturnFalse();

    $middleware = new SetOriginalRouteParametersOnLivewireRoute;
    $next = fn($req) => $req;

    $response = $middleware->handle($request, $next);

    expect($response)->toBe($request);
});

it('does not set parameters when route is null', function(): void {
    $request = request();
    $request->setRouteResolver(fn(): null => null);

    $middleware = new SetOriginalRouteParametersOnLivewireRoute;
    $next = fn($req) => $req;

    $response = $middleware->handle($request, $next);

    expect($response)->toBe($request);
});
