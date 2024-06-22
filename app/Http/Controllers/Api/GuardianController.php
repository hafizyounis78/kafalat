<?php

namespace App\Http\Controllers\Api;

use App\Guardian;
use App\GuardianImage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GuardianController extends Controller
{
    public function insert_guardian(Request $request)
    {

        $rules = [
            'name' => 'required',
            'guardian_identity' => 'required|digits:9',
            'mobile1' => 'required|digits:10',
            //  'supporter_identity' => 'nullable|digits:9',
            'mobile2' => 'nullable|digits:10',


        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $errors = $this->validatorErrorMsg($rules, $messages);
            //   return response()->json(['success' => false, 'message' => $errors]);
            return response()->json(['status' => false, 'status_code' => 401, 'message' => $errors, 'data' => []]);

        }
        $user = auth()->user()->id;
        $guardian_identity = $request->guardian_identity;
        $guardian_name = $request->name;
        $mobile1 = $request->mobile1;
        $mobile2 = $request->mobile2;
        $district = $request->district;
        $city = $request->city;
        $neighborhood = $request->neighborhood;
        $full_address = $request->full_address;
        $supporter_name = $request->supporter_name;
        // $supporter_identity = $request->supporter_identity;
        $supporter_relationship = $request->supporter_relationship;
        $card_date_expired = $request->card_date_expired;
        $guardianship_date_expired = $request->guardianship_date_expired;
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        //  $map_img = $request->map_img;
        $sponser_id = $request->sponser_id;
        //    $path = '/guardian';
        //    $image = $this->put_img($map_img, $path);

        $guardian = Guardian::where('guardian_identity', $guardian_identity)->first();
        if (!isset($guardian)) {
            $guardian = new Guardian();
            $guardian->guardian_identity = $guardian_identity;
            $guardian->name = $guardian_name;
            $guardian->mobile1 = $mobile1;
            $guardian->mobile2 = $mobile2;
            $guardian->district = $district;
            $guardian->city = $city;
            $guardian->neighborhood = $neighborhood;
            $guardian->full_address = $full_address;
            $guardian->supporter_name = (isset($supporter_name) && ($supporter_name != '')) ? $supporter_name : $guardian_name;
            // $guardian->supporter_identity = (isset($supporter_identity) && ($supporter_identity != '')) ? $supporter_identity : $guardian_identity;
            $guardian->supporter_relationship = $supporter_relationship;
            $guardian->card_date_expired = $card_date_expired;
            $guardian->guardianship_date_expired = $guardianship_date_expired;
            $guardian->latitude = $latitude;
            $guardian->longitude = $longitude;
            //    $guardian->map_location_img = ($image != '') ? $image : $guardian->map_location_img;
            $guardian->created_by = $user;
        } else {
            $guardian->name = $guardian_name;
            $guardian->mobile1 = $mobile1;
            $guardian->mobile2 = $mobile2;
            $guardian->district = $district;
            $guardian->city = $city;
            $guardian->neighborhood = $neighborhood;
            $guardian->full_address = $full_address;
            $guardian->supporter_name = (isset($supporter_name) && ($supporter_name != '')) ? $supporter_name : $guardian_name;
            //   $guardian->supporter_identity = (isset($supporter_identity) && ($supporter_identity != '')) ? $supporter_identity : $guardian_identity;
            $guardian->supporter_relationship = $supporter_relationship;
            $guardian->card_date_expired = $card_date_expired;
            $guardian->guardianship_date_expired = $guardianship_date_expired;
            $guardian->latitude = $latitude;
            $guardian->longitude = $longitude;
            $guardian->sponser_id = $sponser_id;
            //     $guardian->map_location_img = ($image != '') ? $image : $guardian->map_location_img;
            $guardian->created_by = $user;
        }
        if ($guardian->save()) {
            $guardians = Guardian::where('guardian_identity', $guardian_identity)->first();
            $data = [
                'guardian_identity' => $guardian->guardian_identity,
                'name' => $guardian->name,
                'mobile1' => $guardian->mobile1,
                'mobile2' => $guardian->mobile2,
                'district' => $guardian->district,
                'district_name' => $this->getLookup($guardian->district),
                'city' => $guardian->city,
                'city_name' => $this->getLookup($guardian->city),
                'neighborhood' => $guardian->neighborhood,
                'full_address' => $guardian->full_address,
                'supporter_name' => $guardian->supporter_name,
                //   'supporter_identity' => $guardian->supporter_identity,
                'supporter_relationship' => $guardian->supporter_relationship,
                'card_date_expired' => $guardian->card_date_expired,
                'guardianship_date_expired' => $guardian->guardianship_date_expired,
                'latitude' => $guardian->latitude,
                'longitude' => $guardian->longitude,
                'sponser_id' => $guardian->sponser_id,
                //       'map_img' => url('public/storage/') . $guardian->map_location_img
            ];
            return response()->json(['status' => true, 'status_code' => 200, 'message' => ' تتم العملية بنجاح', 'data' => $data]);
        }
        return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => []]);
    }

    public function insert_raw_guardian(Request $request)
    {
        $data = $request->data;
        $result = array();
        //$exception = array();
       // print_r($request->all());exit;
        for ($i = 0; $i < count($data); $i++) {
            $user = auth()->user()->id;
            $guardian_identity = $data[$i]['guardian_identity'];
            $guardian_name = $data[$i]['name'];
            $mobile1 = $data[$i]['mobile1'];
            $mobile2 = $data[$i]['mobile2'];
            $district = $data[$i]['district'];
          //  $sponser_id = $data[$i]['sponser_id'];
            $city = $data[$i]['city'];
            $neighborhood = $data[$i]['neighborhood'];
            $full_address = $data[$i]['full_address'];
            $supporter_name = $data[$i]['supporter_name'];
            //  $supporter_identity = $data[$i]['supporter_identity'];
            $supporter_relationship = $data[$i]['supporter_relationship'];
            $card_date_expired = $data[$i]['card_date_expired'];
            $guardianship_date_expired = $data[$i]['guardianship_date_expired'];
            $latitude = $data[$i]['latitude'];
            $longitude = $data[$i]['longitude'];
            //   $map_img = $data[$i]['map_img'];
            $guardian_image = null;
            if (isset($data[$i]['guardian_image']))
                $guardian_image = $data[$i]['guardian_image'];

            //   $path = '/guardian';
            //  $image = $this->put_img($map_img, $path);
            $guardian = Guardian::where('guardian_identity', $guardian_identity)->first();
            if (!isset($guardian)) {
               // if ($this->checkSponseridExist($sponser_id, $guardian_identity)) {
                    $guardian = new Guardian();
                    $guardian->guardian_identity = $guardian_identity;
                    $guardian->name = $guardian_name;
                    $guardian->mobile1 = $mobile1;
                    $guardian->mobile2 = $mobile2;
                    $guardian->district = $district;
                    $guardian->city = $city;
                    $guardian->neighborhood = $neighborhood;
                    $guardian->full_address = $full_address;
                    $guardian->supporter_name = (isset($supporter_name) && ($supporter_name != '')) ? $supporter_name : $guardian_name;
                    //  $guardian->supporter_identity = (isset($supporter_identity) && ($supporter_identity != '')) ? $supporter_identity : $guardian_identity;
                    $guardian->supporter_relationship = $supporter_relationship;
                    $guardian->card_date_expired = $card_date_expired;
                    $guardian->guardianship_date_expired = $guardianship_date_expired;
                    $guardian->latitude = $latitude;
                    $guardian->longitude = $longitude;
                    //   $guardian->map_location_img = ($image != '') ? $image : $guardian->map_location_img;
                  //  $guardian->sponser_id = $sponser_id;
                    $guardian->created_by = $user;
             /*   } else {
                    // when sponser id exist with other guardian.
                    $exception = [
                        'id' => '',
                        'guardian_identity' => $guardian_identity,
                        'name' => $guardian_name,
                        'mobile1' => $mobile1,
                        'mobile2' => $mobile2,
                        'district' => $district,
                        'district_name' => $this->getLookup($district),
                        'city' => $city,
                        'city_name' => $this->getLookup($city),
                        'neighborhood' => $neighborhood,
                        'full_address' => $full_address,
                        'supporter_name' => $supporter_name,
                        //   'supporter_identity' => $guardian->supporter_identity,
                        'supporter_relationship' => $supporter_relationship,
                        'card_date_expired' => $card_date_expired,
                        'guardianship_date_expired' => $guardianship_date_expired,
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'sponser_id' => $sponser_id,
                        'guardian_image' => $guardian_image,
                        'created_at' => ''];
                }
                if (isset($guardian) && !$guardian->save())
                    return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $guardian]);*/
                    if (($guardian->save()) && isset($guardian_image))
                        $this->addGuardianImages($guardian_image, $guardian->id);
            }
            else {
            //    if ($this->checkSponseridExist($sponser_id, $guardian_identity)) {
                    $guardian->name = $guardian_name;
                    $guardian->mobile1 = $mobile1;
                    $guardian->mobile2 = $mobile2;
                    $guardian->district = $district;
                    $guardian->city = $city;
                    $guardian->neighborhood = $neighborhood;
                    $guardian->full_address = $full_address;
                    $guardian->supporter_name = (isset($supporter_name) && ($supporter_name != '')) ? $supporter_name : $guardian_name;
                    //    $guardian->supporter_identity = (isset($supporter_identity) && ($supporter_identity != '')) ? $supporter_identity : $guardian_identity;
                    $guardian->supporter_relationship = $supporter_relationship;
                    $guardian->card_date_expired = $card_date_expired;
                    $guardian->guardianship_date_expired = $guardianship_date_expired;
                    $guardian->latitude = $latitude;
                    $guardian->longitude = $longitude;
                  //  $guardian->sponser_id = $sponser_id;
                    //   $guardian->map_location_img = ($image != '') ? $image : $guardian->map_location_img;
                    $guardian->created_by = $user;
              //  }
//                else {
//                    // when sponser id exist with other guardian.
//                    $exception = [
//                        'id' => $guardian->id,
//                        'guardian_identity' => $guardian->guardian_identity,
//                        'name' => $guardian_name,
//                        'mobile1' => $mobile1,
//                        'mobile2' => $mobile2,
//                        'district' => $district,
//                        'district_name' => $this->getLookup($district),
//                        'city' => $city,
//                        'city_name' => $this->getLookup($city),
//                        'neighborhood' => $neighborhood,
//                        'full_address' => $full_address,
//                        'supporter_name' => $supporter_name,
//                        //   'supporter_identity' => $guardian->supporter_identity,
//                        'supporter_relationship' => $supporter_relationship,
//                        'card_date_expired' => $card_date_expired,
//                        'guardianship_date_expired' => $guardianship_date_expired,
//                        'latitude' => $latitude,
//                        'longitude' => $longitude,
//                        'sponser_id' => $sponser_id,
//                        'guardian_image' => $guardian_image,
//                        'created_at' => ''];
//                }
//                if (isset($guardian) && !$guardian->save())
//                    return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $guardian]);
//                else
                    if (($guardian->save()) && isset($guardian_image))
                        $this->addGuardianImages($guardian_image, $guardian->id);
            }
           // if (isset($guardian))
                $result[] = [
                    'id' => $guardian->id,
                    'guardian_identity' => $guardian->guardian_identity,
                    'name' => $guardian->name,
                    'mobile1' => $guardian->mobile1,
                    'mobile2' => $guardian->mobile2,
                    'district' => $guardian->district,
                    'district_name' => $this->getLookup($guardian->district),
                    'city' => $guardian->city,
                    'city_name' => $this->getLookup($guardian->city),
                    'neighborhood' => $guardian->neighborhood,
                    'full_address' => $guardian->full_address,
                    'supporter_name' => $guardian->supporter_name,
                    //   'supporter_identity' => $guardian->supporter_identity,
                    'supporter_relationship' => $guardian->supporter_relationship,
                    'card_date_expired' => $guardian->card_date_expired,
                    'guardianship_date_expired' => $guardian->guardianship_date_expired,
                    'latitude' => $guardian->latitude,
                    'longitude' => $guardian->longitude,
                    'sponser_id' => '',
                    //     'map_img' => url('public/storage/') . $guardian->map_location_img,
                    'guardian_image' => $this->getGardianImage($guardian->id),
                    'created_at' => $guardian->created_at->format('Y-m-d H:i')
                ];
            /*if (isset($exception) && count($exception) > 0)
                return response()->json(['status' => true, 'status_code' => 200, 'message' => ' تمت العملية بنجاح ,يوجد مشكله برقم الكفالة ورقم الهوية بالبيانات التالية', 'data' => $exception]);*/
        }
        return response()->json(['status' => true, 'status_code' => 200, 'message' => 'تمت العملية بنجاح', 'data' => $result]);
    }

    public function checkSponseridExist($sponser_id, $guardian_identity)
    {
        $guardian = Guardian::where('sponser_id', $sponser_id)->first();
        if (isset($guardian))
            if ($guardian->guardian_identity == $guardian_identity)
                return true;
            else
                return false;
        else
            return true;

    }

    public function addGuardianImages($images, $guardian_id)
    {

        // Beneficiary Images
        for ($i = 0; $i < count($images); $i++) {
            if ($images[$i]['image'] != '') {

                $image = new GuardianImage();
                $file = $images[$i]['image'];  // your base64 encoded
                $path = '/guardian';
                $fileName = $this->put_img($file, $path);
                $image->image_name = $fileName;
                $image->guardian_id = $guardian_id;
                $image->created_by = auth()->user()->id;
                $image->save();
            }
        }

        return response()->json(['status' => true, 'status_code' => 200, 'message' => ' تمت العملية بنجاح', 'data' => $images]);

    }

    public function put_img($img, $path)
    {
        if ($img != '') {
            $file = $img;  // your base64 encoded   $file = $data[$i]['image_name'];  // your base64 encoded
            $fullstring = $file;
            $ext = $this->get_string_between($fullstring, 'image/', ';base64');
            // dd($ext); // (result = dog)
            $file = str_replace('data:image/' . $ext . ';base64,', '', $file);
            $file = str_replace(' ', '+', $file);
            $fileName = str_random(10) . '.' . $ext;
            //  file_put_contents(public_path() . '\storage\reports' . '\\' . $fileName, base64_decode($file));
            file_put_contents(public_path() . '/storage/' . $path . '/' . $fileName, base64_decode($file));
            return $image = '/guardian/' . $fileName;
        } else
            return $image = '';

    }

    public function getGardianImage($guardian_id)
    {
        $images = GuardianImage::where('guardian_id', '=', $guardian_id)->get();
        $data = array();
        foreach ($images as $image) {
            $data[] = [
                'image_name' => url('public/storage/') . $image->image_name
            ];
        }
        return $data;
    }

    public function get_guardian(Request $request)
    {
        $rules = [
            'page_number' => 'required|integer',
            'per_page' => 'required|integer|min:1',

        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $messages = $validator->errors();
            $errors = $this->validatorErrorMsg($rules, $messages);
            //   return response()->json(['success' => false, 'message' => $errors]);
            return response()->json(['status' => false, 'status_code' => 401, 'message' => $errors, 'data' => []]);

        }

        $page_number = ($request->page_number <= 0) ? 1 : $request->page_number;
        $per_page = $request->per_page;
        // $user_id = auth()->user()->id;
        // dd(auth()->user()->id);
        $total_records = Guardian::where('created_by', auth()->user()->id)->count();
        $total_page = ceil($total_records / $per_page);
        $att = [
            'total_page' => $total_page,
            'page_number' => $page_number,
            'per_page' => $per_page
        ];
        $guardians = Guardian::where('created_by', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->take($per_page)
            ->skip(($page_number - 1) * $per_page)
            ->get();
        $data = array();
        if (isset($guardians)) {
            foreach ($guardians as $guardian)
                $data[] = [
                    'id' => $guardian->id,
                    'guardian_identity' => $guardian->guardian_identity,
                    'name' => $guardian->name,
                    'mobile1' => $guardian->mobile1,
                    'mobile2' => $guardian->mobile2,
                    'district' => $guardian->district,
                    'district_name' => $this->getLookup($guardian->district),
                    'city' => $guardian->city,
                    'city_name' => $this->getLookup($guardian->city),
                    'neighborhood' => $guardian->neighborhood,
                    'full_address' => $guardian->full_address,
                    'supporter_name' => $guardian->supporter_name,
                    //   'supporter_identity' => $guardian->supporter_identity,
                    'supporter_relationship' => $guardian->supporter_relationship,
                    'card_date_expired' => $guardian->card_date_expired,
                    'guardianship_date_expired' => $guardian->guardianship_date_expired,
                    'latitude' => $guardian->latitude,
                    'longitude' => $guardian->longitude,
                    'sponser_id' => $guardian->sponser_id,
                    'guardian_image' => $this->getGardianImage($guardian->id),
                    //            'map_img' => url('public/storage/') . $guardian->map_location_img,
                    'created_at' => $guardian->created_at->format('Y-m-d H:i'),
                ];

            return response()->json(['status' => true, 'status_code' => 200, 'message' => ' تمت العملية بنجاح', 'data' => $data, 'attribute' => $att]);
        }
        return response()->json(['status' => true, 'status_code' => 200, 'message' => ' تمت العملية بنجاح', 'data' => $data, 'attribute' => $att]);

    }

    public function get_guardian01(Request $request)
    {
        $rules = [
            'page_number' => 'required|integer',
            'per_page' => 'required|integer|min:1',

        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $messages = $validator->errors();
            $errors = $this->validatorErrorMsg($rules, $messages);
            //   return response()->json(['success' => false, 'message' => $errors]);
            return response()->json(['status' => false, 'status_code' => 401, 'message' => $errors, 'data' => []]);

        }

        $page_number = ($request->page_number <= 0) ? 1 : $request->page_number;
        $per_page = $request->per_page;
        // $user_id = auth()->user()->id;
        $total_records = Guardian::orderBy('created_by')->count();
        $total_page = ceil($total_records / $per_page);
        $att = [
            'total_page' => $total_page,
            'page_number' => $page_number,
            'per_page' => $per_page
        ];
        $guardians = Guardian::orderBy('created_by')
            ->take($per_page)
            ->skip(($page_number - 1) * $per_page)
            ->get();
        $data = array();
        if (isset($guardians)) {
            foreach ($guardians as $guardian)
                $data[] = [
                    'id' => $guardian->id,
                    'guardian_identity' => $guardian->guardian_identity,
                    'name' => $guardian->name,
                    'mobile1' => $guardian->mobile1,
                    'mobile2' => $guardian->mobile2,
                    'district' => $guardian->district,
                    'district_name' => $this->getLookup($guardian->district),
                    'city' => $guardian->city,
                    'city_name' => $this->getLookup($guardian->city),
                    'neighborhood' => $guardian->neighborhood,
                    'full_address' => $guardian->full_address,
                    'supporter_name' => $guardian->supporter_name,
                    //   'supporter_identity' => $guardian->supporter_identity,
                    'supporter_relationship' => $guardian->supporter_relationship,
                    'card_date_expired' => $guardian->card_date_expired,
                    'guardianship_date_expired' => $guardian->guardianship_date_expired,
                    'latitude' => $guardian->latitude,
                    'longitude' => $guardian->longitude,
                    'sponser_id' => $guardian->sponser_id,
                    'guardian_image' => $this->getGardianImage($guardian->id),
                    //            'map_img' => url('public/storage/') . $guardian->map_location_img,
                    'created_at' => $guardian->created_at->format('Y-m-d H:i'),
                ];

            return response()->json(['status' => true, 'status_code' => 200, 'message' => ' تمت العملية بنجاح', 'data' => $data, 'attribute' => $att]);
        }
        return response()->json(['status' => true, 'status_code' => 200, 'message' => ' تمت العملية بنجاح', 'data' => $data, 'attribute' => $att]);

    }

    public function get_guardian_byId(Request $request)
    {
        $rules = [
            'guardian_identity' => 'required|integer'

        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $messages = $validator->errors();
            $errors = $this->validatorErrorMsg($rules, $messages);
            //   return response()->json(['success' => false, 'message' => $errors]);
            return response()->json(['status' => false, 'status_code' => 401, 'message' => $errors, 'data' => []]);

        }

        $guardian_identity = $request->guardian_identity;


        $guardian = Guardian::where('guardian_identity', '=', $guardian_identity)->first();
        $data = '';
        if (isset($guardian)) {
            $data = [
                'id' => $guardian->id,
                'guardian_identity' => $guardian->guardian_identity,
                'name' => $guardian->name,
                'mobile1' => $guardian->mobile1,
                'mobile2' => $guardian->mobile2,
                'district' => $guardian->district,
                'district_name' => $this->getLookup($guardian->district),
                'city' => $guardian->city,
                'city_name' => $this->getLookup($guardian->city),
                'neighborhood' => $guardian->neighborhood,
                'full_address' => $guardian->full_address,
                'supporter_name' => $guardian->supporter_name,
                //  'supporter_identity' => $guardian->supporter_identity,
                'supporter_relationship' => $guardian->supporter_relationship,
                'card_date_expired' => $guardian->card_date_expired,
                'guardianship_date_expired' => $guardian->guardianship_date_expired,
                'latitude' => $guardian->latitude,
                'longitude' => $guardian->longitude,
                'sponser_id' => $guardian->sponser_id,
                // 'map_img' => url('public/storage/') . $guardian->map_location_img,
                'guardian_image' => $this->getGardianImage($guardian->id),
                'created_at' => $guardian->created_at->format('Y-m-d H:i'),
            ];

            return response()->json(['status' => true, 'status_code' => 200, 'message' => ' تمت العملية بنجاح', 'data' => $data]);
        }
        return response()->json(['status' => false, 'status_code' => 400, 'message' => '  لم تتم العملية بنجاح', 'data' => $data]);

    }
}
