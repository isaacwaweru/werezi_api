<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class InitController extends Controller
{
    public function init()
    {
        $auth = auth()->guard('api');

        return [
            'auth_user' => $this->getUser(),
            'navigation' => $this->getNavs()
        ];
    }

    public function getUser()
    {
        $user = auth()->guard('api')->user();

        if(is_null($user)) {
            return false;
        }

        return [
            'first_name' => explode(' ', $user->name)[0],
            'name' => $user->name,
            'phone_number' => $user->phone_number,
            'email' => $user->email,
            'email_verified' => ! is_null($user->email_verified_at),
            'phone_number_verified' => ! is_null($user->phone_number_verified_at)
        ];
    }

    public function getNavs()
    {
        return Category::where('parent', 0)->get()->map(function($parent) {
            $children = Category::where('parent', $parent->id)->get()->map(function($child) {
                return [
                    'name' => $child->name,
                    'slug' => $child->slug()
                ];
            });

            return [
                'name' => $parent->name,
                'slug' => $parent->slug(),
                'children' => $children
            ];
        });
    }
}
