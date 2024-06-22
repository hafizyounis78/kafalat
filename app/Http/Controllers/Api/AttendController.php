<?php

namespace App\Http\Controllers\Api;

use App\AttendanceSheet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\AttendRequest;

class AttendController extends Controller
{

    public function checkInOut(Request $request)
    {
        date_default_timezone_set("Asia/Gaza");
        $rules = [
            'user_id' => 'required|numeric|exists:users,id',
            'movement_type' => 'required'];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $messages = $validator->errors();
            $errors = $this->validatorErrorMsg($rules, $messages);
            //   return response()->json(['success' => false, 'message' => $errors]);
            return response()->json(['status' => false, 'status_code' => 401, 'message' => $errors, 'data' => []]);

        }
        $currentdate = Carbon::now();

        if ($request->movement_type == 1)            // Check In
        {

            $attend = AttendanceSheet::where('user_id', $request->user_id)
                ->whereDate('attendance_date', $currentdate->format('Y-m-d'))
                ->first();

            if (isset($attend)) {
                $old_note =$attend->note;
                $attend->attend_time = $currentdate->format('H:i');
                $attend->note = $old_note.'--'.$request->note;
                // $attend->created_by = auth()->user()->id;
                if ($attend->save())
                    return response()->json(['status' => true, 'status_code' => 200, 'message' => 'تمت العملية بنجاح', 'data' => $attend]);

                return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $request]);
            } else {

                $attend = new AttendanceSheet();
                $attend->user_id = auth()->user()->id;
                $attend->attendance_date = $currentdate->format('Y-m-d');
                $attend->attend_time = $currentdate->format('H:i');
                $attend->note = $request->note;
                $attend->created_by = $request->user_id;

                if ($attend->save())
                    return response()->json(['status' => true, 'status_code' => 200, 'message' => 'تمت العملية بنجاح', 'data' => $attend]);
            }
            return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $request]);


        } else if ($request->movement_type == 2)       // Check Out
        {
            $attend = AttendanceSheet::where('user_id', $request->user_id)
                ->whereDate('attendance_date', $currentdate->format('Y-m-d'))
                ->first();
            if (isset($attend)) {
                $old_note =$attend->note;
                $attend->leave_time = $currentdate->format('H:i');
                $attend->note =  $old_note.'--'.$request->note;
                // $attend->created_by = auth()->user()->id;
                if ($attend->save())
                    return response()->json(['status' => true, 'status_code' => 200, 'message' => 'تمت العملية بنجاح', 'data' => $attend]);

                return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $request]);
            } else
                return response()->json(['status' => false, 'status_code' => 401, 'message' => 'عذرا! لا يوجد دخول للموظف في هذا التاريخ', 'data' => $request]);


        } else {
            return response()->json(['status' => false, 'status_code' => 401, 'message' => 'عذرا! نوع الحركة خاطئ', 'data' => $request]);
        }


    }

    public function checkInOut00(Request $request)
    {
        $rules = [
            'user_id' => 'required|numeric|exists:users,id',
            'date' => 'required',
            'time' => 'required',
            'movement_type' => 'required'];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $messages = $validator->errors();
            $errors = $this->validatorErrorMsg($rules, $messages);
            //   return response()->json(['success' => false, 'message' => $errors]);
            return response()->json(['status' => false, 'status_code' => 401, 'message' => $errors, 'data' => []]);

        }

        if ($request->movement_type == 1)            // Check In
        {

            $attend = new AttendanceSheet();
            $attend->user_id = $request->user_id;
            $attend->attendance_date = $request->date;
            $attend->attend_time = $request->time;
            $attend->note = $request->note;
            $attend->created_by = $request->user_id;

            if ($attend->save())
                return response()->json(['status' => true, 'status_code' => 200, 'message' => 'تمت العملية بنجاح', 'data' => $attend]);

            return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $request]);


        } else if ($request->movement_type == 2)       // Check Out
        {
            $attend = AttendanceSheet::where('user_id', $request->user_id)
                ->whereDate('attendance_date', $request->date)
                ->first();
            if (isset($attend)) {
                $attend->leave_time = $request->time;
                $attend->note = $request->note;
                // $attend->created_by = auth()->user()->id;
                if ($attend->save())
                    return response()->json(['status' => true, 'status_code' => 200, 'message' => 'تمت العملية بنجاح', 'data' => $attend]);

                return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $request]);
            } else
                return response()->json(['status' => false, 'status_code' => 401, 'message' => 'عذرا! لا يوجد دخول للموظف في هذا التاريخ', 'data' => $request]);


        } else {
            return response()->json(['status' => false, 'status_code' => 401, 'message' => 'عذرا! نوع الحركة خاطئ', 'data' => $request]);
        }


    }

    public function checkInOutRaw_old(AttendRequest $request)
    {
        /*$rules= [

            'data.*.user_id' => 'required|numeric|exists:users,id',
            'data.*.attendance_date' => 'required',
            'data.*.attend_time' => 'required'
        ];


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $messages = $validator->errors();
            $errors = $this->validatorErrorMsg($rules, $messages);
            //   return response()->json(['success' => false, 'message' => $errors]);
         //   dd($errors);
            return response()->json(['status' => false, 'status_code' => 401, 'message' => $errors, 'data' => []]);

        }*/
        $data = $request->data;
        //  dd($data);
        for ($i = 0; $i < count($data); $i++) {

            $user_id = $data[$i]['user_id'];
            $attendance_date = $data[$i]['attendance_date'];
            $attend_time = $data[$i]['attend_time'];
            $leave_time = $data[$i]['leave_time'];
            $note = $data[$i]['note'];

            // dd($data[$i]['user_id']);
            $attend = AttendanceSheet::where('user_id', $user_id)
                ->whereDate('attendance_date', '=', $attendance_date)
                ->whereNotNull('attend_time')->first();
            if (!isset($attend)) {
                $attend = new AttendanceSheet();
                $attend->user_id = $user_id;
                $attend->attendance_date = $attendance_date;
                $attend->attend_time = $attend_time;
                $attend->note = $note;
                $attend->created_by = auth()->user()->id;
            } else {
                $attend->leave_time = $leave_time;
                $attend->note = ($note != '') ? $note : $attend->note;
            }
            $attend->save();
        }
        return response()->json(['status' => true, 'status_code' => 200, 'message' => 'تمت العملية بنجاح', 'data' => $attend]);

        // return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $request]);
    }

    public function checkInOutRaw(AttendRequest $request)
    {
        $data = $request->data;
        for ($i = 0; $i < count($data); $i++) {

            $user_id = $data[$i]['user_id'];
            $attendance_date = $data[$i]['attendance_date'];
            $attend_time = $data[$i]['attend_time'];
            $leave_time = $data[$i]['leave_time'];
            $note = $data[$i]['note'];

            $attend = AttendanceSheet::where('user_id', $user_id)
                ->whereDate('attendance_date', '=', $attendance_date)->first();
            //  ->whereNotNull('attend_time')->first();
            if (isset($attend)) {
                $attend->leave_time = ($leave_time != '') ? $leave_time : $attend->leave_time;
                $attend->attend_time = ($attend_time != '') ? $attend_time : $attend->attend_time;
                $attend->note = ($note != '') ? $note : $attend->note;

            } else {
                $attend = new AttendanceSheet();
                $attend->user_id = $user_id;
                $attend->attendance_date = $attendance_date;
                $attend->leave_time = ($leave_time != '') ? $leave_time : $attend->leave_time;
                $attend->attend_time = ($attend_time != '') ? $attend_time : $attend->attend_time;
                $attend->leave_time = ($leave_time != '') ? $leave_time : $attend->leave_time;
                $attend->note = ($note != '') ? $note : $attend->note;
                $attend->created_by = auth()->user()->id;
            }
            $attend->save();

        }
        return response()->json(['status' => true, 'status_code' => 200, 'message' => 'تمت العملية بنجاح', 'data' => $attend]);


        // return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $request]);
    }

    public function getAttendance(Request $request)
    {
        date_default_timezone_set("Asia/Gaza");
        $rules = [
            'month' => 'required',
            'year' => 'required',
            'page_number' => 'required|integer',
            'per_page' => 'required|integer|min:1'];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $messages = $validator->errors();
            $errors = $this->validatorErrorMsg($rules, $messages);
            //   return response()->json(['success' => false, 'message' => $errors]);
            return response()->json(['status' => false, 'status_code' => 401, 'message' => $errors, 'data' => []]);

        }
        $page_number = $request->page_number;
        $per_page = $request->per_page;
        $month = $request->month;
        $year = $request->year;
        $total_referances = AttendanceSheet::whereYear('attendance_date', $year)->whereMonth('attendance_date', $month)
            ->where('user_id', auth()->user()->id)
            ->count();
        $total_page = ceil($total_referances / $per_page);
        $attends = AttendanceSheet::whereYear('attendance_date', $year)->whereMonth('attendance_date', $month)
            ->where('user_id', auth()->user()->id)
            ->orderBy('attendance_date', 'attend_time')
            ->take($per_page)
            ->skip($page_number * $per_page)
            ->get();
        $att = [
            'total_page' => $total_page,
            'page_number' => $page_number,
            'per_page' => $per_page
        ];
        if ($attends->isEmpty())
            $data[] = ['month' => $request->month,
                'year' => $request->year
            ];


        return response()->json(['status' => true, 'status_code' => 200, 'message' => 'تمت العملية بنجاح', 'data' => $attends, 'attribute' => $att]);
    }
}
