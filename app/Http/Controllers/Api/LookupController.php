<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Lookup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LookupController extends Controller
{
    //
    public function getLookups(Request $request)
    {

        $rules = [

            'lookup_cat_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $messages = $validator->errors();
            $errors = $this->validatorErrorMsg($rules, $messages);
            //   return response()->json(['success' => false, 'message' => $errors]);
            return response()->json(['status' => false, 'status_code' => 401, 'message' => $errors, 'data' => []]);

        }
        $lookup = Lookup::where('lookup_cat_id', $request->lookup_cat_id)->first();
        return response()->json(['status' => true, 'status_code' => 200, 'data' => $lookup]);
    }

    public function getLookupAll(Request $request)
    {


    //    $lookups = Lookup::where('lookup_cat_id', '!=', 0)->get();
        $lookups =  Lookup::LeftJoin('statistic_lookup_settings', 'lookup.id', '=', 'statistic_lookup_settings.lookup_id')
            ->select('lookup.id as id', 'lookup_cat_id', 'lookup_cat_details', 'lookup_type','statistic_lookup_settings.account_type')
            ->where('lookup_cat_id', '!=', 0)
            ->orderBy('lookup.id','asc')
            ->get();
      //  $lookups = Lookup::all();
      /*  $lookups = Lookup::where('lookup_cat_id', '!=', 0)
        ->where('lookup.id','>=', 184)
        ->where('lookup.id','<=', 288)
            ->get();*/
        // $data[]='';
        foreach ($lookups as $lookup)
            $data[] = [
                'id' => $lookup->id,
                'lookup_cat_id' => $lookup->lookup_cat_id,
                'lookup_cat_details' => $lookup->lookup_cat_details,
                'lookup_type' => $lookup->lookup_type,
                'account_type' => $lookup->account_type
            ];
        //    dd($data);
        return response()->json(['status' => true, 'status_code' => 200, 'data' => $data]);
    }

    public function getStaticLookup(Request $request)
    {

        //  $this->getStaticLookupList(191,1);
       /* $rules = [

            'lookup_cat_id' => 'required',
            'account_type' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $messages = $validator->errors();
            $errors = $this->validatorErrorMsg($rules, $messages);
            return response()->json(['status' => false, 'status_code' => 401, 'message' => $errors, 'data' => []]);

        }*/

        $lookups =  Lookup::Join('statistic_lookup_settings', 'lookup.id', '=', 'statistic_lookup_settings.lookup_id')
            ->select('lookup.id as id', 'lookup_cat_id', 'lookup_cat_details', 'lookup_type','statistic_lookup_settings.account_type')
           // ->where('lookup.id','>=', 184)
           // ->where('lookup.id','<=', 288)
            // ->where('')
            //->whereIn('statistic_lookup_settings.account_type', [$account_type, 5])
            ->orderBy('lookup.id','asc')
            ->get();
        foreach ($lookups as $lookup)
            $data[] = [
                'id' => $lookup->id,
                'lookup_cat_id' => $lookup->lookup_cat_id,
                'lookup_cat_details' => $lookup->lookup_cat_details,
              //  'lookup_type' => $lookup->lookup_type,
                'account_type' => $lookup->account_type
            ];
     //   dd($lookup);
        return response()->json(['status' => true, 'status_code' => 200, 'data' => $data]);
    }
}
