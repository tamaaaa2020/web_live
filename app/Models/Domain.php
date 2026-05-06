<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $fillable = [
        'domain_name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}

