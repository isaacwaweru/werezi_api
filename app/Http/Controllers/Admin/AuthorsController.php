<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Author;
use Intervention\Image\Facades\Image;

class AuthorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authors = Author::all();

        return view('admin.authors.index')->with([
            'authors' => $authors
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.authors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'logo' => 'required'
        ]);

        $author = Author::create([
            'name' => $request->name
        ]);
        
        $path = public_path() . '/uploads/authors/' . $author->slug() . '.png' ;

        Image::make($request->logo)->save($path);

        return redirect()->route('admin.authors.show', $author->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $author = Author::findOrFail($id);

        return view('admin.authors.show')->with([
            'author' => $author
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Author $author)
    {
        return view('admin.authors.edit')->with([
            'author' => $author
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {
        if($request->action == 'name') {
            $request->validate([
                'name' => 'required'
            ]);

            $author->update([
                'name' => $request->name
            ]);

            return redirect()->route('admin.authors.show', $author->id);
        }

        $request->validate([
            'image' => 'required'
        ]);

        $path = public_path() . '/uploads/authors/' . $author->slug() . '.png';

        Image::make($request->image)->save($path);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        $author->delete();

        return redirect()->route('admin.authors.index');
    }
}
