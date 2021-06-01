<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $books = Book::join('authors', 'authors.id', '=', 'books.author_id')
            ->where('books.name', 'LIKE', "%$request->term%")
            ->orWhere('isbn', 'LIKE', "%$request->term%")
            ->orWhere('authors.name', 'LIKE', "%$request->term%")
            ->limit(10)
            ->get()
            ->map(function($book) {
                return $book->brief();
            });

        return [
            'books' => $books
        ];
    }

    public function fullSearch(Request $request)
    {
        $current_page = $request->page ? $request->page : 1;

        $query = Book::join('authors', 'authors.id', '=', 'books.author_id')
            ->where('books.name', 'LIKE', "%$request->term%")
            ->orWhere('isbn', 'LIKE', "%$request->term%")
            ->orWhere('authors.name', 'LIKE', "%$request->term%")
            ->limit(18)
            ->offset(($current_page-1) * 18 );

        $books = (clone $query)->get()->map(function($book) {
            return $book->brief();
        });

        return [
            'books' => $books,
            'filters' => [
                'categories' => $this->getCategories($query),
                'authors' => $this->getAuthors($query)
            ],
            'pagination' => [
                'current_page' => $current_page,
                'total_pages' => ceil((clone $query)->count() / 24)
            ]
        ];
    }

    private function getCategories($query)
    {
        return [];
    }

    private function getAuthors($query)
    {
        return [];
    }
}
