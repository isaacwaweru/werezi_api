<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'name', 'phone_number', 'address', 'payment', 'status', 'amount', 'reference', 'paid'
    ];

    const STATUS = [
        'pending' => 'pending'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sold()
    {
        return $this->items->flatMap(function ($item) {
            return $item->soldItems->map(function ($sold) use ($item) {
                return [
                    'name' => $item->book->name,
                    'price' => $item->price
                ];
            });
        });
    }

    public function books()
    {
        return $this->items->map(function($item) {
            return [
                'name' => $item->book->name,
                'id' => $item->book->reference,
                'slug' => $item->book->slug(),
                'image' => $item->book->image(),
                'price' => $item->price,
                'author' => $item->book->author->name,
                'quantity' => $item->quantity
            ];
        });
    }

    public function parse()
    {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'books' => $this->books(),
            'created' => $this->created_at->format('M d H:i'),
            'total' => $this->amount,
            'status' => $this->status,
            'payment' => $this->payment,
            'address' => $this->address,
            'user' => [
                'name' => $this->user->name,
                'phone_number' => $this->user->phone_number
            ]
        ];
    }
}
