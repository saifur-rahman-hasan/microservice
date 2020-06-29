<?php

namespace App\Http\Controllers;

use App\Models\ServiceEndpoint;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Prophecy\Exception\Doubler\MethodNotFoundException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class IdentifyServiceProviderController extends Controller
{
    public function __construct()
    {
        $this->middleware('identifyMicroserviceProvider');
    }

    public function handleRequest(Request $request, $serviceCode, $endpointCode)
    {
        try {

            // Find or Fail Service Endpoint using given serviceCode and endpointCode
            $serviceEndpoint = ServiceEndpoint::enabled()
                ->where('service_code', $serviceCode)
                ->where('code', $endpointCode)
                ->firstOrFail();

            // Verify Request Method
            $this->verifyRequestMethod( $serviceEndpoint->method );

            $userAuthorizationToken = "Bearer " . Str::random(32);

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => $userAuthorizationToken
            ])->{$request->getMethod()}( $serviceEndpoint->endpoint, $request->all() );

            if( ! $response->successful() ){
                dd( $response );
            }else{
                return $response->json();
            }

        }catch (ModelNotFoundException $modelNotFoundException){
            return response()->json([
                'message' => 'Invalid Service or Endpoint Detected.'
            ], 500);
        }catch (\Exception $exception){
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
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
