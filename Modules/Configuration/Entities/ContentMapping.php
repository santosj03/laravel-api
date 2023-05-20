<?php

namespace Modules\Configuration\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentMapping extends Model
{
    use SoftDeletes;

    protected $table = 'content_mapping';

    protected $fillable = [
        "code",
        "error",
        "sms",
        "email_subject",
        "email_body",
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'deleted_at'
    ];
}
