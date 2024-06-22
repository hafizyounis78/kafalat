<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TitleType extends Model
{
  //  use SoftDeletes;
    public function users()
    {
        return $this->hasMany(TitleType::class,'title_id','id');
    }
}
