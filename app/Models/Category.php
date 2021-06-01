<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HandlesNavigation;
use Roksta\Punctuator\Spacer;

class Category extends Model
{
    use HandlesNavigation, Spacer;

    protected $fillable = [
        'name', 'parent', 'position'
    ];

    public function setPunctuateColumns(): array
    {
        return ['short' => ['name'], 'long' => []];
    }

    public function slug()
    {
        return $this->join('navigations', 'navigations.foreign_id', 'categories.id')
            ->where('reference', '=', 'category')
            ->where('categories.id', '=', $this->id)
            ->first()
            ->slug;
    }

    public function parentCategory()
    {
        return $this->belongsTo(self::class, 'parent', 'id')->withDefault();
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent', 'id');
    }

    public function featuredBooks()
    {
        if($this->parent == 0) {
            $categories = self::children()->pluck('id');
        } else {
            $categories = self::where('parent', $this->parentCategory->id)->pluck('id');
        }

        return Book::whereIn('category_id', $categories)
            ->inRandomOrder()
            ->limit(10)
            ->get()
            ->map(function($book) {
                return $book->brief();
            });
    }

    public function allBooks($page)
    {
        if($this->parent == 0) {
            $categories = self::children()->pluck('id');
        } else {
            $categories = self::where('parent', $this->parentCategory->id)->pluck('id');
        }

        return Book::whereIn('category_id', $categories)
            ->limit(16)
            ->offset(($page-1) * 16 )
            ->get()
            ->map(function($book) {
                return $book->brief();
            });
    }

    public function countBooks()
    {
        if($this->parent == 0) {
            $categories = self::children()->pluck('id');
        } else {
            $categories = self::where('parent', $this->parentCategory->id)->pluck('id');
        }

        return Book::whereIn('category_id', $categories)->count();
    }

    public function related()
    {
        if($this->parent == 0) {
            $categories = self::children()->get();
        } else {
            $categories = self::where('parent', $this->parentCategory->id)->get();
        }

        return $categories->map(function($category) {
            return [
                'name' => $category->name,
                'slug' => $category->slug()
            ];
        });
    }

    public function authors()
    {
        if($this->parent == 0) {
            $categories = self::children()->pluck('id');
        } else {
            $categories = self::where('parent', $this->parentCategory->id)->pluck('id');
        }

        return Author::whereIn('id', Book::whereIn('category_id', $categories)->get(['author_id']))->get()->map(function($author) {
            return [
                'name' => $author->name,
                'slug' => $author->slug()
            ];
        });
    }
}
