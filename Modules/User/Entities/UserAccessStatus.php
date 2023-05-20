<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAccessStatus extends Model
{
    use SoftDeletes;
    
    protected $table = 'user_access_status';

    protected $fillable = [
        'name'
    ];
}
