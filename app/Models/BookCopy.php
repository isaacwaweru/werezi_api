<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookCopy extends Model
{
    protected $fillable = [
        'book_id', 'seller_id', 'type', 'price', 'condition', 'status', 'quantity', 'sold', 'reminder', 'image'
    ];

    const TYPES = [
        'paperback' => 'paperback',
        'hardcover' => 'hardcover',
    ];

    const CONDITIONS = [
        'new' => 'new',
        'used' => 'used'
    ];

    public function image()
    {
        return asset($this->image);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
