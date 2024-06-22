<?php

namespace App\Http\Controllers\Api;

use App\BeneficiariesProfile;
use App\Http\Controllers\Controller;
use App\ReferencesList;
use App\SystemNotifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class NotificationController extends Controller
{

    public function getMyNotification(Request $request)
    {
        $user_id = auth()->user()->id;
        $user_type = auth()->user()->type;
        //   dd($user_type);
        $rules = [
            'page_number' => 'required|integer',
            'per_page' => 'required|integer|min:1',
        ];
        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            $messages = $validate->errors();
            $errors = $this->validatorErrorMsg($rules, $messages);
            return response()->json(['status' => false, 'status_code' => 401, 'message' => $errors, 'data' => []]);
        } else {

            $page_number = ($request->page_number != 0) ? $request->page_number : 1;
            $per_page = $request->per_page;


            $user_notify_count = SystemNotifications::where('receiver_user_id', $user_id)
                // ->orWhereIn('not_type', [2, 3])
                ->count();
            $user_notifys = SystemNotifications::where('receiver_user_id', $user_id)
                //->orWhereIn('not_type', [2, 3])
                ->orderBy('created_at', 'desc')
                ->take($per_page)
                ->skip(($page_number - 1) * $per_page)->orderBy('created_at','asc')
                ->get();
            $data=array();
            foreach ($user_notifys as $record) {
                $referances = ReferencesList::find($record->referance_key);
                $benf = BeneficiariesProfile::where('id', $referances->beneficiary_index)->first();
                $data[] = [
                    'id' => $record->not_id,
                    'title' => $record->not_title,
                    'body' => $record->not_ar,
                    'account_type'=>$benf->account_type,
                    'referance_key' => $record->referance_key,
                    'report_status'=>$referances->report_status,
                    'notification_type'=>$record->not_type,
                    'not_date' => $record->not_date,
                    'expire_date' => $record->expire_date,
                    'seen_date' => $record->seen_date,

                ];
            }
            $this->seenNoti();
            $total_page = ceil($user_notify_count / $per_page);

            $this->seenNoti();

            $att = [
                'total_page' => $total_page,
                'page_number' => $page_number,
                'per_page' => $per_page
            ];
            return response()->json(['status' => true, 'status_code' => 200, 'data' => $data, 'attribute' => $att]);
        }


    }

    public function seenNoti()
    {
        $user_id = auth()->user()->id;

        $user_notifys = SystemNotifications::where('receiver_user_id', $user_id)
            ->where('seen_date', '=', null)->get();
        if (isset($user_notifys)) {

            foreach ($user_notifys as $user_notify) {


                $user_notify->seen_date = date('Y-m-d H:i:s');
                $user_notify->save();
            }
            return response()->json(['status' => true, 'status_code' => 200, 'data' => $user_notifys]);
        }
        return response()->json(['status' => true, 'status_code' => 200, 'data' => []]);
    }

    public
    function getbadge()
    {

        $user_id = auth()->user()->id;

        $user_notify_count = SystemNotifications::where('receiver_user_id', $user_id)
            ->where('seen_date', '=', null)->count();


        $bagdgCount = $user_notify_count;

        return response()->json(['status' => true, 'status_code' => 200, 'data' => $bagdgCount]);

    }
}
