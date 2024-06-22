<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BeneficiariesProfile extends Model
{
   // use SoftDeletes;
    protected $table ='beneficiaries_profile';
    protected $appends=['last_ref_date','city_name'];


    public function getLastRefDateAttribute()
    {

        $ref = ReferencesList::find($this->last_referance_key);
        if (!empty($ref)) {
            return $ref->visit_date;
        }
        return $this->last_referance_key;

    }
    public function getCityNameAttribute()
    {

        $lookup = Lookup::find($this->city);
        if (!empty($lookup)) {
            return $lookup->lookup_cat_details;
        }
        return $this->city;

    }
}
