<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HandlesNavigation;
use Roksta\Punctuator\Spacer;

class Seller extends Model
{
    use HandlesNavigation, Spacer;
    
    protected $fillable = [
    	'name', 'type', 'status'
    ];

    public function setPunctuateColumns(): Array
    {
        return ['short' => ['name'], 'long' => []];
    }

    public function slug()
    {
    	return $this->join('navigations', 'navigations.foreign_id', 'sellers.id')
    		->where('reference', '=', 'seller')
    		->where('sellers.id', '=', $this->id)
    		->first()
    		->slug;
    }
}
