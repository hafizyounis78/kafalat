<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Screen extends Model
{
    protected $appends = ['menu'];
    use SoftDeletes;
    public function permissions()
    {
        return $this->hasMany(UserPermission::class, 'permission_id', 'id');

    }

    public function menu()
    {
        return $this->belongsTo(Menu::class,'menu_id');
    }
    public function getMenuAttribute()
    {
        $menu = $this->menu()->first();
        return $menu;
    }
}
