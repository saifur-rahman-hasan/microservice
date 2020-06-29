<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Http\Resources\Service\ServiceEndpointResource;
use App\Http\Resources\Service\ServiceResource;
use App\Models\Service;
use App\Models\ServiceEndpoint;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceEndpointController extends Controller
{
    public function index(Service $service)
    {
        $service->load('endpoints');
        return new ServiceResource($service);
    }

    public function store(Request $request, Service $service)
    {
        $validHttpVerbs = collect([ 'get', 'post', 'put', 'patch', 'delete' ])->implode(',');

        $request->validate([
            'endpoint' => 'required|url',
            'method' => "required|in:$validHttpVerbs",
            'middleware' => 'nullable|array',
            'description' => 'required',
        ]);

        try {

            $serviceEndpoint = ServiceEndpoint::create([
                'service_code' => $service->code,
                'code' => Str::random(16),
                'method' => request('method'),
                'endpoint' => request('endpoint'),
                'middleware' => request('middleware'),
                'description' => request('description'),
                'enabled' => request('enabled', false),
            ]);

            return new ServiceEndpointResource( $serviceEndpoint );

        }catch (\Exception $exception){
            return $this->jsonErrorResponse( $exception );
        }
    }
}
