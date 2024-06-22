<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lookup extends Model
{
    use SoftDeletes;
    protected $table = 'lookup';

    protected $appends = ['children'];


    public function Children()
    {
        return $this->hasMany(Lookup::class, 'lookup_cat_id', 'id');
    }


    public function getChildrenAttribute()
    {
        return $this->Children()->get();
    }
}

