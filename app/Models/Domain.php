<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Domain extends Model
{
    protected $fillable = [
        'domain_name',
        'is_active',
        'failover_to_domain_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function failoverTarget(): BelongsTo
    {
        return $this->belongsTo(self::class, 'failover_to_domain_id');
    }
}
