<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReferencesList extends Model
{
    //use SoftDeletes;
    protected $table ='references_list';
     protected $appends=['visit_name'];
   

    public function getVisitNameAttribute()
    {

       $lookup = Lookup::find($this->visit_type);
        if (!empty($lookup)) {
            return $lookup->lookup_cat_details;
        }
        return $this->visit_type;

    }

}
