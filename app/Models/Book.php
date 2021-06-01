<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HandlesNavigation;
use Roksta\Punctuator\Spacer;

class Book extends Model
{
    use HandlesNavigation, Spacer;

    protected $fillable = [
        'name', 'author_id', 'isbn', 'excerpt', 'synopsis', 'category_id', 'publisher_id', 'date', 'length', 'main_copy_id'
    ];

    protected $casts = [
        'date' => 'date',
        'length' => 'integer'
    ];

    public function setPunctuateColumns(): Array
    {
        return ['short' => ['name'], 'long' => []];
    }

    public function slug()
    {
    	return $this->join('navigations', 'navigations.foreign_id', 'books.id')
    		->where('reference', '=', 'book')
    		->where('books.id', '=', $this->id)
    		->first()
    		->slug;
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function main()
    {
        return BookCopy::find($this->main_copy_id);
    }

    public function image()
    {
        $main = $this->main();

        return is_null($main) ? '/logo.png' : $main->image();
    }

    public function copies()
    {
        return $this->hasMany(BookCopy::class, 'book_id', 'id');
    }

    public function availableCopies()
    {
        return $this->copies->where('status', 'available')->values();
    }

    public function brief()
    {
        return [
            'slug' => $this->slug(),
            'image' => $this->image(),
            'name' => $this->name,
            'excerpt' => substr($this->excerpt, 0, 350),
            'author' => [
                'name' => $this->author->name,
                'slug' => $this->author->slug(),
            ]
        ];
    }

    public function parse()
    {
        return [
            'slug' => $this->slug(),
            'image' => $this->image(),
            'name' => $this->name,
            'excerpt' => $this->excerpt,
            'synopsis' => $this->synopsis,
            'author' => [
                'name' => $this->author->name,
                'slug' => $this->author->slug(),
            ],
            'main_image' => $this->image(),
            'isbn' => $this->isbn,
            'length' => number_format($this->length),
            'date' => $this->date->format('M Y'),
            'publisher' => [
                'name' => $this->publisher->name,
                'slug' => $this->publisher->slug(),
            ],
            'formats' => $this->getFormats(),
            'best_offer' => $this->getBestOffer(),
            'copies' => $this->getCopies(),
            'main_format' => $this->main()->type
        ];
    }

    public function getCopies()
    {
        return ;
    }

    public function getBestOffer()
    {
        $copy = $this->main();

        if(is_null($copy)) {
            $copy = BookCopy::inRandomOrder()->first();
        }

        return [
            'id' => $copy->id,
            'price' => $copy->price,
            'name' => $copy->type,
            'image' => $copy->image(),
            'seller' => [
                'name' => $copy->seller->name,
                'slug' => $copy->seller->slug(),
            ],
            'savings' => $this->copies->max('price') - $this->copies->min('price')
        ];
    }

    public function getFormats()
    {
        return $this->copies->groupBy('type')->map(function($format) {
            return [
                'name' => $format->first()->type,
                'price' => $format->min('price'),
                'quantity' => $format->sum('remainer'),
            ];
        });
    }
}
