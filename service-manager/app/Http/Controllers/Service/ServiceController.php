<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Http\Resources\Service\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::enabled()->with('endpoints')->get();
        return ServiceResource::collection($services);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'route' => 'required|url',
            'platform' => 'required',
            'version' => 'required',
            'access_token' => 'required|min:16|max:16'
        ]);

        try {

            $service = Service::create([
                'code' => Str::random(16),
                'name' => request('name'),
                'route' => request('route'),
                'platform'  => request('platform'),
                'version' => request('version'),
                'enabled' => request('enabled', false),
                'access_token' => request('access_token')
            ]);

            return new ServiceResource($service);

        }catch (\Exception $exception){

            return $this->jsonErrorResponse( $exception );

        }
    }

    public function show(Service $service)
    {
        $service->load('endpoints');
        return new ServiceResource($service);
    }
}
