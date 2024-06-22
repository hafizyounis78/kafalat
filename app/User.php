<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use SoftDeletes, HasApiTokens;
    use Notifiable;
    protected $appends = ['title_desc', 'user_per','user_menu'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function permissions()
    {
        return $this->hasMany(UserPermission::class, 'user_id', 'id');

    }

    public function getUserPerAttribute()
    {
        $per = $this->permissions()->pluck('permission_id')->unique()->toArray();
        return $per;
    }
    public function getUserMenuAttribute()
    {
        $per_id = $this->permissions()->pluck('permission_id')->unique();
        $menuPer = Screen::whereIn('id', $per_id)->pluck('menu_id')->unique();
        $menu = Menu::whereIn('id', $menuPer)->get();


        foreach ($menu as $m) {

            $permissions = Screen::join('user_permissions', 'user_permissions.permission_id', '=', 'screens.id')
                ->where('user_permissions.user_id', auth()->user()->id)
                ->where('screens.menu_id', $m->id)->orderBy('screen_order')->get();

            $m->sub_menu = $permissions;
        }
        return $menu;

    }
    public function getTitleDescAttribute()
    {
        $lookup = Lookup::find($this->title_id);
        if (!empty($lookup)) {
            return $lookup->lookup_cat_details;
        }
        return $this->visit_type;
    }
}
