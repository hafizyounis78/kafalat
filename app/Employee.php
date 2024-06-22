<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
   // use SoftDeletes;
    protected $primaryKey='emp_id';
    protected $appends = ['job_desc','district_desc'];

    public function user()
    {
        return $this->hasOne(User::class, 'emp_id','emp_id');
    }

    public function EmpEval()
    {
        return $this->belongsTo(EmpEval::class,'emp_id','emp_id');

    }

    public function Attendsheet()
    {
        return $this->hasMany(AttendanceSheet::class,'emp_id','emp_id');

    }

    public function Job()
    {
        return $this->belongsTo(Job::class,'job_title','id');

    }
    public function District()
    {
        return $this->belongsTo(District::class,'districts_id','id');

    }
    public function getJobDescAttribute()
    {

        $Job_desc = $this->Job()->first();
        return $Job_desc->desc;
    }
    public function getDistrictDescAttribute()
    {

        $Job_desc = $this->District()->first();
        return $Job_desc->desc;
    }

}
