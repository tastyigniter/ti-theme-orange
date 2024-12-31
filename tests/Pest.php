<?php

use Igniter\User\Models\User;

uses(Igniter\Orange\Tests\TestCase::class)->in(__DIR__);

function actingAsSuperUser()
{
    return test()->actingAs(User::factory()->superUser()->create(), 'igniter-admin');
}
