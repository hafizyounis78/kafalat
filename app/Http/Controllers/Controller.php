<?php

namespace App\Http\Controllers;

use App\Lookup;
use App\User;
use App\UserDistricts;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function fullPath($path)
    {

        $url = '';
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            $url = $path;
        } else if (empty($path)) {
            $url = '';
        } else {
            $url = url('storage') . $path;
        }

        return $url;
    }

    public function validatorErrorMsg($rules, $errors)
    {

        $errorMsg = '';

        foreach ($rules as $key => $msg) {
            if (isset($errors->get($key)[0])) {
                $errorMsg = $errors->get($key)[0];
                break;
            }
        }
        return $errorMsg;
    }

    public function getLookup($id)
    {
        $lookup = Lookup::find($id);
        if (isset($lookup))
            return $lookup->lookup_cat_details;
        return '';

    }

    public function getUser($id)
    {
        $lookup = User::find($id);
        if ($lookup)
            return $lookup->name;
        return $id;
    }

    function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    public function getAccountType($id)
    {
        if ($id == 1)
            return 'يتيم';
        else if ($id == 2)
            return 'معاق';
        else if ($id == 3)
            return 'أسرة';
        else if ($id == 4)
            return 'طالب';

        return '';
    }

    public function getUserList01()
    {
        if (auth()->user()->user_type == 1)
            $user = User::whereIn('user_type', [2, 3])->get();
        else if (auth()->user()->user_type == 2)
            $user = $users = User::where('supervised_by', '=', auth()->user()->id)->get();
        else
            $user = User::where('id', '=', auth()->user()->id)->get();


        return $user;
    }
    public function getResearcherList()
    {

        if (auth()->user()->title_id == 82)//باحث
            $users = User::where('id', '=', auth()->user()->id)->get();
        else if (auth()->user()->title_id == 177) //مشرف ميداني
            $users = User::where('supervised_by', '=', auth()->user()->id)->orWhere('id', auth()->user()->id)->get();
        else if (auth()->user()->title_id == 178) //مشرف مكتبي
        {
            $user_list = User::where('supervised_by', '=', auth()->user()->id)->pluck('id')->toArray();

            array_push($user_list,auth()->user()->id);
          //  dd($user_list);
            $users = User::whereIn('supervised_by', $user_list)->orWhere('id', auth()->user()->id)->get();
        }
        else
            $users = User::all();
        return $users;
    }
    public function getUserList()
    {

        if (auth()->user()->title_id == 82)//باحث
            $users = User::where('id', '=', auth()->user()->id)->get();
        else if (auth()->user()->title_id == 177) //مشرف ميداني
            $users = User::where('supervised_by', '=', auth()->user()->id)->orWhere('id', auth()->user()->id)->get();
        else if (auth()->user()->title_id == 178) //مشرف مكتبي
            $users = User::where('supervised_by', '=', auth()->user()->id)->orWhere('id', auth()->user()->id)->get();
        else
            $users = User::all();
        return $users;
    }
    public function getDistrict()
    {
        if (auth()->user()->user_type == 1)
            $lookup = Lookup::where('lookup_cat_id', 5)->get();
        else {
            $user_district = UserDistricts::where('user_id', '=', auth()->user()->id)->pluck('district_id')->toArray();
            $lookup = Lookup::whereIn('id', $user_district)->get();
        }

        return $lookup;
    }

    public function getLookupList($id)
    {
        $lookup = Lookup::where('lookup_cat_id', $id)->get();
        if (!empty($lookup)) {
            return $lookup;
        }
        return '';
    }

    public function getStaticLookupList($id = null, $account_type = null)
    {
        if ($id != null && $account_type != null)
            $lookup = Lookup::Join('statistic_lookup_settings', 'lookup.id', '=', 'statistic_lookup_settings.lookup_id')
                ->select('lookup.id as id', 'lookup_cat_id', 'lookup_cat_details', 'lookup_type')
                ->where('lookup_cat_id', $id)
                // ->where('')
                ->whereIn('statistic_lookup_settings.account_type', [$account_type, 5])
                ->get();
        else


            if (!empty($lookup)) {
                return $lookup;
            }
        return '';
    }

    public function sendFcm($notification,$account_type,$report_status,$tokens,  $deviceType=1)
    {
        //dd($notification);

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20);

        $notificationBuilder = new PayloadNotificationBuilder($notification->not_title);
        $notificationBuilder->setBody($notification->not_ar)
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();

        /*  $dataBuilder->addData(['id' => $obj, 'title' => $title,
              'messages' => $body,
              'type' => 1]); */

        $dataBuilder->addData([
            'id'=>$notification->not_id,
            'title' => $notification->not_title,
            'body' => $notification->not_ar,
            'account_type'=>$account_type,
            'referance_key'=>$notification->referance_key,
            'report_status'=>$report_status,
            'notification_type'=>$notification->not_type,
            'not_date' => $notification->not_date,
            'expire_date' => $notification->expire_date,
            'seen_date' => $notification->seen_date
        ]);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

// You must change it to get your tokens
//        $tokens = User::pluck('fcmToken')->toArray();
        if ($deviceType == 1)
            $downstreamResponse = FCM::sendTo($tokens, $option, null, $data);
        else
            $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);
    }
    function sendSMS($mobile, $text)

    {
        $user_name = 'MP';
        $user_pass = 8568123;
        $sender = 'Q-Charity';

        $sms_url = 'http://www.hotsms.ps/sendbulksms.php';
        $postvars = 'user_name=' . $user_name . '&user_pass=' . $user_pass . '&sender=' . $sender . '&mobile=' . $mobile . '&type=0&text=' . $text;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $sms_url);

        curl_setopt($ch, CURLOPT_POST, 1);

        //  curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        $result = trim(curl_exec($ch));
        curl_close($ch);

        //   $headers = array('Content-Type: application/json');
        /*   $curl_handle = curl_init();
           curl_setopt($curl_handle, CURLOPT_URL, $sms_url);
           curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
           curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
           //curl_setopt($curl_handle, CURLOPT_USERAGENT, 'parent');
           //	curl_setopt($curl_handle, CURLOPT_HTTPHEADER, $headers);
           $result = curl_exec($curl_handle);

           curl_close($curl_handle);*/
        //  dd($result);
        //  exit;
        return $result;

    }
}
