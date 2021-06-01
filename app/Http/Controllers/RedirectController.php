<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectController extends Controller
{
    public function redirect()
    {
        if(auth()->check()) {
            $user = auth()->user();

            if($user->role == 'admin') {
                return redirect()->route('admin.dashboard');
            }

            if($user->role == 'seller') {
                return redirect()->route('seller.dashboard');
            }

            Auth::logout();
        }

        return redirect()->route('login');
    }
}
