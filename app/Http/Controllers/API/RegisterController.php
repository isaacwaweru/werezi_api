<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\AccountVerification;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
    	$request->validate([
    		'name' => 'required',
    		'email' => 'required|unique:users,email',
    		'password' => 'required|min:6'
    	]);

    	$data = $request->all();
    	$user = $this->create($data);
        $code = Str::random(25);


        $verify = AccountVerification::create([
            'code' => $code,
            'user_id' => $user->id,
            'type' => 'email'
        ]);

        // Mail::to($request->email)->send(new \App\Mail\emailVerification($code));

    	return $this->login($data);
    }

    public function emailVerification($code){

        $code = AccountVerification::where('code',$code)->where('type', 'email')->first();

        if(is_null($code)) {
            abort(422, 'Invalid Code');
        } else {
            User::findOrFail($code->user_id)->update([
                'email_verified_at' => now()
            ]);

            $code->delete();

            return 1;
        }
    }

    protected function create(array $data)
    {

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone_number' => isset($data['phone_number']) ? $data['phone_number'] : '',
            'role' => 'customer'
        ]);
    }

    protected function login($data)
    {
    	$request = Request::create('/api/v1/login', 'POST', [
            'email' => $data['email'],
            'password' => $data['password']
        ]);

        $request->headers->set('Origin', '*');

        return app()->handle($request);
    }
}
