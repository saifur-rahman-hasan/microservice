<?php

namespace App\Http\Resources\Service;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceEndpointResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'service_code' => $this->service_code,
            'endpoint_code' => $this->code,
            'endpoint' => $this->endpoint,
            'method' => $this->method,
            'description' => $this->description,
            'middleware' => $this->middleware,
            'enabled' => $this->enabled
        ];
    }
}
