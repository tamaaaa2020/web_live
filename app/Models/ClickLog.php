<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClickLog extends Model
{
    protected $table = 'clicks_log';

    const UPDATED_AT = null;

    protected $fillable = [
        'link_id',
        'domain_source',
        'ip',
        'user_agent',
        'country',
        'referrer',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}

