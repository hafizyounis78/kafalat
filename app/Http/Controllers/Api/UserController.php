<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\UserLocation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    public function access_token(Request $request)
    {
        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        return Route::dispatch($proxy);
    }

    public function refresh_token(Request $request)
    {
        $proxy = Request::create(
            'oauth/token',
            'POST'
        );
        $response = Route::dispatch($proxy);


        $data = json_decode($response->getContent());
        $statusCode = json_decode($response->getStatusCode());

        if (isset($data->error)) {
            return [
                'status' => false,
                'status_code' => $statusCode,
                'message' => $data->message,
                'data' => []
            ];
        }


        return [
            'status' => true,
            'status_code' => 200,
            'message' => 'Success',
            'data' => [
                'token' => $data
            ]
        ];
    }

    public function login(Request $request)
    {


        $request->request->add(['email' => $request->get('username')]);
        $rules = [
            'email' => 'required|email',
            'password' => 'required|string',
            'fcm_token' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $messages = $validator->errors();
            $errors = $this->validatorErrorMsg($rules, $messages);
            //   return response()->json(['success' => false, 'message' => $errors]);
            return response()->json(['status' => false, 'status_code' => 401, 'message' => $errors, 'data' => []]);

        } else {

            $user = User::where('email', $request->get('email'))->first();

            if (isset($user)) {

                $userdata = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'mobile' => $user->mobile,
                    'type' => $user->user_type,
                    'image' => (!empty($user->user_image)) ? url('public/storage/') . $user->user_image : '',
                    'isActive' => $user->isActive,
                    'title_id' => $user->title_id,
                    'address' => $user->address,

                ];
                if ($user->isActive == 0) {
                    return response()->json(['success' => false, 'message' => 'User Not Active']);
                    //return $this->responseJson(true, 'not_active', ['token' => null, 'user' => $userdata], trans('users.user'));
                }
                $response = $this->access_token($request);

                $data = json_decode($response->getContent());
                $statusCode = json_decode($response->getStatusCode());

                if (isset($data->error)) {
                    return [
                        'status' => false,
                        'status_code' => $statusCode,
                        'message' => $data->message,
                        'data' => []
                    ];
                }
                $user->fcm_token = $request->fcm_token;
                $user->save();
                $userdata = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'mobile' => $user->mobile,
                    'type' => $user->user_type,
                    'image' => (!empty($user->user_image)) ? url('public/storage/') . $user->user_image : '',
                    'isActive' => $user->isActive,
                    'address' => $user->address,
                    'title_id' => $user->title_id,
                    'fcm_token' => $user->fcm_token,

                ];
                return [
                    'status' => true,
                    'status_code' => 200,
                    'message' => 'Success',
                    'data' => [
                        'token' => $data,
                        'user' => $userdata
                    ]
                ];
            }

        }

        return response()->json(['status' => false, 'status_code' => 401, 'message' => 'The user credentials were incorrect.', 'data' => []]);

    }

    public function myProfile()
    {
        $user = auth()->user();
        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'mobile' => $user->mobile,
            'type' => $user->user_type,
            'image' => (!empty($user->user_image)) ? url('public/storage/') . $user->user_image : '',
            'isActive' => $user->isActive,
            'title_id' => $user->title_id,
            'address' => $user->address,

        ];
     //   $this->clear();
        return response()->json(['status' => true, 'status_code' => 200, 'message' => 'تمت العملية بنجاح', 'data' => $data]);


    }

    public function updateProfile(Request $request)
    {
        $rules = [
            'user_id' => 'required|numeric|exists:users,id',
            //  'name' => 'required',
            //    'mobile' => 'required',
            //    'image' => 'required',
            //  'address' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $messages = $validator->errors();
            $errors = $this->validatorErrorMsg($rules, $messages);
            //   return response()->json(['success' => false, 'message' => $errors]);
            return response()->json(['status' => false, 'status_code' => 401, 'message' => $errors, 'data' => []]);

        }
        $user = auth()->user();
        $user->name = ($request->has('name') && $request->name != '') ? $request->name : $user->name;
        $user->mobile = ($request->has('mobile') && $request->mobile != '') ? $request->mobile : $user->mobile;
        $user->address = ($request->has('mobile') && $request->mobile != '') ? $request->address : $user->address;
        $user->title_id = ($request->has('title_id') && $request->title_id != '') ? $request->title_id : $user->title_id;
        if ($request->image != '') {
            $file = $request->image;  // your base64 encoded
            $fullstring = $file;
            $ext = $this->get_string_between($fullstring, 'image/', ';base64');
            $file = str_replace('data:image/' . $ext . ';base64,', '', $file);

            $file = str_replace(' ', '+', $file);
            $fileName = str_random(10) . '.' . $ext;

            file_put_contents(public_path() . '/storage/users' . '/' . $fileName, base64_decode($file));
            $user->user_image = '/users/' . $fileName;
        }
        $user->save();

        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'mobile' => $user->mobile,
            'type' => $user->user_type,
            'image' => (!empty($user->user_image)) ? url('public/storage/') . $user->user_image : '',
            'isActive' => $user->isActive,
            'title_id' => $user->title_id,
            'address' => $user->address,

        ];

        return response()->json(['status' => true, 'status_code' => 200, 'message' => 'تمت العملية بنجاح', 'data' => $data]);


    }

    public function logout()
    {
        $user = auth()->user();

        if (isset($user)) {
            $user->fcm_token = null;
            $user->save();
        }

        $user_id = auth()->user()->id;
        if (!isset($user_id)) {
            $value = \request()->bearerToken();
            $id = (new Parser())->parse($value)->getHeader('jti');
            $token = DB::table('oauth_access_tokens')
                ->where('id', '=', $id)
                ->update(['revoked' => true]);
        } else {

            $token = DB::table('oauth_access_tokens')
                ->where('user_id', '=', $user_id)
                ->update(['revoked' => true]);
        }

        if ($token)
            //return responseJson(true, 'logout', null, 200);
            return response()->json(['status' => true, 'status_code' => 200, 'message' => 'تمت العملية بنجاح', 'data' => []]);
        return response()->json(['status' => true, 'status_code' => 422, 'message' => 'لم تتم العملية بنجاح', 'data' => []]);
        //  return responseJson(false, 'not logout', null, 422);
    }

    public function forgetPassword(Request $request)
    {

        $response = Password::sendResetLink($request->only('email'), function (Message $message) {
            $message->subject('Password Reset');
        });

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return response()->json(['status' => true, 'status_code' => 200, 'message' => 'تمت العملية بنجاح', 'data' => []]);
            case Password::INVALID_USER:
                return response()->json(['status' => false, 'status_code' => 422, 'message' => 'لم تتم العملية بنجاح', 'data' => []]);

        }
        return response()->json(['status' => false, 'status_code' => 401, 'message' => 'The user credentials were incorrect.', 'data' => []]);
    }

    public function updateLocation(Request $request)
    {
        $rules = [
          //  'user_id' => 'required|numeric|exists:users,id',
            'latitude' => 'required',
            'longitude' => 'required',
            'address' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $messages = $validator->errors();
            $errors = $this->validatorErrorMsg($rules, $messages);
            //   return response()->json(['success' => false, 'message' => $errors]);
            return response()->json(['status' => false, 'status_code' => 401, 'message' => $errors, 'data' => []]);

        }
        $user = auth()->user();
       // dd($user->id);
        $location=new UserLocation();
        $location->user_id=$user->id;
        $location->latitude=$request->latitude;
        $location->longitude=$request->longitude;
        $location->address=$request->address;
        $location->create_on=date('Y-m-d H:i:s');
        $location->save();
        $user->latitude = $request->latitude;
        $user->longitude =$request->longitude;
        $user->save();

        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'mobile' => $user->mobile,
            'type' => $user->user_type,
            'image' => (!empty($user->user_image)) ? url('public/storage/') . $user->user_image : '',
            'isActive' => $user->isActive,
            'title_id' => $user->title_id,
            'address' => $user->address,
            'latitude'=>$user->latitude,
            'longitude'=>$user->longitude
        ];

        return response()->json(['status' => true, 'status_code' => 200, 'message' => 'تمت العملية بنجاح', 'data' => $data]);


    }
    public function getLocation(Request $request)
    {

        $user = auth()->user();


        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'address' => $user->address,
            'latitude'=>$user->latitude,
            'longitude'=>$user->longitude
        ];

        return response()->json(['status' => true, 'status_code' => 200, 'message' => 'تمت العملية بنجاح', 'data' => $data]);


    }
    function clear()
    {
       // date_default_timezone_set("Asia/Gaza");
    //    $currentdate = Carbon::now();
      //  dd($currentdate->format('h:i'));
      //  Artisan::call('cache:clear');
       // Artisan::call('config:clear');
        Artisan::call('vendor:publish --provider="LaravelFCM\FCMServiceProvider"');
       /* Artisan::call('config:cache');
        Artisan::call('route:cache');
        Artisan::call('view:clear');*/


        return "Cleared!";

    }
}
