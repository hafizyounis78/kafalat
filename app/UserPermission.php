<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    protected $appends = ['per_name'];//,'display_name','screen_link','screen_order'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function permission()
    {
        return $this->belongsTo(Screen::class, 'permission_id', 'id');
    }

    public function getPerNameAttribute()
    {
        $name = $this->permission()->select('name')->first();
        if (isset($name))
            return $name;
        return '';
    }
}
