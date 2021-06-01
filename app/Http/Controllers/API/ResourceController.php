<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Traits\HandlesNavigation;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    use HandlesNavigation;

    public function fetch(Request $request)
    {
        $page = $request->page ? $request->page : 1;

        $resolved = $this->resolve($request->slug);

        if($resolved['type'] == 'category') {
            return $this->getCategory($resolved, $page);
        }

        if($resolved['type'] == 'book') {
            return $this->getBook($resolved);
        }
    }

    public function getBook($resolved)
    {
        $book = $resolved['instance'];

        return [
            'type' => 'book',
            'content' => [
                'book' => $book->parse()
            ]
        ];
    }

    public function getCategory($resolved, $page)
    {
        $category = $resolved['instance'];
            
        return [
            'type' => 'category',
            'content' => [
                'title' => $category->name,
                'books' => $category->allBooks($page),
                'filters' => [
                    'categories' => $category->related(),
                    'authors' => $category->authors()
                ],
                'pagination' => [
                    'current_page' => (int) $page,
                    'total_pages' => (int) ceil($category->countBooks() / 16)
                ],
            ]
        ];
    }
}
