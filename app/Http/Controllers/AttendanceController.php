<?php

namespace App\Http\Controllers;

use App\AttendanceSheet;
use App\Employee;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (in_array(6, auth()->user()->user_per)) {
            $this->data['sub_menu'] = 'attendance-display';
            $this->data['location_title'] = 'عرض حركات الموظفين';
            $this->data['location_link'] = 'attendance';
            $this->data['title'] = 'الحضور والإنصراف';
            $this->data['page_title'] = 'عرض حركات الموظفين';
            $this->data['users'] = $this->getUserList();
            return view(attendance_vw() . '.view')->with($this->data);
        }
        //   return redirect()->back();
        return redirect()->to('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */


    public function attendanceData01(Request $request)
    {
        // dd($date);
        $from = $request->from;
        $to = $request->to;
        $user_id = $request->user_id;
        $model = AttendanceSheet::query();
        if (isset($user_id) && $user_id != null) {
            $model = $model->where('user_id', $user_id);
        }
        if (isset($from) && $from != null) {
            $model = $model->whereDate('attendance_date', '>=', $from);
        }
        if (isset($to) && $to != null) {
            $model = $model->whereDate('attendance_date', '<=', $to);
        }

        $num = 1;
        return datatables()->of($model)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('title_desc', function ($model) {// as foreach ($users as $user)

                return $this->getLookup($model->title_id);
            })
            ->addColumn('user_name', function ($model) {// as foreach ($users as $user)

                return $model->user_name;
            })
            ->addColumn('total_hour', function ($model) {// as foreach ($users as $user)

                if (isset($model->leave_time) && isset($model->attend_time))
                    $hr = (new  Carbon($model->leave_time))->diff(new Carbon($model->attend_time))->format('%h:%I');
                else
                    $hr = 0;
                return $hr;
            })
            ->rawColumns(['action', 'total_hour'])
            ->toJson();
    }
    public function attendanceData(Request $request)
    {
        // dd($date);
        $from = $request->from;
        $to = $request->to;
        $user_id = $request->user_id;
        $model = AttendanceSheet::query();
        if (auth()->user()->title_id == 82)//باحث
            $model = $model->where('user_id', '=', auth()->user()->id);
        if (auth()->user()->title_id == 177) {//مشرف ميداني
            $users = User::where('supervised_by', '=', auth()->user()->id)->pluck('id')->toArray();
            array_push($users,auth()->user()->id);
            $model = $model->whereIn('user_id', $users);
        }
        if (auth()->user()->title_id == 178) {//مشرف مكتبي
            $users = User::where('supervised_by', '=', auth()->user()->id)->pluck('id')->toArray();

            array_push($users,auth()->user()->id);
            $model = $model->whereIn('user_id', $users);
        }

        if (isset($user_id) && $user_id != null) {
            $model = $model->where('user_id', $user_id);
        }
        if (isset($from) && $from != null) {
            $model = $model->whereDate('attendance_date', '>=', $from);
        }
        if (isset($to) && $to != null) {
            $model = $model->whereDate('attendance_date', '<=', $to);
        }

        $num = 1;
        return datatables()->of($model)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('title_desc', function ($model) {// as foreach ($users as $user)

                return $this->getLookup($model->title_id);
            })
            ->addColumn('user_name', function ($model) {// as foreach ($users as $user)

                return $model->user_name;
            })
            ->addColumn('total_hour', function ($model) {// as foreach ($users as $user)

                if (isset($model->leave_time) && isset($model->attend_time))
                    $hr = (new  Carbon($model->leave_time))->diff(new Carbon($model->attend_time))->format('%h:%I');
                else
                    $hr = 0;
                return $hr;
            })
            ->rawColumns(['action', 'total_hour'])
            ->toJson();
    }
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    /*   public function getAttendByDate(Request $request)
       {
           $attend_date=$request->attend_date;
           $attendance=AttendanceSheet::where('date',$attend_date);

       }*/
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
