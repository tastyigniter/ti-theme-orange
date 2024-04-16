<?php

namespace Igniter\Frontend\Models;

use Igniter\Flame\Database\Model;

class Subscriber extends Model
{
    protected $table = 'igniter_frontend_subscribers';

    protected $primaryKey = 'id';

    protected $fillable = ['email'];
}
