<?php

namespace Igniter\Coupons\ApiResources\Repositories;

use Igniter\Api\Classes\AbstractRepository;
use Igniter\Coupons\Models\Coupons_model;

class CouponsRepository extends AbstractRepository
{
    protected $modelClass = Coupons_model::class;
}
