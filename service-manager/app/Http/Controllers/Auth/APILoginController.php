<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Laravel\Passport\Exceptions\InvalidAuthTokenException;

class APILoginController extends Controller
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function login(Request $request)
    {
        try {

            $passwordGrantRoute = url('oauth/token');

            $response = $this->client->post($passwordGrantRoute, [
                'grant_type' => 'password',
                'client_id' => 2,
                'client_secret' => '78Cy1O05lUzHxk9SlRcdOA1awjkc6MpTSOOeZwy8',
                'username' => request('email'),
                'password' => request('password'),
                'scope' => '',
            ]);

            dd($response->getBody());

            $token = json_decode((string) $response->getBody(), true);

            return response()->json([
                'data' => [
                    'token' => $token
                ]
            ]);
        }catch (InvalidAuthTokenException $authTokenException){
            return response()->json([
                'message' => $authTokenException->getMessage()
            ], 500);
        }catch (\Exception $exception){
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
