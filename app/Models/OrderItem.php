<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'book_id', 'book_copy_id', 'order_id', 'quantity', 'price', 'total'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function soldItems()
    {
        return $this->hasMany(SoldItem::class);
    }
}
