<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountVerification extends Model
{
    protected $fillable = [
        'user_id', 'code', 'type'
    ];
}
