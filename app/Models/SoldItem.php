<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoldItem extends Model
{
    protected $fillable = [
        'order_item_id', 'status'
    ];
}
