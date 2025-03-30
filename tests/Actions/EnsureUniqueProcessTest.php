<?php

declare(strict_types=1);

namespace Igniter\Orange\Tests\Actions;

use Exception;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Orange\Actions\EnsureUniqueProcess;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

beforeEach(function(): void {
    DB::shouldReceive('beginTransaction')->zeroOrMoreTimes();
    DB::shouldReceive('rollBack')->zeroOrMoreTimes()->byDefault();
    DB::shouldReceive('select')->zeroOrMoreTimes()->byDefault();
});

it('executes callback when lock is acquired', function(): void {
    $lockKey = 'test-lock';

    DB::shouldReceive('select')
        ->with('SELECT GET_LOCK(?, ?) as acquired', [$lockKey, 5])
        ->andReturn([(object)['acquired' => 1]]);

    DB::shouldReceive('select')
        ->with('SELECT RELEASE_LOCK(?)', [$lockKey])
        ->andReturn([(object)['released' => 1]]);

    DB::shouldReceive('commit')->once();

    expect((new EnsureUniqueProcess)->attemptWithLock($lockKey, fn(): string => 'success'))->toBe('success');
});

it('retries and returns null when lock not acquired', function(): void {
    $lockKey = 'failing-lock';

    DB::shouldReceive('select')
        ->with('SELECT GET_LOCK(?, ?) as acquired', [$lockKey, 5])
        ->times(3)
        ->andReturn([(object)['acquired' => 0]]);

    DB::shouldReceive('rollBack')->times(3);
    Log::shouldReceive('error')->times(1);
    Log::shouldReceive('warning')->times(3);

    $action = (new EnsureUniqueProcess)->maxRetries(3)->retryDelay(0);

    expect(fn(): mixed => $action->attemptWithLock($lockKey, fn(): string => 'should not run'))
        ->toThrow(ApplicationException::class, 'Failed to acquire lock [failing-lock] after 3 attempts');
});

it('retries and rethrows QueryException after max attempts', function(): void {
    $lockKey = 'query-exception-lock';
    $bindings = [$lockKey, 5];

    $queryException = new QueryException(
        'mysql',
        'SELECT GET_LOCK(?, ?)',
        $bindings,
        new Exception('Simulated DB failure'),
    );

    DB::shouldReceive('rollBack')->times(3);
    DB::shouldReceive('select')
        ->with('SELECT GET_LOCK(?, ?) as acquired', $bindings)
        ->times(3)
        ->andThrow($queryException);

    DB::shouldReceive('select')
        ->with('SELECT RELEASE_LOCK(?)', [$lockKey])
        ->times(3);

    Log::shouldReceive('error')->times(4);

    $action = (new EnsureUniqueProcess)->maxRetries(3)->retryDelay(0);

    expect(fn(): mixed => $action->attemptWithLock($lockKey, function(): void {}))->toThrow(QueryException::class);
});

it('retries when a deadlock (error 1213) occurs and succeeds after', function(): void {
    $lockKey = 'deadlock-lock';
    $bindings = [$lockKey, 5];

    $queryException = new QueryException(
        'mysql',
        'SELECT GET_LOCK(?, ?)',
        $bindings,
        new Exception('Simulated DB failure', 1213),
    );

    DB::shouldReceive('select')
        ->with('SELECT GET_LOCK(?, ?) as acquired', $bindings)
        ->once()
        ->andThrow($queryException);

    DB::shouldReceive('select')
        ->with('SELECT GET_LOCK(?, ?) as acquired', $bindings)
        ->once()
        ->andReturn([(object)['acquired' => 1]]);

    DB::shouldReceive('select')
        ->with('SELECT RELEASE_LOCK(?)', [$lockKey])
        ->once();
    DB::shouldReceive('commit')->once();
    Log::shouldReceive('warning')->once();

    $action = (new EnsureUniqueProcess)
        ->maxRetries(3)
        ->retryDelay(0)
        ->timeout(5);

    expect($action->attemptWithLock($lockKey, fn(): string => 'success'))->toBe('success');
});

it('releases lock and rethrows on generic Throwable', function(): void {
    $lockKey = 'generic-error-lock';
    $bindings = [$lockKey, 5];

    DB::shouldReceive('select')
        ->with('SELECT GET_LOCK(?, ?) as acquired', $bindings)
        ->andReturn([(object)['acquired' => 1]]);

    DB::shouldReceive('select')
        ->with('SELECT RELEASE_LOCK(?)', [$lockKey])
        ->once();

    DB::shouldReceive('rollBack')->once();
    Log::shouldReceive('error')->once();

    $action = (new EnsureUniqueProcess)
        ->maxRetries(3)
        ->retryDelay(0);

    expect(fn(): mixed => $action->attemptWithLock($lockKey, function(): void {
        throw new Exception('Simulated error');
    }))->toThrow(Exception::class, 'Simulated error');
});
