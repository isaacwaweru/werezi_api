<?php

namespace App\Models;
use App\Traits\HandlesNavigation;
use Roksta\Punctuator\Spacer;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    use HandlesNavigation, Spacer;

    protected $fillable = [
    	'name'
    ];

    public function setPunctuateColumns(): Array
    {
        return ['short' => ['name'], 'long' => []];
    }

    public function slug()
    {
    	return $this->join('navigations', 'navigations.foreign_id', 'publishers.id')
    		->where('reference', '=', 'publisher')
    		->where('publishers.id', '=', $this->id)
    		->first()
    		->slug;
    }
}
