<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HandlesNavigation;
use Roksta\Punctuator\Spacer;

class Author extends Model
{
    use HandlesNavigation, Spacer;
    
    protected $fillable = [
    	'name'
    ];

    public function image()
    {
        return asset('/uploads/authors/' . $this->slug() . '.png');
    }

    public function setPunctuateColumns(): Array
    {
        return ['short' => ['name'], 'long' => []];
    }

    public function slug()
    {
    	return $this->join('navigations', 'navigations.foreign_id', 'authors.id')
    		->where('reference', '=', 'author')
    		->where('authors.id', '=', $this->id)
    		->first()
    		->slug;
    }
}
