<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AccountVerification;
use Illuminate\Http\Request;
use FutureFast\Tradesk\SMS;
use App\Jobs\SendSms;
use App\Models\User;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required'
        ]);

        $user = auth()->guard('api')->user();
        $user->update([
            'name' => $request->name,
            'phone_number' => $request->phone_number
        ]);

        return [
            'user' => [
                'first_name' => explode(' ', $user->name)[0],
                'name' => $user->name,
                'email' => $user->email,
                'phone_number' => $user->phone_number,
                'email_verified' => ! is_null($user->email_verified_at),
                'phone_number_verified' => ! is_null($user->phone_number_verified_at)
            ]
        ];
    }

    public function requestOtp(Request $request)
    {
        $request->validate([
            'phone_number' => 'required'
        ]);

        $code = mt_rand(1000, 9999);

        auth()->guard('api')->user()->update([
            'phone_number' => $request->phone_number
        ]);

        AccountVerification::create([
            'user_id' => auth()->guard('api')->id(),
            'code' => $code,
            'type' => 'phone_number'
        ]);

        dispatch(new SendSms($request->phone_number, "Hello, Yout OTP is $code"));
    }

    public function verifyOtp(Request $request)
    {
        $code = User::join('account_verifications', 'users.id', '=', 'account_verifications.user_id')
            ->where('phone_number', '=', $request->phone_number)
            ->where('code', $request->code)
            ->first();

        if(is_null($code)) {
            abort(422, 'Invalid Code');
        } else {
            User::findOrFail($code->user_id)->update([
                'phone_number_verified_at' => now()
            ]);

            return 1;
        }
    }
}
