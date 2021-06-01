<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;


class LoginController extends Controller
{
    public function login(Request $request)
    {
    	$request->validate([
    		'email' => 'required|email',
    		'password' => 'required'
    	]);

    	$new_request = Request::create('oauth/token', 'POST', [
            'client_id' => env('API_PASSPORT_CLIENT_ID'),
            'client_secret' => env('API_PASSPORT_CLIENT_SECRET'),
            'username' => $request->email,
            'password' => $request->password,
            'grant_type' => 'password',
            'scope' => '*'
        ]);

        $new_request->headers->set('Origin', '*');

        return app()->handle($new_request);
    }

    public function logout()
    {
        auth()->guard('api')->user()->token()->revoke();

        return 1;
    }
}
