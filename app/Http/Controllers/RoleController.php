<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Screen;
use App\User;
use App\UserPermission;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    public function permission()
    {
        if (in_array(8, auth()->user()->user_per)) {
            $this->data['sub_menu'] = 'role';
            $this->data['location_title'] = 'عرض واجهات الظام';
            $this->data['location_link'] = 'role';
            $this->data['title'] = 'الصلاحيات';
            $this->data['page_title'] = 'اضافة وتعديل واجهات النظام';
            $this->data['menus'] = Menu::get();
            //dd($user);
            return view(role_vw() . '.permission')->with($this->data);
        } else
            return redirect()->to('home');
    }

    public function permissionStore(Request $request)
    {
        if ($request->hdn_permission_id == '') {
            $permission = New  Screen();
            $permission->menu_id = $request->get('menu_id');
            $permission->name = $request->get('display_name');
            $permission->display_name = $request->get('display_name');
            $permission->screen_link = $request->get('screen_link');
            $permission->screen_order = $request->get('screen_order');
            $permission->created_by = auth()->user()->id;

            if ($permission->save()) {
                return response()->json(['success' => true]);

            } else
                return response()->json(['success' => false]);
        } else {
            $permission = Screen::find($request->hdn_permission_id);
            $permission->menu_id = $request->get('menu_id');
            $permission->name = $request->get('display_name');
            $permission->display_name = $request->get('display_name');
            $permission->screen_link = $request->get('screen_link');
            $permission->screen_order = $request->get('screen_order');

            if ($permission->save()) {
                return response()->json(['success' => true]);

            } else
                return response()->json(['success' => false]);

        }

    }

    public function permissionDelete(Request $request)
    {
        //dd($request->id);
        $id = $request->id;
        $permission = Screen::find($id);
        if ($permission)
            if ($permission->delete())
                return response()->json(['success' => true]);
    }

    public function permissionData()
    {
        $table = Screen::with('menu');
        $num = 1;
        return datatables()->of($table)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('menu_desc', function ($table) {// as foreach ($users as $user)

                return $table->menu->menu_name;
            })
            ->addColumn('action', function ($table) {// as foreach ($users as $user)

                return '
                <div class="col-md-12">
                <div class="col-md-2">
                <a href="#" type="button" class=" btn btn-icon-only green" onclick="fillForm(' . $table->id . ',\'' . $table->display_name . '\',' . $table->menu_id . ',\'' . $table->screen_link . '\',' . $table->screen_order . ')"><i class="fa fa-edit"></i></a>
                </div>
                <div class="col-md-2">
                <button type="button" class="btn btn-icon-only red" onclick="permDelete(\'' . $table->id . '\')"><i class="fa fa-times"></i></button></div></div>';
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function menu()
    {
        if (in_array(7, auth()->user()->user_per)) {
            $this->data['sub_menu'] = 'role';
            $this->data['location_title'] = 'عرض القوائم';
            $this->data['location_link'] = 'role';
            $this->data['title'] = 'الصلاحيات';
            $this->data['page_title'] = 'اضافة قائمة جديد';
            return view(role_vw() . '.menu')->with($this->data);
        } else
            return redirect()->to('home');
    }

    public function menuStore(Request $request)
    {
        if ($request->hdn_menu_id == '') {
            $table = New Menu();
            $table->menu_name = $request->get('menu_name');
            $table->menu_icon = $request->get('menu_icon');
            $table->menu_order = $request->get('menu_order');
            $table->created_by = auth()->user()->id;

            if ($table->save()) {
                return response()->json(['success' => true]);//return redirect()->to(role_vw() . '/');//

            } else
                return response()->json(['success' => false]);
        } else {
            $table = Menu::find($request->hdn_menu_id);
            $table->menu_name = $request->get('menu_name');
            $table->menu_icon = $request->get('menu_icon');
            $table->menu_order = $request->get('menu_order');
            if ($table->save()) {
                return response()->json(['success' => true]);

            } else
                return response()->json(['success' => false]);

        }

    }

    public function menuDelete(Request $request)
    {
        //dd($request->id);
        $id = $request->id;
        $table = Menu::find($id);
        if ($table)
            if ($table->delete())
                return response()->json(['success' => true]);
    }

    public function menuData()
    {
        $table = Menu::all();
        $num = 1;
        return datatables()->of($table)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('action', function ($table) {// as foreach ($users as $user)

                return '

                <div class="col-md-2">
                <a href="#" type="button" class=" btn btn-icon-only green"
 onclick="fillForm(' . $table->id . ',\'' . $table->menu_name . '\',\'' . $table->menu_icon . '\',\'' . $table->menu_order . '\')"><i class="fa fa-edit"></i></a>
                </div>
                <div class="col-md-2">
                <button type="button" class="btn btn-icon-only red" onclick="menuDelete(' . $table->id . ')"><i class="fa fa-times"></i></button></div>';
            })
            ->addColumn('menu_icon_desc', function ($table) {// as foreach ($users as $user)

                return '<i class="font-black ' . $table->menu_icon . ' "></i>';
            })
            ->rawColumns(['action'])
            ->rawColumns(['action', 'menu_icon_desc'])
            ->toJson();
    }

    public function user_permission()
    {
        if (in_array(11, auth()->user()->user_per)) {
            $this->data['sub_menu'] = 'role';
            $this->data['location_title'] = 'عرض صلاحيات المستخدمين';
            $this->data['location_link'] = 'user_permission';
            $this->data['title'] = 'الصلاحيات';
            $this->data['page_title'] = 'صلاحيات المستخدمين';
            $this->data['users'] = User::all();
            return view(role_vw() . '.user_permission')->with($this->data);
        }
        else
            return redirect()->to('home');
    }

    public function getPermissions(Request $request)
    {
        $id = $request->id;
        $pers = Permission::all();
        $role_pers = PermissionRole::where('role_id', $id)->get();
        //  dd($role_pers);
        $html = '';

        $selected = '';
        foreach ($pers as $per) {
            $selected = '';
            foreach ($role_pers as $role_per) {

                if ($role_per->permission_id == $per->id) {
                    //   dd('yes');
                    $selected = 'selected';
                }


            }
            $html .= '  <option value="' . $per->id . '"  ' . $selected . '>' . $per->display_name . '</option>';

        }

        return response()->json(['success' => true, 'per' => $html]);

    }

    public function deselectPer(Request $request)
    {
        $role_id = $request->role_id;
        $permission_id = $request->values[0];

        $perRole = PermissionRole::where('permission_id', $permission_id)
            ->where('role_id', $role_id)->delete();

        return response()->json(['success' => true]);
    }

    public function selectPer(Request $request)
    {
        //  dd($request->values[0]);
        $perRole = new PermissionRole();
        $perRole->role_id = $request->role_id;
        $perRole->permission_id = $request->values[0];
        if ($perRole->save())
            return response()->json(['success' => true, 'per' => $perRole]);

    }

    public function deselectUserPer(Request $request)
    {
        $user_id = $request->user_id;
        $permission_id = $request->values[0];

        $perRole = UserPermission::where('permission_id', $permission_id)
            ->where('user_id', $user_id)->delete();

        return response()->json(['success' => true]);
    }

    public function selectUserPer(Request $request)
    {

        $userPer = new UserPermission();
        $userPer->user_id = $request->user_id;
        $userPer->permission_id = $request->values[0];
        $userPer->created_by = auth()->user()->id;
        if ($userPer->save())
            return response()->json(['success' => true, 'per' => $userPer]);

    }

    public function getRolePermissions(Request $request)
    {
        $user_id = $request->user_id;

        // $pers=Permission::all();
        $screens = Screen::with('permissions')->get();
        $user_pers = UserPermission::with('permission')->where('user_id', $user_id)->get();
        // dd($role_pers);
        $html = '';

        $selected = '';

        foreach ($screens as $screen) {
            //  dd($role_per->permissions);
            $selected = "";
            foreach ($user_pers as $user_per) {

                //  if ($user_per->permission->id == $screen->id) {
                if ($user_per->permission_id == $screen->id) {
                    $selected = 'selected';

                }


            }
            $html .= '  <option value="' . $screen->id . '" ' . $selected . '>' . $screen->display_name . '</option>';
        }

        foreach ($user_pers as $user_per) {
            $selected = 'selected';
            $found = '';
            foreach ($screens as $screen) {
                if ($user_per->permission_id == $screen->id)
                    $found = true;
            }
            if (!$found)
                $html .= '  <option value="' . $user_per->permission_id . '" ' . $selected . '>' . $user_per->permission->display_name . '</option>';

        }


        return response()->json(['success' => true, 'per' => $html]);

    }


}
