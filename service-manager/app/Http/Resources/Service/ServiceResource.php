<?php

namespace App\Http\Resources\Service;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'code' => $this->code,
            'name' => $this->name,
            'route' => $this->route,
            'version' => $this->version,
            'platform' => $this->platform,
            'access_token' => $this->access_token,
            'endpoints' => ServiceEndpointResource::collection( $this->whenLoaded('endpoints') )
        ];
    }
}
