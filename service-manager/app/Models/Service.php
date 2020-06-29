<?php

namespace App\Models;

use App\Models\ServiceEndpoint;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'route',
        'platform',
        'version',
        'enabled',
        'access_token'
    ];

    /**
     * Set Default Route Key name for Route Model Binding
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'code';
    }

    public function scopeEnabled($service, $enabled = true)
    {
        return $service->where('enabled', $enabled);
    }

    /**
     * A service has many registered endpoints
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function endpoints()
    {
        return $this->hasMany(ServiceEndpoint::class, 'service_code', 'code');
    }
}
