<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use App\Models\BookCopy;
use App\Models\Publisher;
use App\Models\Category;
use App\Models\Seller;
use Intervention\Image\Facades\Image;

class BooksController extends Controller
{
    public function index()
    {
        return view('admin.books.index')->with([
            'books' => Book::all()
        ]);
    }

    public function create()
    {
        return view('admin.books.create')->with([
            'authors' => Author::all(),
            'publishers' => Publisher::all(),
            'categories' => Category::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required', 
            'author_id' => 'required', 
            'isbn' => 'required', 
            'excerpt' => 'required', 
            'synopsis' => 'required', 
            'category_id' => 'required', 
            'publisher_id' => 'required', 
            'date' => 'required', 
            'length' => 'required'
        ]);

        $book = Book::create($request->all());

        return redirect()->route('admin.books.show', $book->id);
    }

    public function show(Book $book)
    {
        return view('admin.books.show')->with([
            'book' => $book,
            'sellers' => Seller::all()
        ]);
    }

    public function edit(Book $book)
    {
        return view('admin.books.edit')->with([
            'book' => $book,
            'authors' => Author::all(),
            'publishers' => Publisher::all(),
            'categories' => Category::all()
        ]);
    }

    public function addCopy(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'price' => 'required',
            'condition' => 'required',
            'seller_id' => 'required',
            'image' => 'required',
            'book_id' => 'required',
            'quantity' => 'required'
        ]);

        $book = Book::findOrFail($request->book_id);
        $data = $request->all();
        $data['remainder'] = $request->quantity;
        $copy = BookCopy::create($data);

        $path = public_path() . '/uploads/books/' . $copy->id . '.png' ;
        Image::make($request->image)->save($path);

        if($book->availableCopies()->count() == 0) {
            $book->update([
                'main_copy_id' => $copy->id
            ]);
        }

        return redirect()->back();
    }

    public function deleteCopy(Request $request)
    {
        $request->validate([
            'copy_id' => 'required',
            'book_id' => 'required'
        ]);

        $book = Book::findOrFail($request->book_id);
        $copy = BookCopy::findOrFail($request->copy_id);

        if($book->main_copy_id == $request->copy_id) {
            $book->update([
                'main_copy_id' => null
            ]);
        }

        $copy->update([
            'status' => 'cancelled'
        ]);

        return redirect()->back();
    }

    public function makeMainCopy(Request $request)
    {
        $request->validate([
            'copy_id' => 'required',
            'book_id' => 'required'
        ]);

        $book = Book::findOrFail($request->book_id);
        $book->update([
            'main_copy_id' => $request->copy_id
        ]);

        return redirect()->back();
    }
}
