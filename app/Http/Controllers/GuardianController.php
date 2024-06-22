<?php

namespace App\Http\Controllers;

use App\BeneficiariesProfile;
use App\Guardian;
use App\GuardianImage;
use Illuminate\Http\Request;

class GuardianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (in_array(1, auth()->user()->user_per)) {
            $this->data['sub_menu'] = 'guardian-display';
            $this->data['location_title'] = 'بيانات الأوصياء';
            $this->data['location_link'] = 'guardian';
            $this->data['title'] = 'الأوصياء';
            $this->data['page_title'] = 'عرض البيانات ';
            $this->data['districts'] = $this->getLookupList(5);//Lookup::where('lookup_cat_id', 5)->get();
            return view(guardian_vw() . '.view')->with($this->data);
        } else
            return redirect()->to('home');
    }

    public function getCity(Request $request)
    {
        $district_id = $request->district_id;
        $cities = $this->getLookupList($district_id);
        $html = '<option value="">اختر ..</option>';
        foreach ($cities as $city) {
            $html .= '<option value="' . $city->id . '">' . $city->lookup_cat_details . '</option>';
        }
        return response()->json(['success' => true, 'html' => $html]);

    }

    public function getGuardianData(Request $request)
    {

        $district = $request->district;
        $city = $request->city;
        $guardian_name = $request->guardian_name;
        $guardian_id = $request->guardian_id;
        $supporter_name = $request->supporter_name;
        // $supporter_id = $request->supporter_id;
        $card_fromdate = $request->card_fromdate;
        $card_todate = $request->card_todate;
        $guardian_fromdate = $request->guardian_fromdate;
        $guardian_todate = $request->guardian_todate;
        $sponser_id = $request->sponser_id;

        $guardians = Guardian::query();
        //dd($guardians->where('guardian_identity','=', $guardian_id)->first());
        $num = 1;
        if ($guardian_name != '') {

            $guardians = $guardians->where('name', 'like', '%' . $guardian_name . '%');
        }
        if ($supporter_name != '') {

            $guardians = $guardians->where('supporter_name', 'like', '%' . $supporter_name . '%');
        }
        if ($guardian_id != '') {

            $guardians = $guardians->where('guardian_identity', $guardian_id);
        }

        if ($sponser_id != '') {

            $guardians = $guardians->where('sponser_id', $sponser_id);
        }
        if ($card_fromdate != '')
            $guardians = $guardians->whereDate('card_date_expired', '>=', $card_fromdate);
        if ($card_todate != '')
            $guardians = $guardians->whereDate('card_date_expired', '<=', $card_todate);
        if ($guardian_fromdate != '')
            $guardians = $guardians->whereDate('guardianship_date_expired', '>=', $guardian_fromdate);
        if ($guardian_todate != '')
            $guardians = $guardians->whereDate('guardianship_date_expired', '<=', $guardian_todate);
        if ($district != '') {

            $guardians = $guardians->where('district', $district);
        }
        if ($city != '') {

            $guardians = $guardians->where('city', $city);
        }

        return datatables()->of($guardians)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('created_by_name', function ($model) {// as foreach ($users as $user)

                return $model->user_name;
            })
            ->addColumn('district', function ($model) {// as foreach ($users as $user)
                if (isset($model->district))
                    return $this->getLookup($model->district);
                return '';
            })->addColumn('city', function ($model) {// as foreach ($users as $user)
                if (isset($model->city))
                    return $this->getLookup($model->city);
                return '';
            })
            ->addColumn('action', function ($table) {// as foreach ($users as $user)
                $latitude = isset($table->latitude) ? $table->latitude : 'null';
                $longitude = isset($table->longitude) ? $table->longitude : 'null';
                return '
                  <div class="col-md-4">
                <button type="button" data-toggle="modal" href="#guardianImageModal" class="btn btn-icon-only red"
                onclick="openImageModal(' . $table->id . ')" title="عرض الوثائق"><i class="fa fa-image"></i></button>
             </div>
                <div class="col-md-4">
                <button type="button" data-toggle="modal" href="#sponsoredModal" class="btn btn-icon-only green"
                onclick="openSponsoredModal(' . $table->guardian_identity . ')" title="عرض الكفالات"><i class="fa fa-tasks"></i></button>
             </div>
             <div class="col-md-4" ><a  data-toggle="modal" href="#guardian-map" class="btn btn-icon-only blue" title="الموقع "
              onclick = "initMap2(' . $latitude . ',' . $longitude . ',\'' . $table->address . '\')" >
                <i class="fa fa-map-marker" ></i ></a ></div >';
            })
            ->rawColumns(['action',])
            ->toJson();
    }

    public function getSponsoredData(Request $request)
    {
        //dd($request->all());
        //  $user_id = $request->user_id;
        $guardian_identity = $request->guardian_identity;
        // dd($guardian_identity);
        if (isset($guardian_identity) && $guardian_identity != '')
            $beneficiaries_profile = BeneficiariesProfile::where('guardian_identity', $guardian_identity);
        $num = 1;


        return datatables()->of($beneficiaries_profile)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('created_date', function ($model) {// as foreach ($users as $user)

                return $model->created_at->format('Y-m-d H:i');
            })->addColumn('birth_date', function ($model) {// as foreach ($users as $user)

                return $model->birth_date;
            })
            ->addColumn('account_name', function ($model) {// as foreach ($users as $user)
                // $account_name = [1 => 'يتيم', 2 => 'معاق', 3 => 'اسرة', 4 => 'طالب'];
                //   $account_name = [4=> 'يتيم', 1 => 'معاق', 3=> 'اسرة', 2=> 'طالب'];
                $account_name = [1 => 'يتيم', 3 => 'معاق', 2 => 'اسرة', 4 => 'طالب'];
                return $account_name[$model->account_type];
            })
            ->addColumn('created_by_name', function ($model) {// as foreach ($users as $user)

                return $model->user_name;
            })
            ->addColumn('action', function ($table) {// as foreach ($users as $user)
                return '
                <div class="col-md-6">
                <button type="button"  class="btn btn-icon-only yellow-crusta" data-dismiss="modal"
                onclick="getVisits(' . $table->id . ')" title="عرض التقارير"><i class="fa fa-file"></i></button>
             </div>';
            })
            ->rawColumns(['action',])
            ->toJson();
    }

    public function getGuardianImage(Request $request)
    {
        $guardian_id = $request->guardian_id;
        $records = GuardianImage::where('guardian_id', $guardian_id)->get();
//dd(count($records));
        if (count($records) > 0) {
            $html = '<div class="row">';
            $i = 1;
            foreach ($records as $record) {

                if (fmod($i, 4) == 0)
                    $html .= '<div class="row">';
                $html .= '<div class="column"><img src = "' . url("public/storage/") . $record->image_name . '" alt="Not Found" style="width:70%"
                                                             onclick="myFunction(this);"></div>';

                if (fmod($i, 4) == 0) $html .= '</div>';
                $i++;

            }
            return response()->json(['success' => true, 'html' => $html]);
        }
        return response()->json(['success' => true, 'html' => '']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
