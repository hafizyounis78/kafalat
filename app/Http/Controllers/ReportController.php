<?php

namespace App\Http\Controllers;

use App\AttendanceSheet;
use App\BeneficiariesProfile;
use App\BeneficiaryImage;
use App\BeneficiaryReferenceStatus;
use App\FamilyProject;
use App\Guardian;
use App\HealthRecord;
use App\LivingDetail;
use App\Lookup;
use App\Obstruction;
use App\OrphanNeed;
use App\OtherNeed;
use App\ReferencesList;
use App\ReligionEducation;
use App\ReportHeader;
use App\SchoolEducation;
use App\StatisticalCard;
use App\SuccessStory;
use App\SystemNotifications;
use App\UniversityEducation;
use App\User;
use App\VisitReport;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use PDF;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (in_array(2, auth()->user()->user_per)) {
            $this->data['sub_menu'] = 'report-display';
            $this->data['location_title'] = 'عرض التقارير';
            $this->data['location_link'] = 'report';
            $this->data['title'] = 'التقارير';
            $this->data['page_title'] = 'عرض التقارير ';
            $this->data['accountTypes'] = Lookup::where('lookup_cat_id', 8)->get();//نو الزيارة
            $this->data['districts'] = $this->getDistrict();//Lookup::where('lookup_cat_id', 5)->get();
            $this->data['users'] = $this->getResearcherList();
            $this->data['VisitorRecommends'] = $this->getLookupList(17);
            return view(report_vw() . '.view')->with($this->data);
        } else
            return redirect()->to('home');

    }

    public function system_report()
    {
        if (in_array(4, auth()->user()->user_per)) {
            $this->data['sub_menu'] = 'systemReport-display';
            $this->data['location_title'] = 'تقارير النظام';
            $this->data['location_link'] = 'system-report';
            $this->data['title'] = 'التقارير';
            $this->data['page_title'] = ' تقاريرالنظام ';
            $this->data['accountTypes'] = Lookup::where('lookup_cat_id', 8)->get();//نو الزيارة
            $this->data['users'] = User::all();
            return view(report_vw() . '.report')->with($this->data);
        } else
            return redirect()->to('home');
    }

    public function needs_report()
    {
        if (in_array(3, auth()->user()->user_per)) {
            $this->data['sub_menu'] = 'needs-display';
            $this->data['location_title'] = 'تقارير الإحتياجات';
            $this->data['location_link'] = 'needs-report';
            $this->data['title'] = 'التقارير';
            $this->data['page_title'] = ' تقارير الإحتياجات ';
            $this->data['accountTypes'] = Lookup::where('lookup_cat_id', 8)->get();//نو الزيارة
            $this->data['needsCategories'] = Lookup::where('lookup_cat_id', 184)->get();//تصنيف الاحتياجات
            $this->data['districts'] = $this->getDistrict();

            return view(report_vw() . '.needs_report')->with($this->data);
        } else
            return redirect()->to('home');
    }

    public function report_enquiry()
    {
        if (in_array(13, auth()->user()->user_per)) {
            $this->data['sub_menu'] = 'needs-display';
            $this->data['location_title'] = 'الاستعلام العام';
            $this->data['location_link'] = 'needs-report';
            $this->data['title'] = 'متابعاتي';
            $this->data['page_title'] = 'الاستعلام العام على حركات التقارير';
            $this->data['reportStatus'] = Lookup::where('lookup_cat_id', 289)->get();//حالى التقارير
            $this->data['accountTypes'] = Lookup::where('lookup_cat_id', 8)->get();//نو الزيارة
            $this->data['users'] = $this->getUserList();
            //    $this->data['needsCategories'] = Lookup::where('lookup_cat_id', 184)->get();//تصنيف الاحتياجات
            $this->data['districts'] = $this->getDistrict();

            return view(report_vw() . '.report_enquiry')->with($this->data);
        } else
            return redirect()->to('home');
    }

    public function get_sub_need(Request $request)
    {
        $id = $request->need_id;

        $lockups = $this->getLookupList($id);
        // dd($lockups);
        $html = '<option value="">اختر..</option>';
        foreach ($lockups as $lockup) {
            $html .= '<option value="' . $lockup->id . '">' . $lockup->lookup_cat_details . '</option>';
        }
        return response()->json(['success' => true, 'html' => $html]);

    }

    public function get_outcome_need(Request $request)
    {
        $id = $request->sub_need_id;
        $account_type = $request->account_type;
        $lockups = $this->getStaticLookupList($id, $account_type);
        $html = '<option value="">اختر..</option>';
        foreach ($lockups as $lockup) {
            $html .= '<option value="' . $lockup->id . '">' . $lockup->lookup_cat_details . '</option>';
        }
        return response()->json(['success' => true, 'html' => $html]);
    }

    public function visitsData(Request $request)
    {
        $beneficiary_index = $request->id;

        $model = ReferencesList::where('beneficiary_index', '=', $beneficiary_index)
            ->orderBy('visit_date', 'desc')
            ->orderBy('id', 'desc');
        $num = 1;
        return datatables()->of($model)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('user_name', function ($model) {// as foreach ($users as $user)

                return $this->getUser($model->visit_by);
            })
            ->addColumn('visit_name', function ($model) {// as foreach ($users as $user)

                return $this->getLookup($model->visit_type);
            })
            ->addColumn('action', function ($table) {// as foreach ($users as $user)
                return '

                <form action="' . url('yearly-print') . '" method="post">
                 <input type="hidden" name="referance_key" value="' . $table->id . '">
                 <input type="hidden" name="_token" value="' . csrf_token() . '">
               <div class="col-md-4">
                <a type="submit" target="_blank" href="' . url('yearly-print/') . '/' . $table->id . '" class="btn btn-icon-only green" title="تقرير سنوي"
                ><i class="fa fa-print"></i></a>
                </div>
                </form>

                 <form action="' . url('print') . '" method="post">
                 <input type="hidden" name="referance_key" value="' . $table->id . '">
                 <input type="hidden" name="_token" value="' . csrf_token() . '">
               <div class="col-md-4">
                <a type="submit" target="_blank" href="' . url('print/') . '/' . $table->id . '" class="btn btn-icon-only grey-cascade" title="تقرير متابعة"
                ><i class="fa fa-print"></i></a>
                </div>
                </form>
                <div class="col-md-4">
                <button type="button" data-toggle="modal" href="#detailModal" class="btn btn-icon-only blue-steel "
                onclick="viewReport(' . $table->id . ')"><i class="fa fa-eye"></i></button>
                </div>';
            })
            ->toJson();
    }
    public function filterVisitsData(Request $request)
    {
        $name = $request->name;
        $beneficiary_identity = $request->ben_id;
        $visit_type = $request->visit_type;
        $account_type = $request->account_type;
        $district_id = $request->district_id;
        $visit_by = $request->visit_by;
        $from = $request->fromdate;
        $to = $request->todate;
        $VisitorRecommend = $request->VisitorRecommend;
        $sponser_id = $request->sponser_id;
        $beneficiary_id = $request->beneficiary_id;
        //   $model = BeneficiariesProfile::Join('references_list','references_list.id','=','BeneficiariesProfile.last_referance_key')->all();
        $model = DB::table('beneficiaries_profile')
            ->join('references_list', 'references_list.id', '=', 'beneficiaries_profile.last_referance_key')
            ->leftJoin('visitor_report', 'visitor_report.referance_key', 'beneficiaries_profile.last_referance_key')
            /* ->select( DB::raw('full_name, account_type, beneficiaries_profile.beneficiary_identity,
                 visit_type, references_list.visit_date, city, sponser_id, visit_by, beneficiaries_profile.id, mobile_no, visitor_recommend,
                 beneficiary_reference_statuses.created_by as status_created_by, report_status, last_referance_key,
                 (SELECT max(id) FROM beneficiary_reference_statuses o WHERE o.referance_key=beneficiaries_profile.last_referance_key ) AS max_referance'));*/
            ->select('full_name', 'account_type', 'beneficiaries_profile.beneficiary_identity',
                'visit_type', 'references_list.visit_date', 'city', 'sponser_id', 'visit_by', 'beneficiaries_profile.id', 'mobile_no', 'visitor_recommend'
                , 'report_status', 'last_referance_key', 'full_address', 'latitude', 'longitude');
        // ->whereRaw('beneficiaries_profile.last_referance_key in (select max(id) from beneficiary_reference_statuses where beneficiary_reference_statuses.referance_key= beneficiaries_profile.last_referance_key)');
        if ($name != '') {
            $model = $model->where('full_name', 'like', '%' . $name . '%');
            // $model=$model->whereIn('id',$benfs);

        }
        //dd($model->get());
        if (auth()->user()->title_id == 82)//باحث
            $model = $model->where('visit_by', '=', auth()->user()->id);
        if (auth()->user()->title_id == 177) {//مشرف ميداني
            $users = User::where('supervised_by', '=', auth()->user()->id)->pluck('id')->toArray();
            // dd($users);
            $model = $model->whereIn('visit_by', $users);
        }
        if (auth()->user()->title_id == 178) {//مشرف مكتبي
            $model = $model->whereIn('report_status', [293, 294]);
            $users = User::where('supervised_by', '=', auth()->user()->id)->pluck('id')->toArray();
            array_push($users,auth()->user()->id);
            $model = $model->whereIn('report_status_updated_by', $users);
        }

        if ($account_type != '') {

            $model = $model->where('account_type', '=', $account_type);
            //  dd($benfs);
            //  $model=$model->whereIn('id',$benfs);
        }
        if ($district_id != '') {
            //      if (auth()->user()->user_type == 1)
            $model = $model->where('governorate', '=', $district_id);
        }
        if ($VisitorRecommend != '') {
            // if (auth()->user()->user_type == 1)
            $model = $model->where('visitor_recommend', '=', $VisitorRecommend);
        }
        if ($beneficiary_id != '') {

            $model = $model->where('beneficiary_id', '=', $beneficiary_id);
        }
        if ($sponser_id != '') {

            $model = $model->where('sponser_id', '=', $sponser_id);
        }
        if ($beneficiary_identity != '')
            $model = $model->where('beneficiaries_profile.beneficiary_identity', '=', $beneficiary_identity);
        if ($visit_type != '')
            $model = $model->where('visit_type', '=', $visit_type);
        if ($visit_by != '')
            $model = $model->where('visit_by', '=', $visit_by);
        if ($from != '')
            $model = $model->whereDate('visit_date', '>=', $from);
        if ($to != '')
            $model = $model->whereDate('visit_date', '<=', $to);
        $num = 1;
        $model = $model->where('beneficiaries_profile.deleted_at', '=', null);
        $model = $model->where('references_list.deleted_at', '=', null);
        //  $model = $model->groupBy('last_referance_key');
        $model = $model->orderBy('references_list.visit_date', 'DESC');
        return datatables()->of($model)
            ->addColumn('delChk', function ($item) {
                return '<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline"> <input type="checkbox" data-id= "' . $item->id . '" id="' . $item->id . '" class="checkboxes" value="1" /><span></span></label>';
            })
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('user_name', function ($model) {// as foreach ($users as $user)

                return $this->getUser($model->visit_by);
            })
            ->addColumn('visit_name', function ($model) {// as foreach ($users as $user)

                return $this->getLookup($model->visit_type);
            })
            ->addColumn('city_name', function ($model) {// as foreach ($users as $user)

                return $this->getLookup($model->city);
            })->addColumn('account_name', function ($model) {// as foreach ($users as $user)
                // $account_name = [1 => 'يتيم', 2 => 'معاق', 3 => 'اسرة', 4 => 'طالب'];
                //   $account_name = [4=> 'يتيم', 1 => 'معاق', 3=> 'اسرة', 2=> 'طالب'];
                $account_name = [1 => 'يتيم', 3 => 'معاق', 2 => 'اسرة', 4 => 'طالب'];
                return $account_name[$model->account_type];
            })
            ->addColumn('VisitorRecommend', function ($model) {// as foreach ($users as $user)
                return $this->getLookup($model->visitor_recommend);
            })
            ->addColumn('report_status', function ($model) {// as foreach ($users as $user)
                return $this->getLookup($model->report_status);
            })
            ->orderByNullsLast()
            /*  ->order(function ($query) {
                  if (request()->has('full_name')) {
                      $query->orderBy('full_name', 'desc');
                  }

                  if (request()->has('account_name')) {
                      $query->orderBy('account_type', 'desc');
                  }
              })*/
            // ->orderColumn('num', 'full_name $1')
            //->orderColumn('user_name', 'visit_by $1')
            ->orderColumn('visit_date', 'visit_date $1')
            ->orderColumn('account_name', '-account_type $1')
            ->orderColumn('full_name', 'full_name $1')
            ->orderColumn('VisitorRecommend', 'visitor_recommend $1')
            ->orderColumn('visit_name', 'visit_type $1')
            ->orderColumn('city_name', 'city $1')
            ->orderColumn('mobile_no', 'mobile_no $1')
            ->orderColumn('beneficiary_identity', 'beneficiary_identity $1')
            ->addColumn('control', function ($table) {// as foreach ($users as $user)
                $latitude = isset($table->latitude) ? $table->latitude : 'null';
                $longitude = isset($table->longitude) ? $table->longitude : 'null';

                return '<button type="button" data-toggle="modal" href="#visitsModal" class="btn btn-icon-only green"
                onclick="getVisits(' . $table->id . ')" title="تقرير الزيارات"><i class="fa fa-tasks"></i></button>
<a  data-toggle="modal" href="#ben-map" class="btn btn-icon-only blue" title="الموقع "
              onclick = "initMap2(' . $latitude . ',' . $longitude . ',\'' . $table->full_address . '\')" >
                <i class="fa fa-map-marker" ></i ></a >';
            })
            ->addColumn('action', function ($table) {// as foreach ($users as $user)

                return '
            <button type = "button" class="btn btn-icon-only red" title="حذف" onclick = "deleteBef(' . $table->id . ')" >
                <i class="fa fa-times" ></i ></button >';
            })
            ->rawColumns(['action','control', 'delChk'])
            ->toJson();
    }

    public function filterVisitsDataold2(Request $request)
    {
        $name = $request->name;
        $beneficiary_identity = $request->ben_id;
        $visit_type = $request->visit_type;
        $account_type = $request->account_type;
        $district_id = $request->district_id;
        $visit_by = $request->visit_by;
        $from = $request->fromdate;
        $to = $request->todate;
        $VisitorRecommend = $request->VisitorRecommend;
        $sponser_id = $request->sponser_id;
        $beneficiary_id = $request->beneficiary_id;
        //   $model = BeneficiariesProfile::Join('references_list','references_list.id','=','BeneficiariesProfile.last_referance_key')->all();
        $model = DB::table('beneficiaries_profile')
            ->join('references_list', 'references_list.id', '=', 'beneficiaries_profile.last_referance_key')
            ->leftJoin('visitor_report', 'visitor_report.referance_key', 'beneficiaries_profile.last_referance_key')
            /* ->select( DB::raw('full_name, account_type, beneficiaries_profile.beneficiary_identity,
                 visit_type, references_list.visit_date, city, sponser_id, visit_by, beneficiaries_profile.id, mobile_no, visitor_recommend,
                 beneficiary_reference_statuses.created_by as status_created_by, report_status, last_referance_key,
                 (SELECT max(id) FROM beneficiary_reference_statuses o WHERE o.referance_key=beneficiaries_profile.last_referance_key ) AS max_referance'));*/
            ->select('full_name', 'account_type', 'beneficiaries_profile.beneficiary_identity',
                'visit_type', 'references_list.visit_date', 'city', 'sponser_id', 'visit_by', 'beneficiaries_profile.id', 'mobile_no', 'visitor_recommend'
                , 'report_status', 'last_referance_key');
        // ->whereRaw('beneficiaries_profile.last_referance_key in (select max(id) from beneficiary_reference_statuses where beneficiary_reference_statuses.referance_key= beneficiaries_profile.last_referance_key)');
        if ($name != '') {
            $model = $model->where('full_name', 'like', '%' . $name . '%');
            // $model=$model->whereIn('id',$benfs);

        }
        //dd($model->get());
        if (auth()->user()->title_id == 82)//باحث
            $model = $model->where('visit_by', '=', auth()->user()->id);
        if (auth()->user()->title_id == 177) {//مشرف ميداني
            $users = User::where('supervised_by', '=', auth()->user()->id)->pluck('id')->toArray();
            // dd($users);
            $model = $model->whereIn('visit_by', $users);
        }
        if (auth()->user()->title_id == 178) {//مشرف مكتبي
            $model = $model->whereIn('report_status', [293, 294]);
            $users = User::where('supervised_by', '=', auth()->user()->id)->pluck('id')->toArray();

            $model = $model->whereIn('report_status_updated_by', [$users, auth()->user()->id]);
        }

        if ($account_type != '') {

            $model = $model->where('account_type', '=', $account_type);
            //  dd($benfs);
            //  $model=$model->whereIn('id',$benfs);
        }
        if ($district_id != '') {
            //      if (auth()->user()->user_type == 1)
            $model = $model->where('governorate', '=', $district_id);
        }
        if ($VisitorRecommend != '') {
            // if (auth()->user()->user_type == 1)
            $model = $model->where('visitor_recommend', '=', $VisitorRecommend);
        }
        if ($beneficiary_id != '') {

            $model = $model->where('beneficiary_id', '=', $beneficiary_id);
        }
        if ($sponser_id != '') {

            $model = $model->where('sponser_id', '=', $sponser_id);
        }
        if ($beneficiary_identity != '')
            $model = $model->where('beneficiaries_profile.beneficiary_identity', '=', $beneficiary_identity);
        if ($visit_type != '')
            $model = $model->where('visit_type', '=', $visit_type);
        if ($visit_by != '')
            $model = $model->where('visit_by', '=', $visit_by);
        if ($from != '')
            $model = $model->whereDate('visit_date', '>=', $from);
        if ($to != '')
            $model = $model->whereDate('visit_date', '<=', $to);
        $num = 1;
        $model = $model->where('beneficiaries_profile.deleted_at', '=', null);
        $model = $model->where('references_list.deleted_at', '=', null);
        //  $model = $model->groupBy('last_referance_key');
        $model = $model->orderBy('references_list.visit_date', 'DESC');
        return datatables()->of($model)
            ->addColumn('delChk', function ($item) {
                return '<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline"> <input type="checkbox" data-id= "' . $item->id . '" id="' . $item->id . '" class="checkboxes" value="1" /><span></span></label>';
            })
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('user_name', function ($model) {// as foreach ($users as $user)

                return $this->getUser($model->visit_by);
            })
            ->addColumn('visit_name', function ($model) {// as foreach ($users as $user)

                return $this->getLookup($model->visit_type);
            })
            ->addColumn('city_name', function ($model) {// as foreach ($users as $user)

                return $this->getLookup($model->city);
            })->addColumn('account_name', function ($model) {// as foreach ($users as $user)
                // $account_name = [1 => 'يتيم', 2 => 'معاق', 3 => 'اسرة', 4 => 'طالب'];
                //   $account_name = [4=> 'يتيم', 1 => 'معاق', 3=> 'اسرة', 2=> 'طالب'];
                $account_name = [1 => 'يتيم', 3 => 'معاق', 2 => 'اسرة', 4 => 'طالب'];
                return $account_name[$model->account_type];
            })
            ->addColumn('VisitorRecommend', function ($model) {// as foreach ($users as $user)
                return $this->getLookup($model->visitor_recommend);
            })
            ->addColumn('report_status', function ($model) {// as foreach ($users as $user)
                return $this->getLookup($model->report_status);
            })
            ->orderByNullsLast()
            /*  ->order(function ($query) {
                  if (request()->has('full_name')) {
                      $query->orderBy('full_name', 'desc');
                  }

                  if (request()->has('account_name')) {
                      $query->orderBy('account_type', 'desc');
                  }
              })*/
            // ->orderColumn('num', 'full_name $1')
            //->orderColumn('user_name', 'visit_by $1')
            ->orderColumn('visit_date', 'visit_date $1')
            ->orderColumn('account_name', '-account_type $1')
            ->orderColumn('full_name', 'full_name $1')
            ->orderColumn('VisitorRecommend', 'visitor_recommend $1')
            ->orderColumn('visit_name', 'visit_type $1')
            ->orderColumn('city_name', 'city $1')
            ->orderColumn('mobile_no', 'mobile_no $1')
            ->orderColumn('beneficiary_identity', 'beneficiary_identity $1')
            ->addColumn('action', function ($table) {// as foreach ($users as $user)
                return '

                <button type="button" data-toggle="modal" href="#visitsModal" class="btn btn-icon-only blue"
                onclick="getVisits(' . $table->id . ')" title="تقرير الزيارات"><i class="fa fa-tasks"></i></button>

            <button type = "button" class="btn btn-icon-only red" title="حذف" onclick = "deleteBef(' . $table->id . ')" >
                <i class="fa fa-times" ></i ></button >';
            })
            ->rawColumns(['action', 'delChk'])
            ->toJson();
    }

    public function filterNeedsData(Request $request)
    {
        // dd($request->all());
        $account_type = $request->account_type;
        $need_id = $request->need_id;
        $sub_need_id = $request->sub_need_id;
        $need_outcome_id = $request->need_outcome_id;
        $district_id = $request->district_id;
        $from = $request->fromdate;
        $to = $request->todate;
        //   $model = BeneficiariesProfile::Join('references_list','references_list.id','=','BeneficiariesProfile.last_referance_key')->all();
        $model = DB::table('beneficiaries_profile')
            ->join('references_list', 'references_list.id', '=', 'beneficiaries_profile.last_referance_key')
            ->leftJoin('visitor_report', 'visitor_report.referance_key', 'beneficiaries_profile.last_referance_key')
            ->Join('statistical_cards', 'statistical_cards.referance_key', 'beneficiaries_profile.last_referance_key')
            ->select('full_name', 'account_type', 'beneficiaries_profile.beneficiary_identity',
                'visit_type', 'references_list.visit_date', 'visitor_recommend', 'city', 'sponser_id', 'visit_by', 'beneficiaries_profile.id', 'mobile_no',
                'statistical_cards.need_id', 'statistical_cards.sub_need_id',
                'statistical_cards.need_outcome_id', 'report_status', 'last_referance_key');


        if (auth()->user()->title_id == 82)//باحث
            $model = $model->where('visit_by', '=', auth()->user()->id);
        if (auth()->user()->title_id == 177) {//مشرف ميداني
            $users = User::where('supervised_by', '=', auth()->user()->id)->pluck('id')->toArray();
            // dd($users);
            $model = $model->whereIn('visit_by', $users);
        }
        if (auth()->user()->title_id == 178) {//مشرف مكتبي
            $model = $model->whereIn('report_status', [293, 294]);
            $users = User::where('supervised_by', '=', auth()->user()->id)->pluck('id')->toArray();
            array_push($users,auth()->user()->id);
            $model = $model->whereIn('report_status_updated_by', $users);
        }

        if ($account_type != '') {

            $model = $model->where('account_type', '=', $account_type);
        }
        if ($district_id != '') {
            //      if (auth()->user()->user_type == 1)
            $model = $model->where('governorate', '=', $district_id);
        }
        if ($need_id != '') {
            $model = $model->where('need_id', '=', $need_id);
        }
        if ($sub_need_id != '') {

            $model = $model->where('sub_need_id', '=', $sub_need_id);
        }
        if ($need_outcome_id != '') {

            $model = $model->where('need_outcome_id', '=', $need_outcome_id);
        }
        if ($from != '')
            $model = $model->whereDate('visit_date', '>=', $from);
        if ($to != '')
            $model = $model->whereDate('visit_date', '<=', $to);
        $num = 1;
        $model = $model->where('beneficiaries_profile.deleted_at', '=', null);
        $model = $model->where('references_list.deleted_at', '=', null);
        //  $model = $model->groupBy('last_referance_key');
        $model = $model->orderBy('references_list.visit_date', 'DESC');
        return datatables()->of($model)
            /* ->addColumn('delChk', function ($item) {
                 return '<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline"> <input type="checkbox" data-id= "' . $item->id . '" id="' . $item->id . '" class="checkboxes" value="1" /><span></span></label>';
             })*/
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            /*->addColumn('user_name', function ($model) {// as foreach ($users as $user)

                return $this->getUser($model->visit_by);
            })*/
            ->addColumn('city_name', function ($model) {// as foreach ($users as $user)

                return $this->getLookup($model->city);
            })
            ->addColumn('need_id', function ($model) {// as foreach ($users as $user)

                return $this->getLookup($model->need_id);
            })
            ->addColumn('sub_need_id', function ($model) {// as foreach ($users as $user)

                return $this->getLookup($model->sub_need_id);
            })->addColumn('sub_need_id', function ($model) {// as foreach ($users as $user)

                return $this->getLookup($model->sub_need_id);
            })
            ->addColumn('need_outcome_id', function ($model) {// as foreach ($users as $user)
                return $this->getLookup($model->need_outcome_id);
            })
            ->addColumn('report_status', function ($model) {// as foreach ($users as $user)
                return $this->getLookup($model->report_status);
            })
            ->addColumn('account_name', function ($model) {// as foreach ($users as $user)
                // $account_name = [1 => 'يتيم', 2 => 'معاق', 3 => 'اسرة', 4 => 'طالب'];
                //   $account_name = [4=> 'يتيم', 1 => 'معاق', 3=> 'اسرة', 2=> 'طالب'];
                $account_name = [1 => 'يتيم', 3 => 'معاق', 2 => 'اسرة', 4 => 'طالب'];
                return $account_name[$model->account_type];
            })
            ->orderByNullsLast()
            /*  ->order(function ($query) {
                  if (request()->has('full_name')) {
                      $query->orderBy('full_name', 'desc');
                  }

                  if (request()->has('account_name')) {
                      $query->orderBy('account_type', 'desc');
                  }
              })*/
            // ->orderColumn('num', 'full_name $1')
            //->orderColumn('user_name', 'visit_by $1')
            ->orderColumn('visit_date', 'visit_date $1')
            ->orderColumn('account_name', '-account_type $1')
            ->orderColumn('full_name', 'full_name $1')
            ->orderColumn('VisitorRecommend', 'visitor_recommend $1')
            ->orderColumn('visit_name', 'visit_type $1')
            ->orderColumn('city_name', 'city $1')
            ->orderColumn('mobile_no', 'mobile_no $1')
            ->orderColumn('beneficiary_identity', 'beneficiary_identity $1')
            ->addColumn('action', function ($table) {// as foreach ($users as $user)
                return '<button type="button" data-toggle="modal" href="#visitsModal" class="btn btn-icon-only blue"
                onclick="getVisits(' . $table->id . ')" title="تقرير الزيارات"><i class="fa fa-tasks"></i></button>';
            })
            ->rawColumns(['action', 'delChk'])
            ->toJson();
    }

    public function filterEnquiryData(Request $request)
    {
        $name = $request->name;
        $beneficiary_identity = $request->ben_id;
        $visit_type = $request->visit_type;
        $account_type = $request->account_type;
        $district_id = $request->district_id;
        $visit_by = $request->visit_by;
        $from = $request->fromdate;
        $to = $request->todate;
        $sponser_id = $request->sponser_id;
        $beneficiary_id = $request->beneficiary_id;
        $all_report = $request->all_report;
        //   $model = BeneficiariesProfile::Join('references_list','references_list.id','=','BeneficiariesProfile.last_referance_key')->all();
        if ($all_report == 1)
            $model = DB::table('beneficiaries_profile')
                ->join('references_list', 'references_list.id', '=', 'beneficiaries_profile.last_referance_key')
                ->leftJoin('visitor_report', 'visitor_report.referance_key', 'beneficiaries_profile.last_referance_key')
                ->select('full_name', 'account_type', 'beneficiaries_profile.beneficiary_identity', 'references_list.id as referance_key',
                    'visit_type', 'references_list.visit_date', 'city', 'sponser_id', 'visit_by', 'beneficiaries_profile.id', 'mobile_no', 'visitor_recommend'
                    , 'report_status', 'last_referance_key');
        else
            $model = DB::table('beneficiaries_profile')
                ->join('references_list', 'references_list.beneficiary_index', '=', 'beneficiaries_profile.id')
                ->leftJoin('visitor_report', 'visitor_report.referance_key', 'references_list.id')
                ->select('full_name', 'account_type', 'beneficiaries_profile.beneficiary_identity', 'references_list.id as referance_key',
                    'visit_type', 'references_list.visit_date', 'city', 'sponser_id', 'visit_by', 'beneficiaries_profile.id', 'mobile_no', 'visitor_recommend'
                    , 'report_status', 'last_referance_key');
        // ->whereRaw('beneficiaries_profile.last_referance_key in (select max(id) from beneficiary_reference_statuses where beneficiary_reference_statuses.referance_key= beneficiaries_profile.last_referance_key)');

        if ($name != '') {
            $model = $model->where('full_name', 'like', '%' . $name . '%');
            // $model=$model->whereIn('id',$benfs);

        }

        if ($account_type != '') {

            $model = $model->where('account_type', '=', $account_type);
            //  dd($benfs);
            //  $model=$model->whereIn('id',$benfs);
        }
        if ($district_id != '') {
            //      if (auth()->user()->user_type == 1)
            $model = $model->where('governorate', '=', $district_id);
        }

        if ($beneficiary_id != '') {

            $model = $model->where('beneficiary_id', '=', $beneficiary_id);
        }
        if ($sponser_id != '') {

            $model = $model->where('sponser_id', '=', $sponser_id);
        }
        if ($beneficiary_identity != '')
            $model = $model->where('beneficiaries_profile.beneficiary_identity', '=', $beneficiary_identity);
        if ($visit_type != '')
            $model = $model->where('visit_type', '=', $visit_type);
        if ($visit_by != '')
            $model = $model->where('visit_by', '=', $visit_by);
        if ($from != '')
            $model = $model->whereDate('visit_date', '>=', $from);
        if ($to != '')
            $model = $model->whereDate('visit_date', '<=', $to);
        $num = 1;
        $model = $model->where('beneficiaries_profile.deleted_at', '=', null);
        $model = $model->where('references_list.deleted_at', '=', null);
        //  $model = $model->groupBy('last_referance_key');
        $model = $model->orderBy('beneficiaries_profile.beneficiary_identity', 'DESC');
        $model = $model->orderBy('references_list.visit_date', 'DESC');
        return datatables()->of($model)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('user_name', function ($model) {// as foreach ($users as $user)

                return $this->getUser($model->visit_by);
            })
            ->addColumn('visit_name', function ($model) {// as foreach ($users as $user)

                return $this->getLookup($model->visit_type);
            })
            ->addColumn('city_name', function ($model) {// as foreach ($users as $user)

                return $this->getLookup($model->city);
            })->addColumn('account_name', function ($model) {// as foreach ($users as $user)
                // $account_name = [1 => 'يتيم', 2 => 'معاق', 3 => 'اسرة', 4 => 'طالب'];
                //   $account_name = [4=> 'يتيم', 1 => 'معاق', 3=> 'اسرة', 2=> 'طالب'];
                $account_name = [1 => 'يتيم', 3 => 'معاق', 2 => 'اسرة', 4 => 'طالب'];
                return $account_name[$model->account_type];
            })
            ->addColumn('VisitorRecommend', function ($model) {// as foreach ($users as $user)
                return $this->getLookup($model->visitor_recommend);
            })
            ->addColumn('report_status', function ($model) {// as foreach ($users as $user)
                return $this->getLookup($model->report_status);
            })
            ->orderByNullsLast()
            /*  ->order(function ($query) {
                  if (request()->has('full_name')) {
                      $query->orderBy('full_name', 'desc');
                  }

                  if (request()->has('account_name')) {
                      $query->orderBy('account_type', 'desc');
                  }
              })*/
            // ->orderColumn('num', 'full_name $1')
            //->orderColumn('user_name', 'visit_by $1')
            ->orderColumn('visit_date', 'visit_date $1')
            ->orderColumn('account_name', '-account_type $1')
            ->orderColumn('full_name', 'full_name $1')
            ->orderColumn('VisitorRecommend', 'visitor_recommend $1')
            ->orderColumn('visit_name', 'visit_type $1')
            ->orderColumn('city_name', 'city $1')
            ->orderColumn('mobile_no', 'mobile_no $1')
            ->orderColumn('beneficiary_identity', 'beneficiary_identity $1')
            ->addColumn('action', function ($table) {// as foreach ($users as $user)
                return '<button type="button" data-toggle="modal" href="#reportModal" class="btn btn-icon-only blue"
                onclick="getAllReportStatus(' . $table->referance_key . ')" title="تقرير الزيارات"><i class="fa fa-tasks"></i></button>';
            })
            ->rawColumns(['action', 'delChk'])
            ->toJson();
    }

    public function get_report_status_byReference(Request $request)
    {

        $referance_key = $request->referance_key;
        $model = BeneficiaryReferenceStatus::where('referance_key', $referance_key);
        $model = $model->orderBy('created_at', 'DESC');
        return datatables()->of($model)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('user_name', function ($model) {// as foreach ($users as $user)

                return $this->getUser($model->created_by);
            })
            ->addColumn('report_status', function ($model) {// as foreach ($users as $user)
                return $this->getLookup($model->status);
            })
            ->addColumn('created_at', function ($model) {// as foreach ($users as $user)
                return $model->created_at->format('Y-m-d');
            })

            //->rawColumns()
            ->toJson();

    }

    public function filterExcel(Request $request)
    {
        $name = $request->name;
        $beneficiary_identity = $request->ben_id;
        $visit_type = $request->visit_type;
        $account_type = $request->account_type;
        $district_id = $request->district_id;
        $visit_by = $request->visit_by;
        $from = $request->fromdate;
        $to = $request->todate;
        $VisitorRecommend = $request->VisitorRecommend;
        $sponser_id = $request->sponser_id;
        $beneficiary_id = $request->beneficiary_id;
        //   $model = BeneficiariesProfile::Join('references_list','references_list.id','=','BeneficiariesProfile.last_referance_key')->all();
        $model = DB::table('beneficiaries_profile')
            ->join('references_list', 'references_list.id', '=', 'beneficiaries_profile.last_referance_key')
            ->leftJoin('family_project', 'family_project.referance_key', '=', 'beneficiaries_profile.last_referance_key')
            ->leftJoin('health_records', 'health_records.referance_key', '=', 'beneficiaries_profile.last_referance_key')
            ->leftJoin('living_details', 'living_details.referance_key', '=', 'beneficiaries_profile.last_referance_key')
            ->leftJoin('obstructions', 'obstructions.referance_key', '=', 'beneficiaries_profile.last_referance_key')
            //  ->leftJoin('orphan_needs', 'orphan_needs.referance_key', '=', 'beneficiaries_profile.last_referance_key')
            ->leftJoin('other_needs', 'other_needs.referance_key', '=', 'beneficiaries_profile.last_referance_key')
            ->leftJoin('success_stories', 'success_stories.referance_key', '=', 'beneficiaries_profile.last_referance_key')
            ->leftJoin('religion_education', 'religion_education.referance_key', '=', 'beneficiaries_profile.last_referance_key')
            ->leftJoin('school_education', 'school_education.referance_key', '=', 'beneficiaries_profile.last_referance_key')
            ->leftJoin('university_educations', 'university_educations.referance_key', '=', 'beneficiaries_profile.last_referance_key')
            ->leftJoin('visitor_report', 'visitor_report.referance_key', '=', 'beneficiaries_profile.last_referance_key')//;//->get();
            ->select('beneficiaries_profile.*', 'references_list.*', 'family_project.*', 'health_records.*', 'living_details.*', 'school_education.*',
                'university_educations.*', 'visitor_report.*', 'obstructions.*', /*'orphan_needs.*',*/ 'religion_education.*');
        if ($name != '') {
            $model = $model->where('full_name', 'like', '%' . $name . '%');
            // $model=$model->whereIn('id',$benfs);

        }

        if (auth()->user()->title_id == 82)//باحث
            $model = $model->where('visit_by', '=', auth()->user()->id);
        if (auth()->user()->title_id == 177) {//مشرف ميداني
            $users = User::where('supervised_by', '=', auth()->user()->id)->pluck('id')->toArray();
            // dd($users);
            $model = $model->whereIn('visit_by', $users);
        }
        if (auth()->user()->title_id == 178) {//مشرف مكتبي
            $model = $model->whereIn('report_status', [293, 294]);
            $users = User::where('supervised_by', '=', auth()->user()->id)->pluck('id')->toArray();
            array_push($users,auth()->user()->id);
            $model = $model->whereIn('report_status_updated_by', $users);
        }
        if ($account_type != '') {

            $model = $model->where('account_type', '=', $account_type);
            //  dd($benfs);
            //  $model=$model->whereIn('id',$benfs);
        }
        if ($district_id != '') {
            //   if (auth()->user()->user_type == 1)
            $model = $model->where('governorate', '=', $district_id);
        }
        if ($VisitorRecommend != '') {
            //   if (auth()->user()->user_type == 1)
            $model = $model->where('visitor_recommend', '=', $VisitorRecommend);
        }
        if ($beneficiary_id != '') {

            $model = $model->where('beneficiary_id', '=', $beneficiary_id);
        }
        if ($sponser_id != '') {

            $model = $model->where('sponser_id', '=', $sponser_id);
        }
        if ($beneficiary_identity != '')
            $model = $model->where('beneficiaries_profile.beneficiary_identity', '=', $beneficiary_identity);
        // dd($model->count());
        if ($visit_type != '')
            $model = $model->where('visit_type', '=', $visit_type);
        if ($visit_by != '')
            $model = $model->where('visit_by', '=', $visit_by);
        if ($from != '')
            $model = $model->whereDate('visit_date', '>=', $from);
        if ($to != '')
            $model = $model->whereDate('visit_date', '<=', $to);
        $num = 1;
        $model = $model->where('beneficiaries_profile.deleted_at', '=', null);
        $model = $model->where('references_list.deleted_at', '=', null);
//        $model = $model->orderBy('references_list.visit_date', 'DESC');//->get();
        //   dd($model->get());
        return datatables()->of($model)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('user_name', function ($model) {// as foreach ($users as $user)
                if (isset($model->visit_by))
                    return $this->getUser($model->visit_by);
                return '';
            })
            ->addColumn('visit_name', function ($model) {// as foreach ($users as $user)
                if (isset($model->visit_type))
                    return $this->getLookup($model->visit_type);
                return '';
            })
            ->addColumn('report_status', function ($model) {// as foreach ($users as $user)
                if (isset($model->report_status))
                    return $this->getLookup($model->report_status);
                return '';
            })
            ->addColumn('gender_name', function ($model) {// as foreach ($users as $user)
                if (isset($model->gender))
                    return $this->getLookup($model->gender);
                return '';
            })
            ->addColumn('marital_status_name', function ($model) {// as foreach ($users as $user)
                if (isset($model->marital_status))
                    return $this->getLookup($model->marital_status);
                return '';
            })
            ->addColumn('city_name', function ($model) {// as foreach ($users as $user)
                if (isset($model->city))
                    return $this->getLookup($model->city);
                return '';
            })
            ->addColumn('governorate_name', function ($model) {// as foreach ($users as $user)
                if (isset($model->governorate))
                    return $this->getLookup($model->governorate);
                return '';
            })
            ->addColumn('nationality_name', function ($model) {// as foreach ($users as $user)
                if (isset($model->nationality))
                    return $this->getLookup($model->nationality);
                return '';
            })
            ->addColumn('guardian_relation_name', function ($model) {// as foreach ($users as $user)
                if (isset($model->guardian_relation))
                    return $this->getLookup($model->guardian_relation);
                return '';
            })->addColumn('study_level_name', function ($model) {// as foreach ($users as $user)
                if (isset($model->study_level))
                    return $this->getLookup($model->study_level);

            })->addColumn('study_class_name', function ($model) {// as foreach ($users as $user)
                if (isset($model->study_class))
                    return $this->getLookup($model->study_class);
                return '';
            })->addColumn('health_status_name', function ($model) {// as foreach ($users as $user)
                if (isset($model->health_status))
                    return $this->getLookup($model->health_status);
                return '';
            })->addColumn('live_type_name', function ($model) {// as foreach ($users as $user)
                if (isset($model->live_type))
                    return $this->getLookup($model->live_type);
                return '';
            })
            /*  ->addColumn('live_needs_name', function ($model) {// as foreach ($users as $user)
                  if (isset($model->live_needs))
                      return $this->getLookup($model->live_needs);
                  return '';
              })->addColumn('what_needed_name', function ($model) {// as foreach ($users as $user)
                  if (isset($model->what_needed))
                      return $this->getLookup($model->what_needed);
                  return '';
              })*/
            ->addColumn('currentlevel_name', function ($model) {// as foreach ($users as $user)
                if (isset($model->currentlevel))
                    return $this->getLookup($model->currentlevel);
                return '';
            })
            ->addColumn('account_name', function ($model) {// as foreach ($users as $user)
                // $account_name = [1 => 'يتيم', 2 => 'معاق', 3 => 'اسرة', 4 => 'طالب'];
                //   $account_name = [4=> 'يتيم', 1 => 'معاق', 3=> 'اسرة', 2=> 'طالب'];
                $account_name = [1 => 'يتيم', 3 => 'معاق', 2 => 'اسرة', 4 => 'طالب'];
                return $account_name[$model->account_type];
            })
            ->addColumn('VisitorRecommend', function ($model) {// as foreach ($users as $user)
                if (isset($model->visitor_recommend))
                    return $this->getLookup($model->visitor_recommend);
                return '';
            })
            ->addColumn('praying_name', function ($model) {// as foreach ($users as $user)
                if (isset($model->praying))
                    return $this->getLookup($model->praying);
                return '';
            })
            /*  ->addColumn('currency_name', function ($model) {// as foreach ($users as $user)
                  if (isset($model->currency))
                      return $this->getLookup($model->currency);
                  return '';
              })*/
            /* ->addColumn('memorizes_quran_name', function ($model) {// as foreach ($users as $user)
                 if (isset($model->memorizes_quran))
                     return $this->getLookup($model->memorizes_quran);
                 return '';
             })*/
            ->toJson();
    }

    public function getOneVisit(Request $request)
    {
        //  $account_name = [1 => 'يتيم', 2 => 'معاق', 3 => 'اسرة', 4 => 'طالب'];___old
        // $account_name = [4=> 'يتيم', 1 => 'معاق', 3=> 'اسرة', 2=> 'طالب'];____new
        //  $account_name = [1=> 'يتيم', 3 => 'معاق', 2=> 'اسرة', 4=> 'طالب'];
        $referance_key = $request->referance_key;

        $referance = ReferencesList::find($referance_key);

        if (isset($referance)) {
            $beneficiary_identity = $referance->beneficiary_identity;
            $one_profile = $this->getProfile($referance->beneficiary_index);

            $one_live = $this->getLiving($referance_key);
            // dd($one_live);
            $one_visit_report = $this->getVisitReport($referance_key);
            $one_image = $this->getBenImage($referance_key);//BeneficiaryImage::where('referance_key', $referance_key)->get();
            $one_family = $this->getFamily($referance_key);
            $one_story = $this->getStory($referance_key);
            $one_StatisticalCard = $this->getStatisticalCard($referance_key);
            $one_otherNeed = $this->getOtherNeed($referance_key);
            $report_status_list = $this->getReportStatusList(auth()->user()->title_id);
            $report_status_table = $this->getReportStatustable($referance_key);
            $one_guardian = $this->getGuardianById($one_profile['guardian_identity']);
            $one_school = '';
            $one_health = '';
            $one_religion = '';
            $one_orphan = '';
            $one_university = '';
            $one_obstruction = '';
            //    dd($one_profile['account_type']);
            if ($one_profile['account_type'] == 1) {
                $one_school = $this->getSchool($referance_key);
                $one_health = $this->getHealthRecord($referance_key);
                $one_religion = $this->getReligion($referance_key);
                $one_orphan = $this->getOrphan($referance_key);


            } else if ($one_profile['account_type'] == 3) {

                //  $one_university = $this->getUniversity($referance_key);
                $one_school = $this->getSchool($referance_key);
                $one_obstruction = $this->getObstruction($referance_key);
                $one_health = $this->getHealthRecord($referance_key);


            } else if ($one_profile['account_type'] == 2) {


            } else if ($one_profile['account_type'] == 4) {
                $one_university = $this->getUniversity($referance_key);


            }
            $data = [
                'one_profile' => $one_profile,
                'one_guardian' => $one_guardian,
                'one_live' => $one_live,
                'one_visit_report' => $one_visit_report,
                'one_image' => $one_image,
                'one_family' => $one_family,
                'one_health' => $one_health,
                'one_university' => $one_university,
                'one_obstruction' => $one_obstruction,
                'one_orphan' => $one_orphan,
                'one_school' => $one_school,
                'one_religion' => $one_religion,
                'one_statisticard' => $one_StatisticalCard,
                'one_otherNeed' => $one_otherNeed,
                'one_story' => $one_story,
                'report_status_list' => $report_status_list,
                'report_status_table' => $report_status_table,
                'referance_key' => $referance_key
            ];

            return response()->json(['success' => true, 'visit' => $data]);
        }
        return response()->json(['success' => false, 'visit' => []]);

    }

    public function getProfile($beneficiary_index)
    {

        $beneficiary = BeneficiariesProfile::find($beneficiary_index);

        //   $account_name = [1 => 'يتيم', 2 => 'معاق', 3 => 'اسرة', 4 => 'طالب'];
        $account_name = [1 => 'يتيم', 3 => 'معاق', 2 => 'اسرة', 4 => 'طالب'];
        if (isset($beneficiary)) {
            $data = [
                'account_type' => $beneficiary->account_type,
                'account_type_desc' => $account_name[$beneficiary->account_type],
                'beneficiary_id' => $beneficiary->beneficiary_id,
                'sponser_id' => $beneficiary->sponser_id,
                'beneficiary_identity' => $beneficiary->beneficiary_identity,
                'full_name' => $beneficiary->full_name,
                'gender' => $this->getLookup($beneficiary->gender),
                'birth_date' => $beneficiary->birth_date,
                'guardian' => $beneficiary->guardian,
                'guardian_identity' => $beneficiary->guardian_identity,
                'guardian_relation' => $this->getLookup($beneficiary->guardian_relation),
                'nationality' => $this->getLookup($beneficiary->nationality),
                'governorate' => $this->getLookup($beneficiary->governorate),
                'city' => $this->getLookup($beneficiary->city),
                'neighborhood' => $beneficiary->neighborhood,
                'full_address' => $beneficiary->full_address,
                'home_location' => $beneficiary->home_location,
                'latitude' => $beneficiary->latitude,
                'longitude' => $beneficiary->longitude,
                'mobile_no' => $beneficiary->mobile_no,
                'mobile_no1' => $beneficiary->mobile_no1,
                'phone' => $beneficiary->phone,
                'marital_status' => $this->getLookup($beneficiary->marital_status),
                'last_referance_key' => $beneficiary->last_referance_key,
                'nearist_quran' => $beneficiary->nearist_quran,
                'nearist_institute' => $beneficiary->nearist_institute,
                'created_by' => $this->getUser($beneficiary->created_by)];

            return $data;
        }
        return '';


    }

    public function getLiving($referance_key)
    {
        $records = LivingDetail::where('referance_key', $referance_key)->first();
        if (isset($records)) {
            $data = [
                'live_details' => $records->live_details,
                'live_area' => $records->live_area,
                'live_type' => $this->getLookup($records->live_type),
                'live_needs' => $this->getLookup($records->live_needs),
                'development_needs' => $records->development_needs,
                'created_by' => $this->getUser($records->created_by)];

            return $data;
        }
        return '';

    }

    public function getVisitReport($referance_key)
    {
        $records = VisitReport::where('referance_key', $referance_key)->first();
        if (isset($records)) {
            $data = [
                //Full texts	id	health_status	health_status_details	food_details	workout_details	referance_key
                'visitor_goals' => $records->visitor_goals,
                'health_updates' => $records->health_updates,
                'educational_updates' => $records->educational_updates,
                'economical_updates' => $records->economical_updates,
                'social_updates' => $records->social_updates,
                'living_updates' => $records->living_updates,
                'general_note' => $records->general_note,
                'visitor_recommend' => $this->getLookup($records->visitor_recommend),
                'visitor_stop_resone' => $records->visitor_stop_resone,
                'created_by' => $this->getUser($records->created_by)];

            return $data;
        }
        return '';

    }

    public function getBenImage($referance_key)
    {
        $records = BeneficiaryImage::where('referance_key', $referance_key)->get();
//dd(count($records));
        if (count($records) > 0) {
            $html = '<div class="row">';
            $i = 1;
            foreach ($records as $record) {

                if (fmod($i, 4) == 0)
                    $html .= '<div class="row">';
                $html .= '<div class="column"><img src = "' . url("public/storage/") . $record->image_name . '" alt="Nature" style="width:70%"
                                                             onclick="myFunction(this);"></div>';

                if (fmod($i, 4) == 0) $html .= '</div>';
                $i++;

            }
            return $html;
        }
        return [];
    }

    public function getFamily($referance_key)
    {
        $records = FamilyProject::where('referance_key', $referance_key)->first();
        if (isset($records)) {
            $data = [
                //Full texts	id	health_status	health_status_details	food_details	workout_details	referance_key
                'project_name' => $records->project_name,
                'project_details' => $records->project_details,
                'success_indecation' => $records->success_indecation,
                'created_by' => $this->getUser($records->created_by)];

            return $data;
        }
        return '';

    }

    public function getStory($referance_key)
    {
        $records = SuccessStory::where('referance_key', $referance_key)->first();
        if (isset($records)) {
            $data = [

                'story_details' => $records->story_details];

            return $data;
        }
        return '';

    }

    public function getStatisticalCard($referance_key)
    {
        $records = StatisticalCard::where('referance_key', $referance_key)->get();
        $html = '';
        $i = 0;
        foreach ($records as $record) {
            $html .= '<tr><td>' . ++$i . '</td>';
            $html .= '<td>' . $this->getLookup($record->need_id) . '</td>';
            $html .= '<td>' . $this->getLookup($record->sub_need_id) . '</td>';
            $html .= '<td>' . $this->getLookup($record->need_outcome_id) . '</td></tr>';
        }
        return $html;
    }

    public function getOtherNeed($referance_key)
    {
        $records = OtherNeed::where('referance_key', $referance_key)->first();
        if (isset($records)) {
            $data = [

                'need_details' => $records->need_details];

            return $data;
        }
        return '';
    }

    public function getReportStatusList($title_id)
    {
        if ($title_id == 177 || auth()->user()->user_type==1)
            $lookups = Lookup::whereIn('id', [291, 292, 293])->get();
        else if ($title_id == 178)
            $lookups = Lookup::where('id', 294)->get();
        $html = '<option value="">اختر..</option>';
        if (!empty($lookups)) {
            foreach ($lookups as $lookup)
                $html .= '<option value="' . $lookup->id . '">' . $lookup->lookup_cat_details . '</option>';
        }
        return $html;
    }

    public function getReportStatustable($referance_key)
    {
        $referance_lists = BeneficiaryReferenceStatus::where('referance_key', $referance_key)->get();
        $html = '';
        $i = 0;
        foreach ($referance_lists as $value) {
            $html .= '<tr><td>' . ++$i . '</td>';
            $html .= '<td>' . $this->getLookup($value->status) . '</td>';
            $html .= '<td>' . $this->getUser($value->created_by) . '</td>';
            $html .= '<td>' . $value->created_at->format('Y-m-d') . '</td>';
            $html .= '<td>' . $value->reject_reason . '</td></tr>';

        }
        return $html;
    }

    public function getGuardianById($guardian_identity)
    {
        $guardian = Guardian::where('guardian_identity', '=', $guardian_identity)->first();

        $data = '';
        if (isset($guardian)) {
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
                'supporter_identity' => $guardian->supporter_identity,
                'supporter_relationship' => $guardian->supporter_relationship,
                'supporter_relationship_name' => $this->getLookup($guardian->supporter_relationship),
                'card_date_expired' => $guardian->card_date_expired,
                'guardianship_date_expired' => $guardian->guardianship_date_expired
            ];

            return $data;
        }
        return null;

    }

    public function getSchool($referance_key)
    {
        $records = SchoolEducation::where('referance_key', $referance_key)->first();
        if (isset($records)) {
            $data = [
                //Full texts	id	health_status	health_status_details	food_details	workout_details	referance_key
                'school_name' => $records->school_name,
                'study_level' => $this->getLookup($records->study_level),
                'study_class' => $this->getLookup($records->study_class),
                'currentlevel' => $this->getLookup($records->currentlevel),
                'current_avg' => $records->current_avg,
                'created_by' => $this->getUser($records->created_by)];

            return $data;
        }
        return '';

    }

    public function getHealthRecord($referance_key)
    {
        $records = HealthRecord::where('referance_key', '=', $referance_key)->first();
        if (isset($records)) {
            $data = [

                'health_status' => $this->getLookup($records->health_status),
                'health_status_details' => $records->health_status_details,
                'food_details' => $records->food_details,
                'workout_details' => $records->workout_details,
                'created_by' => $this->getUser($records->created_by)];
            return $data;
        }
        return '';

    }

    public function getReligion($referance_key)
    {
        $records = ReligionEducation::where('referance_key', $referance_key)->first();
        if (isset($records)) {
            $data = [
                //Full texts	id	health_status	health_status_details	food_details	workout_details	referance_key
                'praying' => $this->getLookup($records->praying),
                'memorizes_quran' => $records->memorizes_quran,
                'parts_no' => $records->parts_no,
                'sura_no' => $records->sura_no,
                'skills' => $records->skills,
                'created_by' => $this->getUser($records->created_by)];

            return $data;
        }
        return '';

    }

    public function getOrphan($referance_key)
    {
        $records = OrphanNeed::where('referance_key', $referance_key)->get();
        $html = '';
        $i = 0;
        foreach ($records as $value) {
            $html .= '<tr><td>' . ++$i . '</td>';
            $html .= '<td>' . $this->getLookup($value->what_needed) . '</td>';
            $html .= '<td>' . $value->needed_price . '</td>';
            $html .= '<td>' . $this->getLookup($value->currency) . '</td>';
            $html .= '<td>' . $value->needed_details . '</td></tr>';

        }
        return $html;

    }

    public function getObstruction($referance_key)
    {
        $records = Obstruction::where('referance_key', $referance_key)->first();
        if (!empty($records)) {
            $data = [
                'obstruction_type' => $records->obstruction_type,
                'obstruction_details' => $records->obstruction_details,
                'created_by' => $this->getUser($records->created_by)];

            return $data;
        }
        return null;

    }

    public function getUniversity($referance_key)
    {
        $records = UniversityEducation::where('referance_key', $referance_key)->first();
        if (!empty($records)) {
            $data = [
                'university_name' => $records->university_name,
                'university_level' => $this->getLookup($records->university_level),
                'university_major' => $records->university_major,
                'current_avg' => $records->current_avg,
                'current_level' => $this->getLookup($records->current_level),
                'created_by' => $this->getUser($records->created_by)];

            return $data;
        }
        return null;

    }

    public function change_report_status(Request $request)
    {
        // dd($request->all());
        $referance_key = $request->referance_key;
        $report_status = $request->report_status;//292
        $reject_reason = $request->reject_reason;
        $bef_referance_status = new BeneficiaryReferenceStatus();
        $bef_referance_status->referance_key = $referance_key;
        $bef_referance_status->status = $report_status;
        $bef_referance_status->reject_reason = $reject_reason;
        $bef_referance_status->created_by = auth()->user()->id;
        if (!$bef_referance_status->save())
            return response()->json(['success' => false]);

        $referance_list = ReferencesList::find($referance_key);
        $referance_list->report_status =  $report_status;
        $referance_list->report_status_updated_by = auth()->user()->id;
        if (!$referance_list->save())
            return response()->json(['success' => false]);

        if ($report_status == 292) {
            $benf = BeneficiariesProfile::where('id', $referance_list->beneficiary_index)->first();
            $user = User::find($referance_list->created_by);
            //$user = User::find(6);
            if (isset($benf)) {
                $body = 'تم رفض تقرير المستفيد ';
                $body .= $benf->full_name;
                $body .= ' رقم الكفالة ';
                $body .= $benf->sponser_id;
                $body .= ' بسبب ';
                $body .= $reject_reason;

                $title = 'رفض تقرير من المشرف الميداني ';
                $title .= auth()->user()->name;
                // dd($title);
                $this->sendSMS($user->mobile, $body);
                $notification = new SystemNotifications();
                $notification->not_title = $title;
                $notification->not_ar = $body;
                $notification->not_type = 1;
                $notification->referance_key = $referance_key;
                $notification->receiver_user_id = $referance_list->visit_by;//1;
                $notification->created_by = auth()->user()->id;
                $notification->not_date = date('Y-m-d H:i:s');
                if ($notification->save())
                    $this->sendFcm($notification, $benf->account_type, $benf->report_status, $user->fcm_token, 1);
            }
        }
        $report_status_table = $this->getReportStatustable($referance_key);

        return response()->json(['success' => true, 'html' => $report_status_table]);


    }

    public function getOrphanold($referance_key)
    {
        $records = OrphanNeed::where('referance_key', $referance_key)->get();
        if (count($records) > 0) {

            foreach ($records as $record) {
                $data[] = [
                    'what_needed' => $record->what_needed,
                    'needed_price' => $record->needed_price,
                    'currency' => $record->currency,
                    'needed_details' => $record->needed_details,
                    'created_by' => $this->getUser($record->created_by)
                ];
            }
            return $data;
        }
        return [];

    }

    public function printVisit($id)
    {

        $referance_key = $id;//$request->referance_key;

        $referance = ReferencesList::find($referance_key);

        if (isset($referance)) {
            $beneficiary_identity = $referance->beneficiary_identity;
            $one_profile = $this->getProfile($referance->beneficiary_index);
            $one_live = $this->getLiving($referance_key);
            $one_visit_report = $this->getVisitReport($referance_key);
            $one_image = $this->getBenImage($referance_key);//BeneficiaryImage::where('referance_key', $referance_key)->get();
            $one_family = $this->getFamily($referance_key);
            $one_story = $this->getStory($referance_key);
            $one_otherNeed = $this->getOtherNeed($referance_key);
            $one_StatisticalCard = $this->getStatisticalCard($referance_key);
            $one_report_status = $this->getLastReportStatustable($referance_key);
            $one_guardian = $this->getGuardianById($one_profile['guardian_identity']);
            //    dd($one_report_status);
            $one_school = '';
            $one_health = '';
            $one_religion = '';
            $one_orphan = '';
            $one_university = '';
            $one_obstruction = '';
            if ($one_profile['account_type'] == 1) {
                $one_school = $this->getSchool($referance_key);
                $one_health = $this->getHealthRecord($referance_key);
                $one_religion = $this->getReligion($referance_key);
                $one_orphan = $this->getOrphan($referance_key);

            } else if ($one_profile['account_type'] == 3) {

                $one_university = $this->getUniversity($referance_key);
                $one_obstruction = $this->getObstruction($referance_key);
                $one_health = $this->getHealthRecord($referance_key);
                $one_orphan = $this->getOrphan($referance_key);

            } else if ($one_profile['account_type'] == 2) {


            } else if ($one_profile['account_type'] == 4) {
                $one_university = $this->getUniversity($referance_key);


            }
            $rep_header = ReportHeader::whereIn('report_type', [2, 0])//2=متابعة,0=مشترك
            ->whereIn('account_type', [$one_profile['account_type'], 10])->pluck('id')->toArray();
            $data = [
                'one_profile' => $one_profile,
                'one_guardian' => $one_guardian,
                'one_live' => $one_live,
                'one_visit_report' => $one_visit_report,
                'one_image' => $one_image,
                'one_family' => $one_family,
                'one_health' => $one_health,
                'one_university' => $one_university,
                'one_obstruction' => $one_obstruction,
                'one_orphan' => $one_orphan,
                'one_school' => $one_school,
                'one_religion' => $one_religion,
                'one_story' => $one_story,
                'one_statisticard' => $one_StatisticalCard,
                'one_otherNeed' => $one_otherNeed,
                'one_report_status' => $one_report_status,
                'rep_header' => $rep_header,
                'rep_type' => 2,
                'rep_type_desc' => 'متابعة'
            ];

            $pdf = \niklasravnsborg\LaravelPdf\Facades\Pdf::loadView(report_vw() . '.pdf', $data);
            // If you want to store the generated pdf to the server then you can use the store function
//        $pdf->save(storage_path().'_filename.pdf');d
            // return $pdf->download('pdf.pdf');
            return $pdf->stream('document.pdf');
            // return $pdf->stream('document.pdf');
            //return $pdf;
            //  return view(report_vw() . '.pdf', $data);
        }
        return response()->json(['success' => false, 'visit' => []]);
    }

    public function getLastReportStatustable($referance_key)
    {
        $record = BeneficiaryReferenceStatus::where('referance_key', 1166)->orderBy('id', 'desc')->first();
        if (isset($record)) {
            $data = [
                'status' => $this->getLookup($record->status),
                'created_by' => $this->getUser($record->created_by),
                'created_at' => $record->created_at->format('Y-m-d'),
                'reject_reason' => $record->reject_reason,

            ];

            return $data;
        }
        return '';

    }

    public function getYearlyReport($id)
    {

        $referance_key = $id;//$request->referance_key;

        $referance = ReferencesList::find($referance_key);

        if (isset($referance)) {
            $beneficiary_identity = $referance->beneficiary_identity;
            $one_profile = $this->getProfile($referance->beneficiary_index);
            $one_live = $this->getLiving($referance_key);
            $one_visit_report = $this->getVisitReport($referance_key);
            $one_image = $this->getBenImage($referance_key);//BeneficiaryImage::where('referance_key', $referance_key)->get();
            $one_family = $this->getFamily($referance_key);
            $one_story = $this->getStory($referance_key);
            $one_otherNeed = $this->getOtherNeed($referance_key);
            $one_StatisticalCard = $this->getStatisticalCard($referance_key);
            $one_report_status = $this->getLastReportStatustable($referance_key);
            $one_guardian = $this->getGuardianById($one_profile['guardian_identity']);
            $one_school = '';
            $one_health = '';
            $one_religion = '';
            $one_orphan = '';
            $one_university = '';
            $one_obstruction = '';
            if ($one_profile['account_type'] == 1) {
                $one_school = $this->getSchool($referance_key);
                $one_health = $this->getHealthRecord($referance_key);
                $one_religion = $this->getReligion($referance_key);
                $one_orphan = $this->getOrphan($referance_key);

            } else if ($one_profile['account_type'] == 3) {

                $one_university = $this->getUniversity($referance_key);
                $one_obstruction = $this->getObstruction($referance_key);
                $one_health = $this->getHealthRecord($referance_key);


            } else if ($one_profile['account_type'] == 2) {


            } else if ($one_profile['account_type'] == 4) {
                $one_university = $this->getUniversity($referance_key);


            }
            $rep_header = ReportHeader::whereIn('report_type', [1, 0])//1=سنوي,0=مشترك
            ->whereIn('account_type', [$one_profile['account_type'], 10])->pluck('id')->toArray();
            //   dd($rep_header);
            $data = [
                'one_profile' => $one_profile,
                'one_guardian' => $one_guardian,
                'one_live' => $one_live,
                'one_visit_report' => $one_visit_report,
                'one_image' => $one_image,
                'one_family' => $one_family,
                'one_health' => $one_health,
                'one_university' => $one_university,
                'one_obstruction' => $one_obstruction,
                'one_orphan' => $one_orphan,
                'one_school' => $one_school,
                'one_religion' => $one_religion,
                'one_story' => $one_story,
                'one_otherNeed' => $one_otherNeed,
                'one_statisticard' => $one_StatisticalCard,
                'one_report_status' => $one_report_status,
                'rep_header' => $rep_header,
                'rep_type' => 1,
                'rep_type_desc' => 'سنوي'

            ];

            $pdf = \niklasravnsborg\LaravelPdf\Facades\Pdf::loadView(report_vw() . '.pdf', $data);
            // If you want to store the generated pdf to the server then you can use the store function
//        $pdf->save(storage_path().'_filename.pdf');d
            // return $pdf->download('pdf.pdf');
            return $pdf->stream('document.pdf');
            // return $pdf->stream('document.pdf');
            //return $pdf;
            //  return view(report_vw() . '.pdf', $data);
        }
        return response()->json(['success' => false, 'visit' => []]);
    }

    public function printVisit_1(Request $request)
    {
        dd($request->all());
        $referance_key = $id;//$request->referance_key;

        $referance = ReferencesList::find($referance_key);

        if (isset($referance)) {
            $beneficiary_identity = $referance->beneficiary_identity;
            $one_profile = $this->getProfile($beneficiary_identity);
            $one_live = $this->getLiving($referance_key);
            $one_visit_report = $this->getVisitReport($referance_key);
            $one_image = $this->getBenImage($referance_key);//BeneficiaryImage::where('referance_key', $referance_key)->get();
            $one_family = $this->getFamily($referance_key);
            $one_school = '';
            $one_health = '';
            $one_religion = '';
            $one_orphan = '';
            $one_university = '';
            $one_obstruction = '';
            if ($one_profile['account_type'] == 1) {
                $one_school = $this->getSchool($referance_key);
                $one_health = $this->getHealthRecord($referance_key);
                $one_religion = $this->getReligion($referance_key);
                $one_orphan = $this->getOrphan($referance_key);

            } else if ($one_profile['account_type'] == 2) {

                $one_university = $this->getUniversity($referance_key);
                $one_obstruction = $this->getObstruction($referance_key);
                $one_health = $this->getHealthRecord($referance_key);


            } else if ($one_profile['account_type'] == 3) {


            } else if ($one_profile['account_type'] == 4) {
                $one_university = $this->getUniversity($referance_key);


            }
            $data = [
                'one_profile' => $one_profile,
                'one_live' => $one_live,
                'one_visit_report' => $one_visit_report,
                'one_image' => $one_image,
                'one_family' => $one_family,
                'one_health' => $one_health,
                'one_university' => $one_university,
                'one_obstruction' => $one_obstruction,
                'one_orphan' => $one_orphan,
                'one_school' => $one_school,
                'one_religion' => $one_religion,
            ];

            $pdf = \niklasravnsborg\LaravelPdf\Facades\Pdf::loadView(report_vw() . '.pdf', $data);
            // If you want to store the generated pdf to the server then you can use the store function
//        $pdf->save(storage_path().'_filename.pdf');d
            // return $pdf->download('pdf.pdf');
            return $pdf->stream('document.pdf');
            // return $pdf->stream('document.pdf');
            //return $pdf;
            //  return view(report_vw() . '.pdf', $data);
        }
        return response()->json(['success' => false, 'visit' => []]);
    }

    public
    function getReferance($referance_key)
    {
        $records = ReferencesList::where('id', '=', $referance_key)->first();
        $profile = BeneficiariesProfile::where('beneficiary_identity', '=', $records->beneficiary_identity)->first();
        if (isset($records)) {
            $data = [
                'id' => $records->id,
                'beneficiary_identity' => $records->beneficiary_identity,
                'visit_date' => $records->visit_date,
                'visit_by' => $records->visit_by,
                'add_date' => $records->add_date,
                'visit_type' => $records->visit_type,
                'created_by' => $this->getUser($records->created_by),
                'deleted_at' => ($records->deleted_at != null) ? $records->deleted_at->toDateTimeString() : null,
                'created_at' => $records->created_at->toDateTimeString(),
                'updated_at' => ($records->updated_at != null) ? $records->updated_at->toDateTimeString() : null,
                'visit_name' => $records->visit_name,
                'account_type' => $profile->account_type,
                'account_type' => $profile->account_type,
            ];
            return $data;
        }
        return null;

    }

//*********************************************************//

    public
    function run_rep_old(Request $request)
    {

        // dd('ffff');
        //    dd($request->all());
        $rep = $request->report_id;
        $from = $request->fromdate;
        $to = $request->todate;
        $visit_by = $request->visit_by;
        $this->data['fromdate'] = $from;
        $this->data['todate'] = $to;
        $this->data['visit_by'] = $visit_by;
        $this->data['model'] = '';
        if ($rep == 1) {
            $result = BeneficiariesProfile::whereBetween('created_at', [$from, $to])
                ->selectRaw('account_type, count(*) AS total')
                ->groupBy('account_type')
                ->get();

            //$data[]=[];
            foreach ($result as $row) {
                $data[] = [
                    'account_type' => $this->getAccountType($row->account_type),
                    'total' => $row->total,
                ];
            }
            $html = ''; //  dd($data);
            $i = 0;
            $total = 0;
            if (isset($data))
                foreach ($data as $row) {
                    $total = $total + $row['total'];
                    $html .= '<tr><td>' . ++$i . '</td>';
                    $html .= '<td>' . $row['account_type'] . '</td>';
                    $html .= '<td>' . $row['total'] . '</td></tr>';


                }
            $html .= '<tr><th colspan="2" align="center">المـجمــــــــوع</th><td>' . $total . '</td></tr>';
            $this->data['model'] = $html;

            // return view(report_vw() . '.rep1', $this->data);
            //dd($this->data);
            $pdf = \niklasravnsborg\LaravelPdf\Facades\Pdf::loadView(report_vw() . '.rep1', $this->data);
            return $pdf->stream('document.pdf');

        } else if ($rep == 2) {

            $result = DB::table('beneficiaries_profile')
                ->join('references_list', 'references_list.id', '=', 'beneficiaries_profile.last_referance_key');
            if (isset($from))
                $result = $result->whereDate('visit_date', '>=', $from);
            if (isset($to))
                $result = $result->whereDate('visit_date', '<=', $to);
            //            $result = BeneficiariesProfile::whereBetween('created_at', [$from, $to])
            if (isset($visit_by) && $visit_by != 0)
                $result = $result->where('visit_by', '=', $visit_by);

            $result = $result->selectRaw('account_type,visit_by,count(*) AS total')
                ->groupBy('account_type', 'visit_by')
                ->orderBy('visit_by')
                ->orderBy('account_type')
                ->get();

            //  dd($result);
            foreach ($result as $row) {
                $data[] = [
                    'account_type' => $row->account_type,
                    'visit_by' => $row->visit_by,
                    'visit_by_desc' => $this->getUser($row->visit_by),
                    'total' => $row->total,
                ];
            }

            //dd($data);
            $html = "";
            $curent_visit_by = '';
            $total_all = 0;
            $total_Orphan = 0;
            $total_Diablity = 0;
            $total_Family = 0;
            $total_Student = 0;
            $cur_index = 0;
            if (isset($data))
                for ($i = 0; $i < count($data); $i++) {//foreach ($data as $rowsd) {
                    //  dd($rowsd['account_type']);
                    //dd($data[4]['visit_by']);
                    if ($curent_visit_by != $data[$i]['visit_by']) {

                        $curent_visit_by = $data[$i]['visit_by'];

                        $total = 0;

                        $cur_index = $i;
                        $html = $html . '<tr><th width="10%">' . $data[$cur_index]['visit_by_desc'] . '</th>';
                        if (isset($data[$cur_index]) && $data[$cur_index]['account_type'] == 1 && $curent_visit_by == $data[$cur_index]['visit_by']) {
                            $html = $html . '<td width="10%">' . $data[$cur_index]['total'] . '</td>';
                            $total = $total + $data[$cur_index]['total'];
                            $total_Orphan = $total_Orphan + $data[$cur_index]['total'];
                            $cur_index++;
                        } else {
                            $html = $html . '<td width="10%">0</td>';
                        }
                        if (isset($data[$cur_index]) && $data[$cur_index]['account_type'] == 2 && $curent_visit_by == $data[$cur_index]['visit_by']) {
                            $html = $html . '<td width="10%">' . $data[$cur_index]['total'] . '</td>';
                            $total = $total + $data[$cur_index]['total'];
                            $total_Diablity = $total_Diablity + $data[$cur_index]['total'];
                            $cur_index++;
                        } else {
                            $html = $html . '<td width="10%">0</td>';
                        }
                        if (isset($data[$cur_index]) && $data[$cur_index]['account_type'] == 3 && $curent_visit_by == $data[$cur_index]['visit_by']) {
                            $html = $html . '<td width="10%">' . $data[$cur_index]['total'] . '</td>';
                            $total = $total + $data[$cur_index]['total'];
                            $total_Family = $total_Family + $data[$cur_index]['total'];

                            $cur_index++;
                        } else {
                            $html = $html . '<td width="10%">0</td>';

                        }
                        if (isset($data[$cur_index]) && $data[$cur_index]['account_type'] == 4 && $curent_visit_by == $data[$cur_index]['visit_by']) {
                            $html = $html . '<td width="10%">' . $data[$cur_index]['total'] . '</td>';
                            $total = $total + $data[$cur_index]['total'];
                            $total_Student = $total_Student + $data[$cur_index]['total'];

                            $cur_index++;
                        } else {
                            $html = $html . '<td width="10%">0</td>';
                        }
                        $i = $cur_index - 1;

                        $html = $html . '<td width="10%">' . $total . '</td></tr>';
                        $total_all = $total_all + $total;


                    }
                }
            $html = $html . '<tr><th>المجمــــــوع</th><td>' . $total_Orphan . '</td><td>' . $total_Diablity . '</td><td>' . $total_Family . '</td><td>' . $total_Student . '</td><td>' . $total_all . '</td></tr>';

            //   dd($html);
            /*   $html .= '<tr class="odd gradeX"><th width="10%"></th>' . $col1 . '</tr>';
               $html .= '<tr  onclick=prusser_chart();><td width="10%"><a>Pressure</a></td>' . $col2 . '</tr>';
               $html .= '<tr  onclick=hpr_chart();><td width="10%"><a>Pulse</a></td>' . $col3 . '</tr>';
               $html .= '<tr  onclick=hpr_chart();><td width="10%"><a>Heat</a></td>' . $col4 . '</tr>';
               $html .= '<tr  onclick=hpr_chart();><td width="10%"><a>Respiratory rate</a></td>' . $col5 . '</tr>';
               echo $html;*/

            $this->data['model'] = $html;
            $pdf = \niklasravnsborg\LaravelPdf\Facades\Pdf::loadView(report_vw() . '.rep2', $this->data);
            return $pdf->stream('document.pdf');
        } else if ($rep == 3) {

            $result = AttendanceSheet::query();
            if (isset($visit_by) && $visit_by != 0) {
                $result = $result->where('user_id', $visit_by);
            }
            if (isset($from) && $from != '') {
                $result = $result->whereDate('attendance_date', '>=', $from);
            }
            if (isset($to) && $to != '') {
                $result = $result->whereDate('attendance_date', '<=', $to);
            }
            $result = $result->orderBy('user_id')->orderBy('attendance_date')->get();
            //  dd($result);
            foreach ($result as $row) {
                $data[] = [
                    'name' => $this->getUser($row->user_id),
                    'user_id' => $row->user_id,
                    'attendance_date' => $row->attendance_date,
                    'attend_time' => $row->attend_time,
                    'leave_time' => $row->leave_time,
                ];
            }
            $html = '';
            $hr = 0;
            $i = 0;
            //   dd($data);
            if (isset($data))
                foreach ($data as $row) {
                    $hr = 0;
                    if (isset($row['leave_time']) && isset($row['attend_time']))
                        $hr = (new  Carbon($row['leave_time']))->diff(new Carbon($row['attend_time']))->format('%h:%I');
                    else
                        $hr = 0;
                    $html .= '<tr><td>' . ++$i . '</td>';
                    $html .= '<td>' . $row['user_id'] . '</td>';
                    $html .= '<td>' . $row['name'] . '</td>';
                    $html .= '<td>' . $row['attendance_date'] . '</td>';
                    $html .= '<td>' . $row['attend_time'] . '</td>';
                    $html .= '<td>' . $row['leave_time'] . '</td>';
                    $html .= '<td>' . $hr . '</td></tr>';

                }
            //  dd($html);
            $this->data['model'] = $html;
            $pdf = \niklasravnsborg\LaravelPdf\Facades\Pdf::loadView(report_vw() . '.rep3', $this->data);
            return $pdf->stream('document.pdf');
        }
        //dd($benf);


        //   $pdf = \niklasravnsborg\LaravelPdf\Facades\Pdf::loadView(report_vw() . '.pdf', $data);
        // If you want to store the generated pdf to the server then you can use the store function
//        $pdf->save(storage_path().'_filename.pdf');d
        // return $pdf->download('pdf.pdf');

        // return $pdf->stream('document.pdf');
        //return $pdf;
        //    return view(report_vw() . '.rep1');
        //  return $pdf->stream('document.pdf');
        //   return response()->json(['success' => false, 'visit' => []]);
    }

    public
    function run_rep(Request $request)
    {

        // dd('ffff');
        //    dd($request->all());
        if ($request->report_id != '') {

            $rep = $request->report_id;
            $from = $request->fromdate;
            $to = $request->todate;
            $visit_by = $request->visit_by;
            $this->data['fromdate'] = $from;
            $this->data['todate'] = $to;
            $this->data['visit_by'] = $visit_by;
            $this->data['model'] = '';
            if ($rep == 1) {
                $result = BeneficiariesProfile::whereBetween('created_at', [$from, $to])
                    ->selectRaw('account_type, count(*) AS total')
                    ->groupBy('account_type')
                    ->get();

                //$data[]=[];
                foreach ($result as $row) {
                    $data[] = [
                        'account_type' => $this->getAccountType($row->account_type),
                        'total' => $row->total,
                    ];
                }
                $html = ''; //  dd($data);
                $i = 0;
                $total = 0;
                if (isset($data))
                    foreach ($data as $row) {
                        $total = $total + $row['total'];
                        $html .= '<tr><td>' . ++$i . '</td>';
                        $html .= '<td>' . $row['account_type'] . '</td>';
                        $html .= '<td>' . $row['total'] . '</td></tr>';


                    }
                $html .= '<tr><th colspan="2" align="center">المـجمــــــــوع</th><td>' . $total . '</td></tr>';
                $this->data['model'] = $html;

                // return view(report_vw() . '.rep1', $this->data);
                //dd($this->data);
                $pdf = \niklasravnsborg\LaravelPdf\Facades\Pdf::loadView(report_vw() . '.rep1', $this->data);
                return $pdf->stream('document.pdf');

            } else if ($rep == 2) {

                $result = DB::table('beneficiaries_profile')
                    ->join('references_list', 'references_list.id', '=', 'beneficiaries_profile.last_referance_key');
                if (isset($from))
                    $result = $result->whereDate('visit_date', '>=', $from);
                if (isset($to))
                    $result = $result->whereDate('visit_date', '<=', $to);
                //            $result = BeneficiariesProfile::whereBetween('created_at', [$from, $to])
                if (isset($visit_by) && $visit_by != 0)
                    $result = $result->where('visit_by', '=', $visit_by);

                $result = $result->selectRaw('account_type,visit_by,count(*) AS total')
                    ->groupBy('account_type', 'visit_by')
                    ->orderBy('visit_by')
                    ->orderBy('account_type')
                    ->get();

                //  dd($result);
                foreach ($result as $row) {
                    $data[] = [
                        'account_type' => $row->account_type,
                        'visit_by' => $row->visit_by,
                        'visit_by_desc' => $this->getUser($row->visit_by),
                        'total' => $row->total,
                    ];
                }

                //dd($data);
                $html = "";
                $curent_visit_by = '';
                $total_all = 0;
                $total_Orphan = 0;
                $total_Diablity = 0;
                $total_Family = 0;
                $total_Student = 0;
                $cur_index = 0;
                if (isset($data))
                    for ($i = 0; $i < count($data); $i++) {//foreach ($data as $rowsd) {
                        //  dd($rowsd['account_type']);
                        //dd($data[4]['visit_by']);
                        if ($curent_visit_by != $data[$i]['visit_by']) {

                            $curent_visit_by = $data[$i]['visit_by'];

                            $total = 0;

                            $cur_index = $i;
                            $html = $html . '<tr><th width="10%">' . $data[$cur_index]['visit_by_desc'] . '</th>';
                            if (isset($data[$cur_index]) && $data[$cur_index]['account_type'] == 1 && $curent_visit_by == $data[$cur_index]['visit_by']) {
                                $html = $html . '<td width="10%">' . $data[$cur_index]['total'] . '</td>';
                                $total = $total + $data[$cur_index]['total'];
                                $total_Orphan = $total_Orphan + $data[$cur_index]['total'];
                                $cur_index++;
                            } else {
                                $html = $html . '<td width="10%">0</td>';
                            }
                            if (isset($data[$cur_index]) && $data[$cur_index]['account_type'] == 2 && $curent_visit_by == $data[$cur_index]['visit_by']) {
                                $html = $html . '<td width="10%">' . $data[$cur_index]['total'] . '</td>';
                                $total = $total + $data[$cur_index]['total'];
                                $total_Diablity = $total_Diablity + $data[$cur_index]['total'];
                                $cur_index++;
                            } else {
                                $html = $html . '<td width="10%">0</td>';
                            }
                            if (isset($data[$cur_index]) && $data[$cur_index]['account_type'] == 3 && $curent_visit_by == $data[$cur_index]['visit_by']) {
                                $html = $html . '<td width="10%">' . $data[$cur_index]['total'] . '</td>';
                                $total = $total + $data[$cur_index]['total'];
                                $total_Family = $total_Family + $data[$cur_index]['total'];

                                $cur_index++;
                            } else {
                                $html = $html . '<td width="10%">0</td>';

                            }
                            if (isset($data[$cur_index]) && $data[$cur_index]['account_type'] == 4 && $curent_visit_by == $data[$cur_index]['visit_by']) {
                                $html = $html . '<td width="10%">' . $data[$cur_index]['total'] . '</td>';
                                $total = $total + $data[$cur_index]['total'];
                                $total_Student = $total_Student + $data[$cur_index]['total'];

                                $cur_index++;
                            } else {
                                $html = $html . '<td width="10%">0</td>';
                            }
                            $i = $cur_index - 1;

                            $html = $html . '<td width="10%">' . $total . '</td></tr>';
                            $total_all = $total_all + $total;


                        }
                    }
                $html = $html . '<tr><th>المجمــــــوع</th><td>' . $total_Orphan . '</td><td>' . $total_Diablity . '</td><td>' . $total_Family . '</td><td>' . $total_Student . '</td><td>' . $total_all . '</td></tr>';

                //   dd($html);
                /*   $html .= '<tr class="odd gradeX"><th width="10%"></th>' . $col1 . '</tr>';
                   $html .= '<tr  onclick=prusser_chart();><td width="10%"><a>Pressure</a></td>' . $col2 . '</tr>';
                   $html .= '<tr  onclick=hpr_chart();><td width="10%"><a>Pulse</a></td>' . $col3 . '</tr>';
                   $html .= '<tr  onclick=hpr_chart();><td width="10%"><a>Heat</a></td>' . $col4 . '</tr>';
                   $html .= '<tr  onclick=hpr_chart();><td width="10%"><a>Respiratory rate</a></td>' . $col5 . '</tr>';
                   echo $html;*/

                $this->data['model'] = $html;
                $pdf = \niklasravnsborg\LaravelPdf\Facades\Pdf::loadView(report_vw() . '.rep2', $this->data);
                return $pdf->stream('document.pdf');
            } else if ($rep == 3) {

                $result = AttendanceSheet::query();
                if (isset($visit_by) && $visit_by != 0) {
                    $result = $result->where('user_id', $visit_by);
                }
                if (isset($from) && $from != '') {
                    $result = $result->whereDate('attendance_date', '>=', $from);
                }
                if (isset($to) && $to != '') {
                    $result = $result->whereDate('attendance_date', '<=', $to);
                }
                $result = $result->orderBy('user_id')->orderBy('attendance_date')->get();
                //  dd($result);
                foreach ($result as $row) {
                    $data[] = [
                        'name' => $this->getUser($row->user_id),
                        'user_id' => $row->user_id,
                        'attendance_date' => $row->attendance_date,
                        'attend_time' => $row->attend_time,
                        'leave_time' => $row->leave_time,
                    ];
                }
                $html = '';
                $hr = 0;
                $i = 0;
                //   dd($data);
                if (isset($data))
                    foreach ($data as $row) {
                        $hr = 0;
                        if (isset($row['leave_time']) && isset($row['attend_time']))
                            $hr = (new  Carbon($row['leave_time']))->diff(new Carbon($row['attend_time']))->format('%h:%I');
                        else
                            $hr = 0;
                        $html .= '<tr><td>' . ++$i . '</td>';
                        $html .= '<td>' . $row['user_id'] . '</td>';
                        $html .= '<td>' . $row['name'] . '</td>';
                        $html .= '<td>' . $row['attendance_date'] . '</td>';
                        $html .= '<td>' . $row['attend_time'] . '</td>';
                        $html .= '<td>' . $row['leave_time'] . '</td>';
                        $html .= '<td>' . $hr . '</td></tr>';

                    }
                //  dd($html);
                $this->data['model'] = $html;
                $pdf = \niklasravnsborg\LaravelPdf\Facades\Pdf::loadView(report_vw() . '.rep3', $this->data);
                return $pdf->stream('document.pdf');
            }
            //dd($benf);


            //   $pdf = \niklasravnsborg\LaravelPdf\Facades\Pdf::loadView(report_vw() . '.pdf', $data);
            // If you want to store the generated pdf to the server then you can use the store function
//        $pdf->save(storage_path().'_filename.pdf');d
            // return $pdf->download('pdf.pdf');

            // return $pdf->stream('document.pdf');
            //return $pdf;
            //    return view(report_vw() . '.rep1');
            //  return $pdf->stream('document.pdf');
            //   return response()->json(['success' => false, 'visit' => []]);
        } else
            return Redirect::back()->withErrors(['يرجى اختيار نوع التقرير']);

    }

    function run_rep_view(Request $request)
    {


        if ($request->report_id != '') {

            $rep = $request->report_id;
            $from = $request->fromdate;
            $to = $request->todate;
            $visit_by = $request->visit_by;
            $this->data['fromdate'] = $from;
            $this->data['todate'] = $to;
            $this->data['visit_by'] = $visit_by;
            $this->data['model'] = '';
            $html = '';
            if ($rep == 1) {
                $result = BeneficiariesProfile::whereBetween('created_at', [$from, $to])
                    ->selectRaw('account_type, count(*) AS total')
                    ->groupBy('account_type')
                    ->get();

                $data = array();
                foreach ($result as $row) {
                    $data[] = [
                        'account_type' => $this->getAccountType($row->account_type),
                        'total' => $row->total,
                    ];
                }
                $html = '<table class="table " width="100%" id="report_tbl" cellpadding="10"><thead><tr>
            <th width="10%">#</th>
            <th width="40%">النوع</th>
            <th width="50%">المجموع</th></tr></thead>';

                $i = 0;
                $total = 0;
                if (isset($data)) {
                    //dd($data);
                    $html .= ' <tbody>';
                    foreach ($data as $row) {

                        $total = $total + $row['total'];
                        $html .= ' <tr><td>' . ++$i . '</td>';
                        $html .= '<td>' . $row['account_type'] . '</td>';
                        $html .= '<td>' . $row['total'] . '</td></tr>';


                    }

                    $html .= '<tr><th colspan="2" align="center">المـجمــــــــوع</th><td>' . $total . '</td></tr>  </tbody> </table>';
                }


            } else if ($rep == 2) {

                $result = DB::table('beneficiaries_profile')
                    ->join('references_list', 'references_list.id', '=', 'beneficiaries_profile.last_referance_key');
                if (isset($from))
                    $result = $result->whereDate('visit_date', '>=', $from);
                if (isset($to))
                    $result = $result->whereDate('visit_date', '<=', $to);
                //            $result = BeneficiariesProfile::whereBetween('created_at', [$from, $to])
                if (isset($visit_by) && $visit_by != 0)
                    $result = $result->where('visit_by', '=', $visit_by);

                $result = $result->selectRaw('account_type,visit_by,count(*) AS total')
                    ->groupBy('account_type', 'visit_by')
                    ->orderBy('visit_by')
                    ->orderBy('account_type')
                    ->get();
                $html = '<table class="table " width="100%" id="report_tbl" cellpadding="10"><thead><tr>
             <th width="30%">اسم الباحث</th>
                <th width="15%">تقارير اليتيم</th>
                <th width="15%">تقارير الأسرة</th>
                <th width="15%">تقارير المعاق</th>
                <th width="15%">تقارير الطالب</th>
            <th width="10%">المجموع</th>
            </tr></thead>';
                //  dd($result);
                foreach ($result as $row) {
                    $data[] = [
                        'account_type' => $row->account_type,
                        'visit_by' => $row->visit_by,
                        'visit_by_desc' => $this->getUser($row->visit_by),
                        'total' => $row->total,
                    ];
                }

                //dd($data);

                $curent_visit_by = '';
                $total_all = 0;
                $total_Orphan = 0;
                $total_Diablity = 0;
                $total_Family = 0;
                $total_Student = 0;
                $cur_index = 0;
                if (isset($data)) {
                    $html .= ' <tbody>';
                    for ($i = 0; $i < count($data); $i++) {//foreach ($data as $rowsd) {
                        //  dd($rowsd['account_type']);
                        //dd($data[4]['visit_by']);
                        if ($curent_visit_by != $data[$i]['visit_by']) {

                            $curent_visit_by = $data[$i]['visit_by'];

                            $total = 0;

                            $cur_index = $i;
                            $html = $html . '<tr><th width="10%">' . $data[$cur_index]['visit_by_desc'] . '</th>';
                            if (isset($data[$cur_index]) && $data[$cur_index]['account_type'] == 1 && $curent_visit_by == $data[$cur_index]['visit_by']) {
                                $html = $html . '<td width="10%">' . $data[$cur_index]['total'] . '</td>';
                                $total = $total + $data[$cur_index]['total'];
                                $total_Orphan = $total_Orphan + $data[$cur_index]['total'];
                                $cur_index++;
                            } else {
                                $html = $html . '<td width="10%">0</td>';
                            }
                            if (isset($data[$cur_index]) && $data[$cur_index]['account_type'] == 2 && $curent_visit_by == $data[$cur_index]['visit_by']) {
                                $html = $html . '<td width="10%">' . $data[$cur_index]['total'] . '</td>';
                                $total = $total + $data[$cur_index]['total'];
                                $total_Diablity = $total_Diablity + $data[$cur_index]['total'];
                                $cur_index++;
                            } else {
                                $html = $html . '<td width="10%">0</td>';
                            }
                            if (isset($data[$cur_index]) && $data[$cur_index]['account_type'] == 3 && $curent_visit_by == $data[$cur_index]['visit_by']) {
                                $html = $html . '<td width="10%">' . $data[$cur_index]['total'] . '</td>';
                                $total = $total + $data[$cur_index]['total'];
                                $total_Family = $total_Family + $data[$cur_index]['total'];

                                $cur_index++;
                            } else {
                                $html = $html . '<td width="10%">0</td>';

                            }
                            if (isset($data[$cur_index]) && $data[$cur_index]['account_type'] == 4 && $curent_visit_by == $data[$cur_index]['visit_by']) {
                                $html = $html . '<td width="10%">' . $data[$cur_index]['total'] . '</td>';
                                $total = $total + $data[$cur_index]['total'];
                                $total_Student = $total_Student + $data[$cur_index]['total'];

                                $cur_index++;
                            } else {
                                $html = $html . '<td width="10%">0</td>';
                            }
                            $i = $cur_index - 1;

                            $html = $html . '<td width="10%">' . $total . '</td></tr>';
                            $total_all = $total_all + $total;


                        }
                    }
                }
                $html = $html . '<tr><th>المجمــــــوع</th><td>' . $total_Orphan . '</td><td>' . $total_Diablity . '</td><td>' . $total_Family . '</td><td>' . $total_Student . '</td><td>' . $total_all . '</td></tr></tbody> </table>';

            } else if ($rep == 3) {

                $result = AttendanceSheet::query();
                if (isset($visit_by) && $visit_by != 0) {
                    $result = $result->where('user_id', $visit_by);
                }
                if (isset($from) && $from != '') {
                    $result = $result->whereDate('attendance_date', '>=', $from);
                }
                if (isset($to) && $to != '') {
                    $result = $result->whereDate('attendance_date', '<=', $to);
                }
                $result = $result->orderBy('user_id')->orderBy('attendance_date')->get();
                //  dd($result);
                foreach ($result as $row) {
                    $data[] = [
                        'name' => $this->getUser($row->user_id),
                        'user_id' => $row->user_id,
                        'attendance_date' => $row->attendance_date,
                        'attend_time' => Carbon::parse($row->attend_time)->format('H:i'),
                        'leave_time' =>  Carbon::parse($row->leave_time)->format('H:i')
                    ];
                }

                $hr = 0;
                $i = 0;
                $html = '<table class="table " width="100%" id="report_tbl" cellpadding="10">
        <thead>
        <tr>
            <th> #</th>
            <th>كود الموظف </th>
            <th> الاسم</th>
            <th>تاريخ الحركة</th>
            <th> ساعة الحضور</th>
            <th> ساعة الانصراف</th>
            <th> مجموع </th>
        </tr>
        </thead>';
                if (isset($data)) {
                    $html .= ' <tbody>';
                    foreach ($data as $row) {
                        $hr = 0;
                        if (isset($row['leave_time']) && isset($row['attend_time']))
                            $hr = (new  Carbon($row['leave_time']))->diff(new Carbon($row['attend_time']))->format('%h:%I');
                        else
                            $hr = 0;
                        $html .= '<tr><td>' . ++$i . '</td>';
                        $html .= '<td>' . $row['user_id'] . '</td>';
                        $html .= '<td>' . $row['name'] . '</td>';
                        $html .= '<td>' . $row['attendance_date'] . '</td>';
                        $html .= '<td>' . $row['attend_time'] . '</td>';
                        $html .= '<td>' . $row['leave_time'] . '</td>';
                        $html .= '<td>' . $hr . '</td></tr>';

                    }
                    $html .= ' </tbody></table>';
                }

            }
            return response()->json(['success' => true, 'html' => $html]);
        } else
            return Redirect::back()->withErrors(['يرجى اختيار نوع التقرير']);

    }

    function get_rep_prop(Request $request)
    {
        $rep_type = $request->rep_type;
        $html = '';
        $url_btn = '';
        if (isset($request->id)) {
            $beneficiary_identity = $request->id;

            $beneficiary = BeneficiariesProfile::where('beneficiary_identity', $beneficiary_identity)->first();
            if ($beneficiary) {
                if ($beneficiary->account_type == 1) {
                    if ($rep_type == 1) {
                        $html = '<option value="0">العمر</option>';
                        $html .= '<option value="1">الجنس</option>';
                        $html .= '<option value="2">الوصي</option>';
                        $html .= '<option value="3">رقم الهوية</option>';
                        $html .= '<option value="4">المحافظة</option>';
                        $html .= '<option value="5">المدينة،المخيم/القرية</option>';
                        $html .= '<option value="6">العنوان بالتفصيل</option>';
                        $html .= '<option value="7">مكان إقامة اليتيم </option>';
                        $html .= '<option value="8">رقم الجوال </option>';
                        $html .= '<option value="9">رقم اخر </option>';
                        $html .= '<option value="10">اقرب مركز تحفيظ </option>';
                        $html .= '<option value="11">اقرب جمعية خيرية </option>';
                        $html .= '<option value="12">اسم المدرسة </option>';
                        $html .= '<option value="13">المرحلة الدراسية</option>';
                        $html .= '<option value="14">الصف</option>';
                        $html .= '<option value="15">نتيجة العام %</option>';
                        $html .= '<option value="16">المستوى</option>';
                        $html .= '<option value="17">المداومة على الصلاة</option>';
                        $html .= '<option value="18">حفظ القران الكريم</option>';
                        $html .= '<option value="19">عدد الأجزاء</option>';
                        $html .= '<option value="20">عدد السور</option>';
                        $html .= '<option value="21">مهارات ومواهب</option>';
                        $html .= '<option value="22">الحالة الصحية</option>';
                        $html .= '<option value="23">وصف الحالة الصحية</option>';
                        $html .= '<option value="24">التغذية</option>';
                        $html .= '<option value="25">الأنشطة والخدمات المقدمة لليتيم</option>';
                        $html .= '<option value="26">نوع الاحتياج</option>';
                        $html .= '<option value="27">نوع المشروع</option>';
                        $html .= '<option value="28">مقومات نجاح المشروع </option>';
                        $html .= '<option value="29">مقومات نجاح المشروع </option>';
                        $html .= '<option value="30">وصف المسكن</option>';
                        $html .= '<option value="31">مساحة المسكن</option>';
                        $html .= '<option value="32">ملكية المسكن</option>';
                        $html .= '<option value="33">الإحتياج المطلوب</option>';
                    } else if ($rep_type == 2) {

                        $html .= '<option value="5">المدينة،المخيم/القرية</option>';
                        $html .= '<option value="7">مكان إقامة اليتيم </option>';
                        $html .= '<option value="22">الحالة الصحية</option>';
                        $html .= '<option value="34">تطورات صحية</option>';
                        $html .= '<option value="35">تطورات تعليمية</option>';
                        $html .= '<option value="36">تطورات اقتصادية</option>';
                        $html .= '<option value="37">تطورات اجتماعية</option>';
                        $html .= '<option value="38">اهداف الزيارة</option>';
                        $html .= '<option value="39">توصيات الباحث </option>';
                    }

                } else if ($beneficiary->account_type == 2) {
                    if ($rep_type == 1) {
                        $html = '<option value="0">العمر</option>';
                    } else if ($rep_type == 2) {
                        $html = '<option value="0">تاريخ الطلب</option>';
                    }

                } else if ($beneficiary->account_type == 3) {
                    if ($rep_type == 1) {
                        $html = '<option value="0">تاريخ الطلب</option>';
                    } else if ($rep_type == 2) {
                        $html = '<option value="0">تاريخ الطلب</option>';
                    }


                } else if ($beneficiary->account_type == 4) {
                    if ($rep_type == 1) {
                        $html = '<option value="0">تاريخ الطلب</option>';
                    } else if ($rep_type == 2) {
                        $html = '<option value="0">تاريخ الطلب</option>';
                    }


                }
                $url_btn = url('print/') . '/' . $beneficiary->id;
            }
            return response()->json(['success' => true, 'html' => $html, 'btn_url' => $url_btn]);
        }
        return response()->json(['success' => true, 'html' => $html, 'btn_url' => $url_btn]);

    }

    function del_one_bef(Request $request)
    {
        $bef_id = $request->id;

        $beneficiary = BeneficiariesProfile::where('id', '=', $bef_id)->first();
        if ($beneficiary) {
            $beneficiary_index = $beneficiary->id;

            $referances = ReferencesList::where('beneficiary_index', '=', $beneficiary_index)->pluck('id')->toArray();

            if ($referances) {
                $del_beneficiary_images = BeneficiaryImage::whereIn('referance_key', $referances)->delete();

                $del_family_project = FamilyProject::whereIn('referance_key', $referances)->delete();
                $del_health_records = HealthRecord::whereIn('referance_key', $referances)->delete();
                $del_living_details = LivingDetail::whereIn('referance_key', $referances)->delete();
                $del_obstructions = Obstruction::whereIn('referance_key', $referances)->delete();
                $del_orphan_needs = OrphanNeed::whereIn('referance_key', $referances)->delete();
                $del_religion_education = ReligionEducation::whereIn('referance_key', $referances)->delete();
                $del_school_education = SchoolEducation::whereIn('referance_key', $referances)->delete();
                $del_university_educations = UniversityEducation::whereIn('referance_key', $referances)->delete();
                $del_visitor_report = VisitReport::whereIn('referance_key', $referances)->delete();
            }
            $beneficiary->delete();
            $del_referances = ReferencesList::where('beneficiary_index', '=', $beneficiary_index)->delete();
        }
    }

    function del_chk_bef(Request $request)
    {
        //dd($request->all());

        $bef_ids = $request->idArray;

        $beneficiarys = BeneficiariesProfile::whereIn('id', $bef_ids)->get();
        // dd($beneficiarys);
        if ($beneficiarys) {
            foreach ($beneficiarys as $beneficiary) {
                $beneficiary_index = $beneficiary->id;//table id

                $referances = ReferencesList::where('beneficiary_index', '=', $beneficiary_index)->pluck('id')->toArray();
                // dd($referances);
                if ($referances) {
                    $del_beneficiary_images = BeneficiaryImage::whereIn('referance_key', $referances)->delete();

                    $del_family_project = FamilyProject::whereIn('referance_key', $referances)->delete();
                    $del_health_records = HealthRecord::whereIn('referance_key', $referances)->delete();
                    $del_living_details = LivingDetail::whereIn('referance_key', $referances)->delete();
                    $del_obstructions = Obstruction::whereIn('referance_key', $referances)->delete();
                    $del_orphan_needs = OrphanNeed::whereIn('referance_key', $referances)->delete();
                    $del_religion_education = ReligionEducation::whereIn('referance_key', $referances)->delete();
                    $del_school_education = SchoolEducation::whereIn('referance_key', $referances)->delete();
                    $del_university_educations = UniversityEducation::whereIn('referance_key', $referances)->delete();
                    $del_visitor_report = VisitReport::whereIn('referance_key', $referances)->delete();
                }
                $beneficiary->delete();
                $del_referances = ReferencesList::where('beneficiary_index', '=', $beneficiary_index)->delete();
            }
        }
    }
}


