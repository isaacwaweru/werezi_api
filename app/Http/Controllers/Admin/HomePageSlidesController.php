<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomePageSlide;
use App\Models\Navigation;
use Intervention\Image\Facades\Image;

class HomePageSlidesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.home-page-slides.index')->with([
            'slides' => HomePageSlide::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $navigations = Navigation::all();

        return view('admin.home-page-slides.create')->with([
            'navigations' => $navigations
        ]);
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
            'image' => 'required',
            'target' => 'required'
        ]);

        $slide = HomePageSlide::create([
            'name' => $request->name,
            'target' => $request->target, 
            'published' => $request->published ? 1 : 0
        ]);

        $extension = $request->image->getClientOriginalExtension();
        $path = 'uploads/slides/' . $slide->id . '.' . $extension;

        Image::make($request->image)->encode($extension)->save($path);

       return redirect()->route('admin.home-page-slides.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $slide = HomePageSlide::findOrFail($id);

        $slide->update([
            'published' => ! $slide->published
        ]);

        return redirect()->route('admin.home-page-slides.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slide = HomePageSlide::findOrFail($id);
        $slide->delete();

        return redirect()->route('admin.home-page-slides.index');
    }
}
