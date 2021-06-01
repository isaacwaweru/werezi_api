<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'transaction_id',
        'date_time',
        'amount',
        'account',
        'phone',
        'payer'
];
}
