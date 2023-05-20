<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class UserAccessStatus extends Model
{
    protected $table = 'user_access_status';

    protected $fillable = [
        'name'
    ];
}
