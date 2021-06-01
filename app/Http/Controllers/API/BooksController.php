<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Traits\HandlesNavigation;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    use HandlesNavigation;

    public function offers(Request $request)
    {
        $request->validate([
            'slug' => 'required',
            'format' => 'required'
        ]);

        $book = $this->resolve($request->slug)['instance'];

        $offers = $book->copies->where('type', $request->format)->map(function($copy) {
            return [
                'id' => $copy->id,
                'name' => $copy->type,
                'price' => $copy->price,
                'image' => $copy->image(),
                'seller' => [
                    'name' => $copy->seller->name,
                    'slug' => $copy->seller->slug(),
                ]
            ];
        });

        return [
            'offers' => $offers,
            'best_offer' => $offers->sortByDesc('price')->first()
        ];
    }
}
