<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceEndpoint extends Model
{
    protected $fillable = [
        'service_code',
        'code',
        'method',
        'endpoint',
        'middleware',
        'description',
        'enabled',
    ];

    protected $casts = [
        'middleware' => 'array'
    ];

    public function scopeEnabled($endpoint, $enabled = true)
    {
        return $endpoint->where('enabled', $enabled);
    }
}
