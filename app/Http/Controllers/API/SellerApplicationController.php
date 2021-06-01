<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Seller;
use Illuminate\Support\Facades\Hash;

class SellerApplicationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'password' => 'required|confirmed',
        ]);

        User::create([
            'name' => $request->name, 
            'email' => $request->email, 
            'password' => Hash::make($request->password), 
            'phone_number' => $request->phone_number, 
            'role' => 'seller'
        ]);

        return 1;
    }
}
