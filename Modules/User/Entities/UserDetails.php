<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    protected $fillable = [
        'first_name', 'last_name'
    ];

    protected $hidden = [
        'deleted_at',
    ];

}
