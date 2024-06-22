<?php

namespace App\Http\Controllers;

use App\GuardianDetail;
use App\Lookup;
use App\User;
use App\UserDistricts;
use App\UserLocation;
use FarhanWazir\GoogleMaps\GMaps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
    public function login()
    {
        return view(admin_vw() . '.login');
    }

    public function logout()
    {

        auth()->logout();
        return redirect()->back();
    }

    public function index()
    {
        if (in_array(5, auth()->user()->user_per)) {
            $this->data['sub_menu'] = 'user-display';
            $this->data['location_title'] = 'عرض المستخدمين';
            $this->data['location_link'] = 'user';
            $this->data['title'] = 'المستخدمين';
            $this->data['page_title'] = 'عرض المستخدمين ';
            return view(user_vw() . '.view')->with($this->data);
        } else
            return redirect()->back();

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (in_array(12, auth()->user()->user_per)) {
            $this->data['sub_menu'] = 'user-display';
            $this->data['location_title'] = 'عرض المستخدمين';
            $this->data['location_link'] = 'user';
            $this->data['title'] = 'المستخدمين';
            $this->data['page_title'] = 'اضافة مستخدم جديد ';
            $this->data['titles'] = Lookup::where('lookup_cat_id', 80)->get();//المسمى الوظيفي
            $this->data['districts'] = Lookup::where('lookup_cat_id', 5)->get();
            //  $this->data['supervisors'] = User::where('user_type', 2)->get();
            //  dd($this->data['titles']);
            return view(user_vw() . '.create')->with($this->data);
        } else
            return redirect()->back();

    }

    public
    function getUserSupervisor(Request $request)
    {
        //  dd($request->all());
        $title_id = $request->title_id;
        $supervised_by = $request->supervised_by;
        $user_id = $request->user_id;
        if ($title_id == 82)
            $users = User::where('title_id', 177)
                ->where('id', '!=', $user_id)->get();
        else if ($title_id == 177)
            $users = User::where('title_id', 178)
                ->where('id', '!=', $user_id)->get();
        // dd($users);
        $selected = '';
        $html = ' <option value="0">اختر ..</option>';
        foreach ($users as $user) {
            $selected = '';
            if ($user->id == $supervised_by)
                $selected = 'selected=selected';
            $html .= '<option value="' . $user->id . '" ' . $selected . '>' . $user->name . '</option>';
        }
        return response()->json(['success' => true, 'html' => $html]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public
    function store(Request $request)
    {
        //dd($request->all());
        $user = New User();
        $user->name = $request->get('name');

        $user->email = $request->get('email');
        if ($request->has('password'))
            $user->password = bcrypt($request->get('password'));
        $user->address = $request->get('address');
        $user->mobile = $request->get('mobile');
        $user->user_type = $request->get('user_type');
        $user->title_id = $request->get('title_id');
        $user->supervised_by = ($request->get('supervised_by') != 0) ? $request->get('supervised_by') : null;

        $user->isActive = 1;
        if ($request->hasFile('user_image')) {

            $image = Input::file('user_image');
            $path = storeImage($image, '/users/', false);
            $user->user_image = '/users/' . $path;

        }
        if ($user->save()) {
            if ($request->has('district_id')) {
                $district_id = $request->get('district_id');

                foreach ($district_id as $option => $value) {
                    $userDistricts = new UserDistricts();
                    $userDistricts->user_id = $user->id;
                    $userDistricts->district_id = $value;
                    $userDistricts->save();
                }
            }
        }


        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
    {
        if (auth()->user()->user_type == 1) {
            $this->data['sub_menu'] = 'user-display';
            $this->data['location_title'] = 'عرض المستخدمين';
            $this->data['location_link'] = 'user';
            $this->data['title'] = 'المستخدمين';
            $this->data['page_title'] = 'تعديل بيانات مستخدم  ';
            $this->data['titles'] = Lookup::where('lookup_cat_id', 80)->get();
            $this->data['districts'] = Lookup::where('lookup_cat_id', 5)->get();
            $this->data['supervisors'] = User::where('user_type', 2)->get();
            $this->data['one_user'] = User::find($id);
            $this->data['user_districts'] = UserDistricts::where('user_id', '=', $id)->get();

            return view(user_vw() . '.edit')->with($this->data);
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, $id)
    {
        //dd($request->all());
        $user = User::find($id);
        $user->name = $request->get('name');

        // $user->email = $request->get('email');
        if ($request->has('password'))
            if ($user->password != $request->get('password')) {
                $user->password = bcrypt($request->get('password'));
            }

        $user->address = $request->get('address');
        $user->mobile = $request->get('mobile');
        $user->user_type = $request->get('user_type');
        $user->title_id = $request->get('title_id');
        if ($request->title_id == 81 || $request->title_id == 178)
            $user->supervised_by = null;
        else
            $user->supervised_by = ($request->get('supervised_by') != 0) ? $request->get('supervised_by') : $user->supervised_by;

        $user->isActive = 1;
        if ($request->hasFile('user_image')) {

            $image = Input::file('user_image');
            $path = storeImage($image, '/users/', false);
            $user->user_image = '/users/' . $path;

        }

        $user->save();
        if ($user->save()) {
            if ($request->has('district_id')) {
                $userDistricts = UserDistricts::where('user_id', $id)->delete();
                $district_id = $request->get('district_id');

                foreach ($district_id as $option => $value) {
                    $userDistricts = new UserDistricts();
                    $userDistricts->user_id = $id;
                    $userDistricts->district_id = $value;
                    $userDistricts->save();
                }
            }
        }
        return response()->json(['success' => true]);
    }

    public
    function userData00()
    {
        //   return Datatables::eloquent(User::query())->toJson();
        //
        // $user=User::all();

        $num = 1;
        return datatables()->of(User::query())
            ->addColumn('delChk', function ($item) {
                return '<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline"> <input type="checkbox" data-id= "' . $item->id . '" id="' . $item->id . '" class="checkboxes" value="1" /><span></span></label>';
            })
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('action', function ($user) {// as foreach ($users as $user)
                $html = '<div class="col-md-4" ><a href="' . url('/user/' . $user->id . '/edit') . '" type="button" class=" btn btn-icon-only green"><i class="fa fa-edit"></i></a></div>
                <div class="col-md-4" ><button type = "button" class="btn btn-icon-only red" title="حذف" onclick = "deleteUser(' . $user->id . ')" >
                <i class="fa fa-times" ></i ></button ></div >';
                if ($user->latitude != null)
                    $html .= '<div class="col-md-4" ><a  data-toggle="modal" href="#user-map" class="btn btn-icon-only blue" title="الموقع الحالي" onclick = "initMap2(' . $user->latitude . ',' . $user->longitude . ')" >
                <i class="fa fa-map-marker" ></i ></a ></div >';
                return $html;
            })
            ->addColumn('user_type_desc', function ($user) {// as foreach ($users as $user)
                if ($user->user_type == 1)
                    return 'مدير النظام';
                else if ($user->user_type == 2)
                    return 'مشرف';
                else
                    return 'باحث';
            })
            ->rawColumns(['action', 'delChk'])
            ->toJson();
    }

    public
    function userData()
    {
        //   return Datatables::eloquent(User::query())->toJson();
        //
        // $user=User::all();
        $model = User::query();
        if (auth()->user()->title_id == 82)//باحث
            $model = $model->where('id', '=', auth()->user()->id);
        if (auth()->user()->title_id == 177) {//مشرف ميداني
            $model = $model->where('supervised_by', '=', auth()->user()->id);
        }
        if (auth()->user()->title_id == 178) {//مشرف مكتبي
            $model = $model->where('supervised_by', '=', auth()->user()->id);
        }
        $num = 1;
        return datatables()->of($model)
            ->addColumn('delChk', function ($item) {
                return '<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline"> <input type="checkbox" data-id= "' . $item->id . '" id="' . $item->id . '" class="checkboxes" value="1" /><span></span></label>';
            })
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('action', function ($user) {// as foreach ($users as $user)
                $html = '<div class="col-md-2" ><a href="' . url('/user/' . $user->id . '/edit') . '" type="button" class=" btn btn-icon-only green"><i class="fa fa-edit"></i></a></div>
                <div class="col-md-4" ><button type = "button" class="btn btn-icon-only red" title="حذف" onclick = "deleteUser(' . $user->id . ')" >
                <i class="fa fa-times" ></i ></button ></div >';
                //   if ($user->latitude != null)
                $html .= ' <div class="col-md-2">
                <button type="button" data-toggle="modal" href="#guardianModal" class="btn btn-icon-only grey" onclick="openGuardianModal(' . $user->id . ')"><i class="fa fa-search"></i></button>
                </div>';
                $html .= '<div class="col-md-4" ><a   href="' . url('/user/' . $user->id . '/map') . '" class="btn btn-icon-only blue" title="الموقع الحالي"  >
                <i class="fa fa-map-marker" ></i ></a ></div >';
                return $html;
            })
            ->addColumn('user_type_desc', function ($user) {// as foreach ($users as $user)
                if ($user->user_type == 1)
                    return 'مدير النظام';
                else if ($user->user_type == 2)
                    return 'مشرف';
                else
                    return 'باحث';
            })->addColumn('title_desc', function ($user) {// as foreach ($users as $user)
                return $this->getLookup($user->title_id);
            })
            ->rawColumns(['action', 'delChk'])
            ->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        //
    }

    public
    function availabileEmail(Request $request)
    {
        //dd($request->email);
        $email = $request->email;
        $count = User::where('email', '=', $email)->count();
        if ($count >= 1)
            return response()->json(['success' => false]);
        else
            return response()->json(['success' => true]);

    }

    function del_one_user(Request $request)
    {
        $user_id = $request->id;
        $user = User::find($user_id);
        if ($user) {
            $user->delete();
            return response()->json(['success' => true]);
        }


    }

    function del_chk_user(Request $request)
    {
        //dd($request->all());

        $user_ids = $request->idArray;

        $users = User::whereIn('id', $user_ids)->delete();
        return response()->json(['success' => true]);
    }

    public
    function show_user_map(Request $request)
    {
        $id = $request->id;
        $P_FROM_DATE = $request->P_FROM_DATE;
        $P_TO_DATE = $request->P_TO_DATE;
        $config['center'] = 'Sydney Airport,Sydney';
        $config['zoom'] = '18';
        $config['map_height'] = '500px';

        $gmap = new GMaps();
        $gmap->initialize($config);

        $map = $gmap->create_map();
       // return view('map',compact('map'));

        $this->data['sub_menu'] = 'user-display';
        $this->data['P_FROM_DATE'] = $P_FROM_DATE;
        $this->data['P_TO_DATE'] = $P_TO_DATE;
        $this->data['user_id'] = $id;
        $this->data['map'] = $map;


        return view(user_vw() . '.newmap')->with($this->data);
    }

    function get_user_locations(Request $request)
    {

        //dd($request->all());
        $user_id = $request->user_id;
        // $currentdate = Carbon::now();
        $from = $request->from;//$currentdate->format('Y-m-d') ;
        $to = $request->to;//$currentdate->format('Y-m-d') ;
        //   DB::enableQueryLog(); // Enable query log
        $locations = UserLocation::where('user_id', '=', $user_id)
            // ->whereDate('create_on','=',$from)->get();
            ->whereBetween(DB::raw('DATE(create_on)'), array($from, $to))
            ->orderBy('create_on','DESC')
                ->get();
        //    dd(DB::getQueryLog()); // Show results of log
        //    dd($locations);
        $data = array();

        if (isset($locations)) {
            foreach ($locations as $location) {
                $data[] = [
                    'latitude' => $location->latitude,
                    'longitude' => $location->longitude,
                    'address' => $location->address,
                ];
            }
         //     dd($data);
            return response()->json(['success' => true, 'locations' => $data]);
        }
        return response()->json(['success' => false, 'locations' => $data]);

    }

    public
    function getGuardianDataold(Request $request)
    {
        $user_id = $request->user_id;
        $name = $request->name;
        $from = $request->from;
        $to = $request->to;
        $guardians = GuardianDetail::where('created_by', $user_id);
        $num = 1;
        if ($name != '')
            $guardians = $guardians->where('guardian', 'like', '%' . $name . '%');
        if ($from != '')
            $guardians = $guardians->whereDate('created_at', '>=', $from);
        if ($to != '')
            $guardians = $guardians->whereDate('created_at', '<=', $to);
        return datatables()->of($guardians)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('created_date', function ($model) {// as foreach ($users as $user)

                return $model->created_at->format('Y-m-d');
            })
            ->toJson();

    }

    public
    function getGuardianData(Request $request)
    {
        $user_id = $request->user_id;
        $name = $request->name;
        $from = $request->from;
        $to = $request->to;
        $guardians = GuardianDetail::where('created_by', $user_id);
        $num = 1;
        if ($name != '')
            $guardians = $guardians->where('guardian', 'like', '%' . $name . '%');
        if ($from != '')
            $guardians = $guardians->whereDate('created_at', '>=', $from);
        if ($to != '')
            $guardians = $guardians->whereDate('created_at', '<=', $to);
        return datatables()->of($guardians)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('created_date', function ($model) {// as foreach ($users as $user)

                return $model->created_at->format('Y-m-d H:i');
            })
            ->addColumn('duration', function ($model) {// as foreach ($users as $user)
                if (isset($model->duration))
                    return $this->formatMilliseconds($model->duration);
                return 0;
            })
            ->toJson();

    }

    function formatMilliseconds($milliseconds)
    {

        $seconds = floor($milliseconds / 1000);
        // dd($seconds);
        $minutes = floor($seconds / 60);
        $hours = floor($minutes / 60);
        //dd($hours);
        //  $milliseconds = $milliseconds % 1000;
        //$seconds = $seconds % 60;
        $minutes = $minutes % 60;

        //$format = '%u:%02u:%02u.%03u';
        //$time = sprintf($format, $hours, $minutes, $seconds, $milliseconds);
        return $hours . ':' . $minutes;//rtrim($time, '0');
    }
}
