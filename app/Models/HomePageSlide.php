<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomePageSlide extends Model
{   
    protected $fillable = [
    	'name', 'target', 'published'
    ];

    public function url()
    {
        return asset("uploads/slides/$this->id.png");
    }
}
