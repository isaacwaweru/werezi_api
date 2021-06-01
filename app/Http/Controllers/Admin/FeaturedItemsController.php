<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FeaturedItem;
use App\Models\Navigation;

class FeaturedItemsController extends Controller
{
    public function index()
    {
    	return view('admin.featured-items.index')->with([
    		'featured_items' => FeaturedItem::all()
    	]);
    }

    public function create()
    {
    	$navigations = Navigation::all();

    	return view('admin.featured-items.create')->with([
    		'navigations' => $navigations
    	]);
    }

    public function store(Request $request)
    {
    	$request->validate([
            'title' => 'required',
            'target' => 'required'
        ]);

        FeaturedItem::create([
            'title' => $request->title, 
            'target' => $request->target
        ]);

       return redirect()->route('admin.featured-items.index');
    }


    public function update(Request $request, $id)
    {
    	$featured_item = FeaturedItem::findOrFail($id);

    	$featured_item->update([
    		'published' => ! $featured_item->published
    	]);

    	return redirect()->route('admin.featured-items.index');
    }

    public function destroy($id)
    {
    	$featured_item = FeaturedItem::findOrFail($id);
    	$featured_item->delete();

    	return redirect()->route('admin.featured-items.index');
    }
}
