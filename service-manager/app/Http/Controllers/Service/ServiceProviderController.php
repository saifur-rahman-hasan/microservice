<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Http\Middleware\IdentifyMicroServiceProvider;
use App\Models\Service;
use App\Models\ServiceEndpoint;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ServiceProviderController extends Controller
{
    public function __construct()
    {
        $this->middleware(IdentifyMicroServiceProvider::class);
    }

    public function handleRequest(Request $request, Service $service, $endpointCode)
    {
        try {

            // Verify the given service enabled or not
            $this->verifyServiceIsEnabled( $service );

            // Find or Fail Service Endpoint using given serviceCode and endpointCode
            $serviceEndpoint = ServiceEndpoint::enabled()
                ->where('service_code', $service->code)
                ->where('code', $endpointCode)
                ->firstOrFail();

            // Verify Endpoint Requested Method
            $this->verifyRequestMethod( $serviceEndpoint->method );

            // Merge the auth user id with the request
            $request['auth_id'] = auth()->id();

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer " . $service->access_token
            ])->{$request->getMethod()}( $serviceEndpoint->endpoint, $request->all() );

            return ( ! $response->successful() )
                ? response()->json($response->json(), $response->getStatusCode())
                : $response->json();

        }catch (ModelNotFoundException $modelNotFoundException){

            return $this->jsonErrorResponse($modelNotFoundException, 'Invalid Service or Endpoint Detected.');

        }catch (\Exception $exception){

            return $this->jsonErrorResponse($exception);

        }
    }

    /**
     * Verify the given service is enabled or not
     *
     * @param Service $service
     * @return bool
     * @throws \Exception
     */
    private function verifyServiceIsEnabled( Service $service )
    {
        if( ! $service->enabled || ! $service->access_token ){
            throw new \Exception('Sorry! Unable to found your provided service');
        }

        return true;
    }

    private function verifyRequestMethod( $method )
    {
        if(! request()->isMethod( $method ) ){
            throw new \Exception('Invalid endpoint method detected.');
        }

        return true;
    }

    private function handleGetRequest()
    {

    }
}
