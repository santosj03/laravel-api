<?php

namespace Modules\Configuration\Entities;

use Illuminate\Database\Eloquent\Model;

class ParameterConfig extends Model
{
    protected $table = 'parameter_configs';

    protected $fillable = [
        'name'
    ];
}
