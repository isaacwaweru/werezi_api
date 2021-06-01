<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Roksta\Punctuator\Spacer;

class FeaturedItem extends Model
{
    use Spacer;

    protected $fillable = [
    	'title', 'target', 'published'
    ];

    public function setPunctuateColumns(): Array
    {
        return ['short' => ['title'], 'long' => []];
    }
}
