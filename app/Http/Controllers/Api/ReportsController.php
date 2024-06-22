<?php

namespace App\Http\Controllers\Api;

use App\BeneficiariesProfile;
use App\BeneficiaryImage;
use App\BeneficiaryReferenceStatus;
use App\FamilyProject;
use App\GuardianDetail;
use App\HealthRecord;
use App\Http\Controllers\Controller;
use App\LivingDetail;
use App\Obstruction;
use App\OrphanNeed;
use App\OtherNeed;
use App\ReferencesList;
use App\ReligionEducation;
use App\SchoolEducation;
use App\StatisticalCard;
use App\SuccessStory;
use App\UniversityEducation;
use App\VisitReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportsController extends Controller
{
    //
    public function newBenfReport(Request $request)
    {
        $data = $request->data;
        // dd($data);
        for ($i = 0; $i < count($data); $i++) {

            $beneficiary_identity = $data[$i]['profile']['beneficiary_identity'];
            $visit_date = $data[$i]['profile']['visit_date'];
            $beneficiaryPofile = $this->beneficiaryPofile($data[$i]['profile']);

            $reference = ReferencesList::where('beneficiary_index', '=', $beneficiaryPofile)
                ->whereIn('report_status', [290, 292])//تقرير معتمد من الباحث فقط
                ->where('visit_by', '=', auth()->user()->id)->first();
            // REFERENCE LIST
            // dd($reference);
            if (!isset($reference)) {//new visit
                $reference = new ReferencesList();
                $reference->beneficiary_identity = $beneficiary_identity;
                $reference->beneficiary_index = $beneficiaryPofile;
                $reference->visit_date = $visit_date;
                $reference->visit_by = auth()->user()->id;
                $reference->add_date = date('Y-m-d');
                $reference->visit_type = $data[$i]['profile']['visit_type'];
                $reference->created_by = auth()->user()->id;
                $reference->report_status = 290;
                $reference->report_status_updated_by = auth()->user()->id;

                if ($reference->save()) {
                    $reference_status = new BeneficiaryReferenceStatus();
                    $reference_status->referance_key = $reference->id;
                    $reference_status->status = 290;
                    $reference_status->created_by = auth()->user()->id;
                    $reference_status->save();

                } else
                    return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $reference]);

            } else {//update visit
                $reference->beneficiary_identity = $beneficiary_identity;
                $reference->beneficiary_index = $beneficiaryPofile;
                $reference->visit_date = $visit_date;
                $reference->visit_by = auth()->user()->id;
                $reference->add_date = date('Y-m-d');
                $reference->visit_type = $data[$i]['profile']['visit_type'];

                if (!$reference->save())
                    return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $reference]);

            }


            $profile = BeneficiariesProfile::where('id', '=', $beneficiaryPofile)->first();
            $profile->last_referance_key = $reference->id;
            //$image = $this->getBenImage($reference->id);


            if ($profile->save()) {
                if (isset($data[$i]['image_links']))
                    $this->addImages($data[$i]['image_links'], $reference->id);
                if (isset($data[$i]['image']))
                    $this->beneficiaryImages($data[$i]['image'], $reference->id);
                if (isset($data[$i]['school']))
                    $this->schoolEdu($data[$i]['school'], $reference->id);
                if (isset($data[$i]['health']))
                    $this->healthRecord($data[$i]['health'], $reference->id);
                if (isset($data[$i]['religion']))
                    $this->religion($data[$i]['religion'], $reference->id);
                if (isset($data[$i]['orphan']))
                    $this->orphan($data[$i]['orphan'], $reference->id);
                if (isset($data[$i]['live']))
                    $this->living($data[$i]['live'], $reference->id);
                if (isset($data[$i]['family']))
                    $this->family($data[$i]['family'], $reference->id);
                if (isset($data[$i]['visitor_report']))
                    $this->visit_report($data[$i]['visitor_report'], $reference->id);
                if (isset($data[$i]['obstruction']))
                    $this->obstruction($data[$i]['obstruction'], $reference->id);
                if (isset($data[$i]['university']))
                    $this->university($data[$i]['university'], $reference->id);
                /*if (isset($data[$i]['statistical_card']['needs']))
                    $this->statistical_card($data[$i]['statistical_card']['needs'], $reference->id);
                if (isset($data[$i]['statistical_card']['story']))
                    $this->story($data[$i]['statistical_card']['story'], $reference->id);*/
            }
            $result[] = [
                'reference' => $reference,
                'image' => $image,

            ];
        }

        return response()->json(['status' => true, 'status_code' => 200, 'message' => ' تمت العملية بنجاح', 'data' => $result]);
    }

    public function beneficiaryPofile($data)
    {
        //dd($data['beneficiary_identity']);
        $profile = BeneficiariesProfile::where('beneficiary_identity', '=', $data['beneficiary_identity'])->where('account_type', $data['account_type'])->first();
        //dd($profile);
        if (!isset($profile))    // New Profile
        {
            $profile = new BeneficiariesProfile();
            $profile->account_type = $data['account_type'];
            $profile->beneficiary_id = $data['beneficiary_id'];
            $profile->sponser_id = $data['sponser_id'];
            $profile->beneficiary_identity = $data['beneficiary_identity'];
            $profile->full_name = $data['full_name'];
            $profile->gender = $data['gender'];
            $profile->birth_date = $data['birth_date'];
            $profile->guardian = $data['guardian'];
            $profile->guardian_identity = $data['guardian_identity'];
            $profile->guardian_relation = $data['guardian_relation'];
            $profile->nationality = $data['nationality'];
            $profile->governorate = $data['governorate'];
            $profile->city = $data['city'];
            $profile->neighborhood = (isset($data['neighborhood']) ? $data['neighborhood'] : '');
            $profile->full_address = $data['full_address'];
            $profile->home_location = $data['home_location'];
            $profile->latitude = $data['latitude'];
            $profile->longitude = $data['longitude'];
            $profile->mobile_no = $data['mobile_no'];
            $profile->mobile_no1 = $data['mobile_no1'];
            $profile->phone = $data['phone'];
            $profile->marital_status = $data['marital_status'];
            // $profile->last_referance_key = $data['last_referance_key'];
            $profile->nearist_quran = $data['nearist_quran'];
            $profile->nearist_institute = $data['nearist_institute'];
            $profile->created_by = auth()->user()->id;
            if ($profile->save())
                return $profile->id;
            if (!$profile->save())
                return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $data]);
        } else    // Update Profile
        {
            $profile->account_type = $data['account_type'];
            $profile->beneficiary_id = $data['beneficiary_id'];
            $profile->sponser_id = $data['sponser_id'];
            $profile->beneficiary_identity = $data['beneficiary_identity'];
            $profile->full_name = $data['full_name'];
            $profile->gender = $data['gender'];
            $profile->birth_date = $data['birth_date'];
            $profile->guardian = $data['guardian'];
            $profile->guardian_identity = $data['guardian_identity'];
            $profile->guardian_relation = $data['guardian_relation'];
            $profile->nationality = $data['nationality'];
            $profile->governorate = $data['governorate'];
            $profile->city = $data['city'];
            $profile->neighborhood = (isset($data['neighborhood']) ? $data['neighborhood'] : '');
            $profile->full_address = $data['full_address'];
            $profile->home_location = $data['home_location'];
            $profile->latitude = (isset($data['latitude']) ? $data['latitude'] : '');
            $profile->longitude = (isset($data['longitude']) ? $data['longitude'] : '');
            $profile->mobile_no = $data['mobile_no'];
            $profile->mobile_no1 = $data['mobile_no1'];
            $profile->phone = $data['phone'];
            $profile->marital_status = $data['marital_status'];
            // $profile->last_referance_key = $data['last_referance_key'];
            $profile->nearist_quran = $data['nearist_quran'];
            $profile->nearist_institute = $data['nearist_institute'];


            // $attend->created_by = auth()->user()->id;
            if ($profile->save())
                return $profile->id;
            if (!$profile->save())
                return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $data]);
        }


    }

    public function addImages01($data, $referance_key)
    {
        // Beneficiary Images
        // $image = BeneficiaryImage::where('referance_key', $referance_key)->first();
        //  dd(count($data));
        //  if (!$image) {
        // if (count($data) > 0)
        $oldimages = BeneficiaryImage::where('referance_key', $referance_key)->delete();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['image_name'] != '') {
                // dd($data[$i]['image_name']);
                $fileName = '';
                $imageurl = $data[$i]['image_name'];

//                $fileName = explode('/storage', $imageurl);


                $image = new BeneficiaryImage();

                $image->image_name = $data[$i]['image_name'];
                $image->referance_key = $referance_key;
                $image->created_by = auth()->user()->id;
                $image->save();
            }


        }

    }
    public function addImages($data, $referance_key)
    {
        //  Images links
        $oldimages = BeneficiaryImage::where('referance_key', $referance_key)->delete();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['image_name'] != '') {
                $fileName = '';
                $imageurl = $data[$i]['image_name'];
                $fileName = explode('/',$imageurl);


                $image = new BeneficiaryImage();
                $image->image_name = '/'.$fileName[6].'/'.$fileName[7];
                $image->referance_key = $referance_key;
                $image->created_by = auth()->user()->id;
                $image->save();
            }


        }

    }
    public function beneficiaryImages($data, $referance_key)
    {
        // Beneficiary Images
        // $image = BeneficiaryImage::where('referance_key', $referance_key)->first();

        //  if (!$image) {

        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['image_name'] != '') {
                // dd($data[$i]['image_name'] );
                $image = new BeneficiaryImage();
                $file = $data[$i]['image_name'];  // your base64 encoded

                $fullstring = $file;
                $ext = $this->get_string_between($fullstring, 'image/', ';base64');

                // dd($ext); // (result = dog)

                $file = str_replace('data:image/' . $ext . ';base64,', '', $file);

                $file = str_replace(' ', '+', $file);
                $fileName = str_random(10) . '.' . $ext;

                //  file_put_contents(public_path() . '\storage\reports' . '\\' . $fileName, base64_decode($file));
                file_put_contents(public_path() . '/storage/reports' . '/' . $fileName, base64_decode($file));
                $image->image_name = '/reports/' . $fileName;
                $image->referance_key = $referance_key;
                $image->created_by = auth()->user()->id;
                $image->save();
            }
            /*  if (!$image->save())
                  return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $data]);*/

        }

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

    public function schoolEdu($data, $referance_key)
    {
        $school = SchoolEducation::where('referance_key', $referance_key)->first();
        if (!isset($school)) {
            $school = new SchoolEducation();
            $school->school_name = $data['school_name'];
            $school->study_level = $data['study_level'];
            $school->study_class = $data['study_class'];
            $school->current_avg = $data['current_avg'];
            $school->currentlevel = $data['currentlevel'];
            $school->referance_key = $referance_key;
            $school->created_by = auth()->user()->id;
            if (!$school->save())
                return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $school]);
        } else {

            $school->school_name = $data['school_name'];
            $school->study_level = $data['study_level'];
            $school->study_class = $data['study_class'];
            $school->current_avg = $data['current_avg'];
            $school->currentlevel = $data['currentlevel'];
            //$school->referance_key = $referance_key;
            if (!$school->save())
                return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $school]);
        }
    }

    public function healthRecord($data, $referance_key)
    {

        $health = HealthRecord::where('referance_key', $referance_key)->first();
        if (!isset($health)) {
            $health = new HealthRecord();
            $health->health_status = $data['health_status'];
            $health->health_status_details = $data['health_status_details'];
            $health->food_details = $data['food_details'];
            $health->workout_details = $data['workout_details'];
            $health->referance_key = $referance_key;
            $health->created_by = auth()->user()->id;
            if (!$health->save())
                return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $health]);
        } else {
            $health->health_status = $data['health_status'];
            $health->health_status_details = $data['health_status_details'];
            $health->food_details = $data['food_details'];
            $health->workout_details = $data['workout_details'];

            if (!$health->save())
                return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $health]);
        }
    }

    public function religion($data, $referance_key)
    {
        $religion = ReligionEducation::where('referance_key', $referance_key)->first();
        if (!isset($religion)) {
            $religion = new ReligionEducation();
            $religion->praying = $data['praying'];
            $religion->memorizes_quran = $data['memorizes_quran'];
            $religion->parts_no = $data['parts_no'];
            $religion->sura_no = $data['sura_no'];
            $religion->skills = $data['skills'];
            $religion->referance_key = $referance_key;
            $religion->created_by = auth()->user()->id;
            if (!$religion->save())
                return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $religion]);
        } else {
            $religion->praying = $data['praying'];
            $religion->memorizes_quran = $data['memorizes_quran'];
            $religion->parts_no = $data['parts_no'];
            $religion->sura_no = $data['sura_no'];
            $religion->skills = $data['skills'];

            if (!$religion->save())
                return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $religion]);
        }
    }

    public function orphan($data, $referance_key)
    {
        if (count($data) > 0)
            $orphandata = OrphanNeed::where('referance_key', $referance_key)->delete();
        // Orphan needs
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['what_needed'] != '') {

                // Orphan Needs
                //  $orphan = OrphanNeed::where('referance_key', $referance_key)->first();
                //  if (!isset($orphan)) {
                $orphan = new OrphanNeed();
                $orphan->what_needed = $data[$i]['what_needed'];
                $orphan->needed_price = $data[$i]['needed_price'];
                $orphan->currency = $data[$i]['currency'];
                $orphan->needed_details = $data[$i]['needed_details'];
                $orphan->referance_key = $referance_key;
                $orphan->created_by = auth()->user()->id;
                if (!$orphan->save())
                    return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $orphan]);
            }
        }

    }

    public function living($data, $referance_key)
    {
        // Living

        // Living Details
        $live = LivingDetail::where('referance_key', $referance_key)->first();
        if (!isset($live)) {
            $live = new LivingDetail();
            $live->live_details = $data['live_details'];
            $live->live_area = $data['live_area'];
            $live->live_type = $data['live_type'];
            $live->live_needs = $data['live_needs'];
            $live->live_ownership = $data['live_ownership'];
            $live->development_needs = $data['development_needs'];
            $live->referance_key = $referance_key;
            $live->created_by = auth()->user()->id;
            if (!$live->save())
                return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $live]);
        } else {
            $live->live_details = $data['live_details'];
            $live->live_area = $data['live_area'];
            $live->live_type = $data['live_type'];
            $live->live_needs = $data['live_needs'];
            $live->live_ownership = $data['live_ownership'];
            $live->development_needs = $data['development_needs'];
            if (!$live->save())
                return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $live]);
        }
    }

    public function family($data, $referance_key)
    {
        // Family

        // Family Project
        $family = FamilyProject::where('referance_key', $referance_key)->first();
        if (!isset($family)) {
            $family = new FamilyProject();
            $family->project_name = $data['project_name'];
            $family->project_details = $data['project_details'];
            $family->success_indecation = $data['success_indecation'];
            $family->referance_key = $referance_key;
            $family->created_by = auth()->user()->id;
            if (!$family->save())
                return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $family]);
        } else {
            $family->project_name = $data['project_name'];
            $family->project_details = $data['project_details'];
            $family->success_indecation = $data['success_indecation'];
            if (!$family->save())
                return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $family]);
        }
    }

    public function visit_report($data, $referance_key)
    {
        // Visit Report

        $visit = VisitReport::where('referance_key', $referance_key)->first();

        if (!isset($visit)) {

            $visit = new VisitReport();
            $visit->visitor_goals = $data['visitor_goals'];
            $visit->health_updates = $data['health_updates'];
            $visit->educational_updates = $data['educational_updates'];
            $visit->economical_updates = $data['economical_updates'];
            $visit->social_updates = $data['social_updates'];
            $visit->living_updates = $data['living_updates'];
            $visit->general_note = $data['general_note'];
            $visit->visitor_recommend = $data['visitor_recommend'];
            $visit->visitor_stop_resone = $data['visitor_stop_resone'];
            $visit->visitor_notes = $data['visitor_notes'];
            $visit->referance_key = $referance_key;
            $visit->created_by = auth()->user()->id;
            if (!$visit->save())
                return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $visit]);
        } else {
            $visit->visitor_goals = $data['visitor_goals'];
            $visit->health_updates = $data['health_updates'];
            $visit->educational_updates = $data['educational_updates'];
            $visit->economical_updates = $data['economical_updates'];
            $visit->social_updates = $data['social_updates'];
            $visit->living_updates = $data['living_updates'];
            $visit->general_note = $data['general_note'];
            $visit->visitor_recommend = $data['visitor_recommend'];
            $visit->visitor_stop_resone = $data['visitor_stop_resone'];
            $visit->visitor_notes = $data['visitor_notes'];
            if (!$visit->save())
                return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $visit]);
        }
    }

    public function obstruction($data, $referance_key)
    {
        // Family

        // Family Project
        $obs = Obstruction::where('referance_key', $referance_key)->first();
        if (!isset($obs)) {
            $obs = new Obstruction();
            $obs->obstruction_type = $data['obstruction_type'];
            $obs->obstruction_details = $data['obstruction_details'];
            $obs->referance_key = $referance_key;
            $obs->created_by = auth()->user()->id;
            if (!$obs->save())
                return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $obs]);
        } else {
            $obs->obstruction_type = $data['obstruction_type'];
            $obs->obstruction_details = $data['obstruction_details'];
            if (!$obs->save())
                return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $obs]);
        }
    }

    public function university($data, $referance_key)
    {
        // Family

        // Family Project
        $Uni = UniversityEducation::where('referance_key', $referance_key)->first();
        if (!isset($Uni)) {
            $Uni = new UniversityEducation();
            $Uni->university_name = $data['university_name'];
            $Uni->university_level = $data['university_level'];
            $Uni->university_major = $data['university_major'];
            $Uni->current_avg = $data['current_avg'];
            $Uni->current_level = $data['current_level'];
            $Uni->referance_key = $referance_key;
            $Uni->created_by = auth()->user()->id;
            if (!$Uni->save())
                return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $Uni]);
        } else {
            $Uni->university_name = $data['university_name'];
            $Uni->university_level = $data['university_level'];
            $Uni->university_major = $data['university_major'];
            $Uni->current_avg = $data['current_avg'];
            $Uni->current_level = $data['current_level'];

            if (!$Uni->save())
                return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $Uni]);
        }
    }

    public function staticalCard(Request $request)
    {
        $data = $request->data;
        // dd($data);
        for ($i = 0; $i < count($data['staticalCard']); $i++) {
            if (isset($data['staticalCard'][$i]['referance_key'])) {
                $referance_key = $data['staticalCard'][$i]['referance_key'];

                $staticalCards = StatisticalCard::where('referance_key', '=', $referance_key)->delete();

                if (isset($data['staticalCard'][$i]['needs']))
                    $this->addStatistical_card($data['staticalCard'][$i]['needs'], $referance_key);

                if (isset($data['staticalCard'][$i]['story']))
                    $this->addStory($data['staticalCard'][$i]['story'], $referance_key);
                if (isset($data['staticalCard'][$i]['other_need']))
                    $this->addOtherNeed($data['staticalCard'][$i]['other_need'], $referance_key);
            } else {
                return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $data[$i]]);
            }

        }
        return response()->json(['status' => true, 'status_code' => 200, 'message' => ' تمت العملية بنجاح', 'data' => $data]);
    }

    public
    function addStatistical_card($data, $referance_key)
    {
        // Statistical Card
        if (isset($data))
            for ($i = 0; $i < count($data); $i++) {
                if ($data[$i]['need_id'] != '') {
                    $StatisticalCard = StatisticalCard::where('referance_key', $referance_key)
                        ->where('need_id', $data[$i]['need_id'])
                        ->where('sub_need_id', $data[$i]['sub_need_id'])
                        ->where('need_outcome_id', $data[$i]['need_outcome_id'])->first();
                    if (!isset($StatisticalCard)) {
                        $StatisticalCard = new StatisticalCard();
                        $StatisticalCard->need_id = $data[$i]['need_id'];
                        $StatisticalCard->sub_need_id = $data[$i]['sub_need_id'];
                        $StatisticalCard->need_outcome_id = $data[$i]['need_outcome_id'];
                        $StatisticalCard->referance_key = $referance_key;
                        $StatisticalCard->created_by = auth()->user()->id;

                        if (!$StatisticalCard->save())
                            return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $StatisticalCard]);
                    }
                }
            }

    }

    public function addStory($data, $referance_key)
    {
        // Success Story
        if (isset($data) && $data != '') {
            $story = SuccessStory::where('referance_key', $referance_key)->first();
            if (!isset($story)) {
                $story = new SuccessStory();
                $story->story_details = $data;
                $story->referance_key = $referance_key;
                $story->created_by = auth()->user()->id;
                if (!$story->save())
                    return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $story]);
            } else {
                $story->story_details = $data;
                if (!$story->save())
                    return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $story]);
            }
        }
    }

    public function addOtherNeed($data, $referance_key)
    {
        // Success Story
        if (isset($data) && $data != '') {
            $obj = OtherNeed::where('referance_key', $referance_key)->first();
            if (!isset($obj)) {
                $obj = new OtherNeed();
                $obj->need_details = $data;
                $obj->referance_key = $referance_key;
                $obj->created_by = auth()->user()->id;
                if (!$obj->save())
                    return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $obj]);
            } else {
                $obj->need_details = $data;
                if (!$obj->save())
                    return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $obj]);
            }
        }
    }

    public
    function getAllBenfReport(Request $request)
    {
        $rules = [
            'account_type' => 'required',
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
        $page_number = $request->page_number;
        $per_page = $request->per_page;

        $total_referances = ReferencesList::join('beneficiaries_profile', 'references_list.id', '=', 'beneficiaries_profile.last_referance_key')
            ->where('references_list.created_by', '=', auth()->user()->id)
            ->where('account_type', $request->account_type)->count();
        //  dd($total_referances);
//
        $total_page = ceil($total_referances / $per_page);
        //dd($page_number * $per_page);
        $references = ReferencesList::join('beneficiaries_profile', 'references_list.id', '=', 'beneficiaries_profile.last_referance_key')
            ->where('references_list.created_by', '=', auth()->user()->id)
            ->where('account_type', $request->account_type)
            ->orderBy('references_list.visit_date', 'DESC')
            ->take($per_page)
            ->skip($page_number * $per_page)
            ->get();
        //  dd($references);
        $att = [
            'total_page' => $total_page,
            'page_number' => $page_number,
            'per_page' => $per_page
        ];
        if ($references->isEmpty())
            return response()->json(['status' => true, 'status_code' => 200, 'message' => 'لم تتم العملية بنجاح', 'data' => [], 'attribute' => $att]);
        //  $data[]=['account_type'=> $request->account_type];
        foreach ($references as $reference) {
            $data[] = [
                'reference_key' => $reference->last_referance_key,
                'beneficiary_identity' => $reference->beneficiary_identity,
                'full_name' => $reference->full_name,
                'beneficiary_id' => $reference->beneficiary_id,
                'mobile_no' => $reference->mobile_no,
                'visit_date' => $reference->visit_date,
                'visit_type' => $reference->visit_type,
                'visit_by' => $reference->visit_by,
                'account_type' => $reference->account_type,
                'sponser_id' => $reference->sponser_id,
                /* */
            ];

        }

        return response()->json(['status' => true, 'status_code' => 200, 'message' => 'لم تتم العملية بنجاح', 'data' => $data, 'attribute' => $att]);
    }

    public
    function getBenVisits(Request $request)
    {
        $rules = [
            'beneficiary_identity' => 'required|numeric|exists:beneficiaries_profile,beneficiary_identity',
            'account_type' => 'required|numeric|exists:beneficiaries_profile,account_type'];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $messages = $validator->errors();
            $errors = $this->validatorErrorMsg($rules, $messages);
            //   return response()->json(['success' => false, 'message' => $errors]);
            return response()->json(['status' => false, 'status_code' => 401, 'message' => $errors, 'data' => []]);

        }
        $beneficiary_identity = $request->beneficiary_identity;
        $account_type = $request->account_type;


        $profile = BeneficiariesProfile::where('beneficiary_identity', '=', $beneficiary_identity)->where('account_type', $account_type)->first();
        if (isset($profile)) {
            $reference = ReferencesList::where('beneficiary_index', '=', $profile->beneficiary_index)->get();
            //  ->where('account_type', '=', $account_type)->get();
            if (isset($reference))
                $data = [
                    'reference' => $reference
                ];
            if (isset($reference)) {
                return response()->json(['status' => true, 'status_code' => 200, 'message' => ' تمت العملية بنجاح', 'data' => $data]);
            }
            return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $request]);
        }
        return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $request]);
    }

    public
    function getVisitsWithImage(Request $request)
    {
        $rules = [
            'beneficiary_identity' => 'required|numeric|exists:beneficiaries_profile,beneficiary_identity',
            'account_type' => 'required|numeric|exists:beneficiaries_profile,account_type'];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $messages = $validator->errors();
            $errors = $this->validatorErrorMsg($rules, $messages);
            //   return response()->json(['success' => false, 'message' => $errors]);
            return response()->json(['status' => false, 'status_code' => 401, 'message' => $errors, 'data' => []]);

        }
        $beneficiary_identity = $request->beneficiary_identity;
        $account_type = $request->account_type;
        $profile = BeneficiariesProfile::where('beneficiary_identity', '=', $beneficiary_identity)->where('account_type', '=', $account_type)->first();
        //  dd($profile->id);
        //     $references = ReferencesList::where('beneficiary_identity', '=', $beneficiary_identity)->get();
        if (isset($profile)) {
            $references = ReferencesList::where('beneficiary_index', '=', $profile->id)->orderBy('visit_date', 'desc')->get();
            // dd($references);
            foreach ($references as $reference) {
                $rec = [
                    'id' => $reference->id,
                    'beneficiary_identity' => $reference->beneficiary_identity,
                    'beneficiary_index' => $reference->beneficiary_index,
                    'visit_date' => $reference->visit_date,
                    'visit_by' => $reference->visit_by,
                    'add_date' => $reference->add_date,
                    'visit_type' => $reference->visit_type,
                    'created_by' => $this->getUser($reference->created_by),
                    'deleted_at' => ($reference->deleted_at != null) ? $reference->deleted_at->toDateTimeString() : null,
                    'created_at' => $reference->created_at->toDateTimeString(),
                    'updated_at' => ($reference->updated_at != null) ? $reference->updated_at->toDateTimeString() : null,
                    'visit_name' => $reference->visit_name,
                    'report_status' => (isset($reference->report_status)) ? $reference->report_status : '',
                    'report_status_desc' => (isset($reference->report_status)) ? $this->getLookup($reference->report_status) : '',
                    'account_type' => $profile->account_type,
                    'StatisticalCard' => $this->getStatisticalCard($reference->id)

                ];
                $image = $this->getBenImage($reference->id);

                $data[] = [
                    'reference' => $rec,
                    'image' => $image,

                ];
            }
            if (isset($reference)) {
                return response()->json(['status' => true, 'status_code' => 200, 'message' => ' تمت العملية بنجاح', 'data' => $data]);
            }
            return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $request]);
        }
        return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $request]);
    }

    public
    function getStatisticalCard($referance_key)
    {
        $records = StatisticalCard::where('referance_key', $referance_key)->get();
        $data = array();
        if (count($records) > 0) {

            foreach ($records as $record) {
                $data[] = [
                    'need_id' => $record->need_id,
                    'sub_need_id' => $record->sub_need_id,
                    'need_outcome_id' => $record->need_outcome_id,
                    'created_by' => $this->getUser($record->created_by)
                ];
            }
        }
        return ['needs' => $data, 'story' => $this->getStory($referance_key), 'other_need' => $this->getOtherNeed($referance_key)];
    }

    public function getStory($referance_key)
    {
        $record = SuccessStory::where('referance_key', $referance_key)->first();
        if (isset($record)) {
            /*   $data = [
                   'story_details' => $record->story_details,
                   'created_by' => $this->getUser($record->created_by)
               ];
   */
            return $record->story_details;
        }
        return null;
    }

    public function getOtherNeed($referance_key)
    {
        $record = OtherNeed::where('referance_key', $referance_key)->first();
        if (isset($record)) {

            return $record->need_details;
        }
        return null;
    }

    public
    function getBenImage($referance_key)
    {
        $records = BeneficiaryImage::where('referance_key', $referance_key)->get();
//dd(count($records));
        if (count($records) > 0) {

            foreach ($records as $record) {
                $data[] = [
                    'image_name' => url('public/storage/') . $record->image_name
                ];
            }
            return $data;
        }
        return [];
    }

    function getStaticalCard(Request $request)
    {
        $referance_key = $request->referance_key;
        $records = StatisticalCard::where('referance_key', $referance_key)->get();
        $data = array();
        if (count($records) > 0) {

            foreach ($records as $record) {
                $data[] = [
                    'need_id' => $record->need_id,
                    'sub_need_id' => $record->sub_need_id,
                    'need_outcome_id' => $record->need_outcome_id,
                    'created_by' => $this->getUser($record->created_by)
                ];
            }
        }
        return ['needs' => $data, 'story' => $this->getStory($referance_key), 'other_need' => $this->getOtherNeed($referance_key)];
    }

    public
    function searchByname(Request $request)
    {
        $param = $request->name;
        $benfs = BeneficiariesProfile::where('full_name', 'LIKE', '%' . $param . '%')->orderBy('created_at', 'desc')->get();


        foreach ($benfs as $benf) {
            $reference = ReferencesList::where('id', '=', $benf->last_referance_key)->first();

            $data[] = [
                'reference_key' => $benf->last_referance_key,
                'beneficiary_identity' => $benf->beneficiary_identity,
                'full_name' => $benf->full_name,
                'beneficiary_id' => $benf->beneficiary_id,
                'mobile_no' => $benf->mobile_no,
                'visit_date' => (isset($reference->visit_date)) ? $reference->visit_date : '',
                'visit_type' => (isset($reference->visit_type)) ? $reference->visit_type : '',
                'visit_by' => (isset($reference->visit_by)) ? $reference->visit_by : '',
                'account_type' => $benf->account_type,
                'sponser_id' => $benf->sponser_id
                /* */
            ];
        }
        if (!$benfs->isEmpty()) {
            return response()->json(['status' => true, 'status_code' => 200, 'message' => ' تمت العملية بنجاح', 'data' => $data]);
        }
        return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $request]);

    }

    public
    function searchByParam(Request $request)
    {
        $name = $request->name;
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $type = $request->type;
        $sponser_id = $request->sponser_id;//رقم الكفالة
        $beneficiary_id = $request->beneficiary_id;//رقم الحالة

        $benfs = BeneficiariesProfile::query();
        if ($request->has('name') && $request->name != '')
            $benfs = $benfs->where('full_name', 'LIKE', '%' . $name . '%');

        if ($request->has('fromdate') && $request->fromdate != '')
            $benfs = $benfs->whereDate('created_at', '>=', $fromdate);

        if ($request->has('todate') && $request->todate != '')
            $benfs = $benfs->whereDate('created_at', '<=', $todate);

        if ($request->has('type') && $request->type != '')
            $benfs = $benfs->where('account_type', $type);
        if ($request->has('sponser_id') && $request->sponser_id != '')
            //$benfs = $benfs->where('sponser_id', $sponser_id);
            $benfs = $benfs->where('sponser_id', 'LIKE', '%' . $sponser_id . '%');
        if ($request->has('beneficiary_id') && $request->beneficiary_id != '')
            //  $benfs = $benfs->where('beneficiary_id', $beneficiary_id);
            $benfs = $benfs->where('beneficiary_id', 'LIKE', '%' . $beneficiary_id . '%');
        $benfs = $benfs->orderBy('created_at', 'desc')->get();
        foreach ($benfs as $benf) {
            $reference = ReferencesList::where('id', '=', $benf->last_referance_key)->first();

            $data[] = [
                'reference_key' => isset($benf->last_referance_key) ? $benf->last_referance_key : '',
                'beneficiary_identity' => $benf->beneficiary_identity,
                'full_name' => $benf->full_name,
                'beneficiary_id' => $benf->beneficiary_id,
                'mobile_no' => $benf->mobile_no,
                'visit_date' => (isset($reference->visit_date)) ? $reference->visit_date : '',
                'visit_type' => (isset($reference->visit_type)) ? $reference->visit_type : '',
                'visit_by' => (isset($reference->visit_by)) ? $reference->visit_by : '',
                'report_status' => (isset($reference->report_status)) ? $reference->report_status : '',
                'report_status_desc' => (isset($reference->report_status)) ? $this->getLookup($reference->report_status) : '',
                'account_type' => $benf->account_type,
                'sponser_id' => $benf->sponser_id
                /* */
            ];
        }
        if (!$benfs->isEmpty()) {
            return response()->json(['status' => true, 'status_code' => 200, 'message' => ' تمت العملية بنجاح', 'data' => $data]);
        }
        return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $request]);

    }

    public
    function getOneVisitReport(Request $request)
    {
        $rules = [
            'referance_key' => 'required|numeric|exists:references_list,id'];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $messages = $validator->errors();
            $errors = $this->validatorErrorMsg($rules, $messages);
            //   return response()->json(['success' => false, 'message' => $errors]);
            return response()->json(['status' => false, 'status_code' => 401, 'message' => $errors, 'data' => []]);

        }
        $referance_key = $request->referance_key;
        $reference = $this->getReferance($referance_key);
        $ref = ReferencesList::where('id', '=', $referance_key)->first();

        $profile = $this->getProfile($referance_key);


        $image = $this->getBenImage($referance_key);
        // dd($image);
        $health = $this->getHealthRecord($referance_key);

        $school = $this->getSchool($referance_key);
        // dd($school);
        $religion = $this->getReligion($referance_key);
        $orphan = $this->getOrphan($referance_key);
        $live = $this->getLiving($referance_key);
        $family = $this->getFamily($referance_key);
        $StatisticalCard = $this->getStatisticalCard($referance_key);
        //   $story = $this->getStory($referance_key);
        $visit = $this->getVisitReport($referance_key);
        $obstruction = $this->getObstruction($referance_key);
        $university = $this->getUniversity($referance_key);
        $data = [
            'reference' => $reference,
            'profile' => $profile,
            'image' => $image,
            'health' => $health,
            'school' => $school,
            'religion' => $religion,
            'orphan' => $orphan,
            'live' => $live,
            'family' => $family,
            'visit' => $visit,
            'obstruction' => $obstruction,
            'university' => $university,
            'StatisticalCard' => $StatisticalCard
            //  'story' => $story
        ];

        if (isset($reference)) {
            return response()->json(['status' => true, 'status_code' => 200, 'message' => ' تمت العملية بنجاح', 'data' => $data]);
        }
        return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $request]);

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
                'report_status' => (isset($records->report_status)) ? $records->report_status : '',
                'report_status_desc' => (isset($records->report_status)) ? $this->getLookup($records->report_status) : '',
                'created_by' => $this->getUser($records->created_by),
                'deleted_at' => ($records->deleted_at != null) ? $records->deleted_at->toDateTimeString() : null,
                'created_at' => $records->created_at->toDateTimeString(),
                'updated_at' => ($records->updated_at != null) ? $records->updated_at->toDateTimeString() : null,
                'visit_name' => $records->visit_name,
                'account_type' => $profile->account_type,
            ];
            return $data;
        }
        return null;

    }

    public
    function getProfile($referance_key)
    {
        $records = ReferencesList::where('id', '=', $referance_key)->first();
        $beneficiary = BeneficiariesProfile::where('beneficiary_identity', '=', $records->beneficiary_identity)->first();
        //$beneficiary = BeneficiariesProfile::where('last_referance_key', $referance_key)->first();
        //
        if (isset($beneficiary)) {
            $data = [
                'account_type' => $beneficiary->account_type,
                'beneficiary_id' => $beneficiary->beneficiary_id,
                'sponser_id' => $beneficiary->sponser_id,
                'beneficiary_identity' => $beneficiary->beneficiary_identity,
                'full_name' => $beneficiary->full_name,
                'gender' => $beneficiary->gender,
                'birth_date' => $beneficiary->birth_date,
                'guardian' => $beneficiary->guardian,
                'guardian_identity' => $beneficiary->guardian_identity,
                'guardian_relation' => $beneficiary->guardian_relation,
                'nationality' => $beneficiary->nationality,
                'governorate' => $beneficiary->governorate,
                'city' => $beneficiary->city,
                'neighborhood' => $beneficiary->neighborhood,
                'full_address' => $beneficiary->full_address,
                'home_location' => $beneficiary->home_location,
                'latitude' => $beneficiary->latitude,
                'longitude' => $beneficiary->longitude,
                'mobile_no' => $beneficiary->mobile_no,
                'mobile_no1' => $beneficiary->mobile_no1,
                'phone' => $beneficiary->phone,
                'marital_status' => $beneficiary->marital_status,
                'last_referance_key' => $beneficiary->last_referance_key,
                'nearist_quran' => $beneficiary->nearist_quran,
                'nearist_institute' => $beneficiary->nearist_institute,
                'created_by' => $this->getUser($beneficiary->created_by)

            ];

            return $data;
        }
        return null;


    }

    public
    function getHealthRecord($referance_key)
    {
        $records = HealthRecord::where('referance_key', '=', $referance_key)->first();
        if (isset($records)) {
            $data = [

                'health_status' => $records->health_status,
                'health_status_details' => $records->health_status_details,
                'food_details' => $records->food_details,
                'workout_details' => $records->workout_details,
                'created_by' => $this->getUser($records->created_by)];
            return $data;
        }
        return null;

    }

    public
    function getSchool($referance_key)
    {
        $records = SchoolEducation::where('referance_key', $referance_key)->first();

        if (!empty($records)) {
            // dd($this->getLookup($records->study_level));
            $data = [
                //Full texts	id	health_status	health_status_details	food_details	workout_details	referance_key
                'school_name' => $records->school_name,
                'study_level' => $records->study_level,
                'study_class' => $records->study_class,
                'currentlevel' => $records->currentlevel,
                'current_avg' => $records->current_avg,
                'created_by' => $this->getUser($records->created_by)];
            // dd($data);
            return $data;
        }
        return null;

    }

    public
    function getReligion($referance_key)
    {
        $records = ReligionEducation::where('referance_key', $referance_key)->first();
        if (!empty($records)) {
            $data = [
                //Full texts	id	health_status	health_status_details	food_details	workout_details	referance_key
                'praying' => $records->praying,
                'memorizes_quran' => $records->memorizes_quran,
                'parts_no' => $records->parts_no,
                'sura_no' => $records->sura_no,
                'skills' => $records->skills,
                'created_by' => $this->getUser($records->created_by)];

            return $data;
        }
        return null;

    }

    public
    function getOrphan($referance_key)
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

    public
    function getLiving($referance_key)
    {
        $records = LivingDetail::where('referance_key', $referance_key)->first();
        if (!empty($records)) {
            $data = [
                //Full texts	id	health_status	health_status_details	food_details	workout_details	referance_key
                'live_details' => $records->live_details,
                'live_area' => $records->live_area,
                'live_type' => $records->live_type,
                'live_needs' => $records->live_needs,
                'live_ownership' => $records->live_ownership,
                'development_needs' => $records->development_needs,
                'created_by' => $this->getUser($records->created_by)];

            return $data;
        }
        return null;

    }

    public
    function getFamily($referance_key)
    {
        $records = FamilyProject::where('referance_key', $referance_key)->first();
        if (!empty($records)) {
            $data = [
                //Full texts	id	health_status	health_status_details	food_details	workout_details	referance_key
                'project_name' => $records->project_name,
                'project_details' => $records->project_details,
                'success_indecation' => $records->success_indecation,
                'created_by' => $this->getUser($records->created_by)];

            return $data;
        }
        return null;

    }

    public
    function getVisitReport($referance_key)
    {
        $records = VisitReport::where('referance_key', $referance_key)->first();
        if (!empty($records)) {
            $data = [
                //Full texts	id	health_status	health_status_details	food_details	workout_details	referance_key
                'visitor_goals' => $records->visitor_goals,
                'health_updates' => $records->health_updates,
                'educational_updates' => $records->educational_updates,
                'economical_updates' => $records->economical_updates,
                'social_updates' => $records->social_updates,
                'living_updates' => $records->living_updates,
                'general_note' => $records->general_note,
                'visitor_recommend' => $records->visitor_recommend,
                'visitor_stop_resone' => $records->visitor_stop_resone,
                'visitor_notes' => $records->visitor_notes,
                'created_by' => $this->getUser($records->created_by)];

            return $data;
        }
        return null;

    }

    public
    function getObstruction($referance_key)
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

    public
    function getUniversity($referance_key)
    {
        $records = UniversityEducation::where('referance_key', $referance_key)->first();
        if (!empty($records)) {
            $data = [
                'university_name' => $records->university_name,
                'university_level' => $records->university_level,
                'university_major' => $records->university_major,
                'current_avg' => $records->current_avg,
                'current_level' => $records->current_level,
                'created_by' => $this->getUser($records->created_by)];

            return $data;
        }
        return null;

    }

    public
    function getVisitsBySponserId(Request $request)
    {
        $rules = [
            'sponser_id' => 'required|exists:beneficiaries_profile,sponser_id'];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $messages = $validator->errors();
            $errors = $this->validatorErrorMsg($rules, $messages);
            //   return response()->json(['success' => false, 'message' => $errors]);
            return response()->json(['status' => false, 'status_code' => 401, 'message' => $errors, 'data' => []]);

        }
        $sponser_id = $request->sponser_id;
        $profile = BeneficiariesProfile::where('sponser_id', '=', $sponser_id)->first();

        if (isset($profile)) {
            $reference = ReferencesList::where('beneficiary_index', '=', $profile->id)->orderBy('visit_date', 'desc')->get();

            if (isset($reference))
                $data = [
                    'profile' => $profile,
                    'reference' => $reference
                ];
            if (isset($reference)) {
                return response()->json(['status' => true, 'status_code' => 200, 'message' => ' تمت العملية بنجاح', 'data' => $data]);
            }
            return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $request]);
        }
        return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => $request]);
    }

    public
    function getOrphanOld($referance_key)
    {
        $records = OrphanNeed::where('referance_key', $referance_key)->first();
        if (!empty($records)) {
            $data = [
                'what_needed' => $records->what_needed,
                'needed_price' => $records->needed_price,
                'currency' => $records->currency,
                'needed_details' => $records->needed_details,
                'created_by' => $this->getUser($records->created_by)];

            return $data;
        }
        return null;

    }

    public
    function addBeneImages(Request $request)
    {
        $data = $request->data;
        //      dd($data);
        for ($i = 0; $i < count($data); $i++) {

            $beneficiary_identity = $data[$i]['profile']['beneficiary_identity'];
            $benf = BeneficiariesProfile::where('beneficiary_identity', '=', $beneficiary_identity)->first();
            if (isset($benf)) {
                $referance_key = $benf->last_referance_key;
                $images = $data[$i]['image'];// $this->beneficiaryPofile($data[$i]['profile']);

                // Beneficiary Images
                for ($i = 0; $i < count($images); $i++) {
                    if ($images[$i]['image_name'] != '') {

                        $image = new BeneficiaryImage();
                        $file = $images[$i]['image_name'];  // your base64 encoded

                        $fullstring = $file;
                        $ext = $this->get_string_between($fullstring, 'image/', ';base64');

                        $file = str_replace('data:image/' . $ext . ';base64,', '', $file);

                        $file = str_replace(' ', '+', $file);
                        $fileName = str_random(10) . '.' . $ext;
                        file_put_contents(public_path() . '/storage/reports' . '/' . $fileName, base64_decode($file));
                        $image->image_name = '/reports/' . $fileName;
                        $image->referance_key = $referance_key;
                        $image->created_by = auth()->user()->id;
                        $image->save();
                    }
                }

                return response()->json(['status' => true, 'status_code' => 200, 'message' => ' تمت العملية بنجاح', 'data' => $data]);

            }
        }
    }

    public
    function guard_details(Request $request)
    {
        $rules = [
            'guardian' => 'required',
            // 'guardian_identity' => 'required',
            'family_cout' => 'required|integer|min:1',
            'duration' => 'required|integer'
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
        $guardian_name = $request->guardian;
        $family_cout = $request->family_cout;
        $duration = $request->duration;
        $guardian = new GuardianDetail();
        //$guardian->guardian_identity = $guardian_identity;
        $guardian->guardian = $guardian_name;
        $guardian->family_cout = $family_cout;
        $guardian->duration = $duration;
        $guardian->created_by = $user;
        if ($guardian->save())
            return response()->json(['status' => true, 'status_code' => 200, 'message' => ' تتم العملية بنجاح', 'data' => $guardian]);

        return response()->json(['status' => false, 'status_code' => 401, 'message' => 'لم تتم العملية بنجاح', 'data' => []]);
    }

    public
    function get_guard_details(Request $request)
    {
        $user_id = auth()->user()->id;
        $guardians = GuardianDetail::where('created_by', $user_id)->get();
        $data = array();
        if (isset($guardians)) {
            foreach ($guardians as $guardian)
                $data[] = ['guardian' => $guardian->guardian, 'family_cout' => $guardian->family_cout, 'duration' => $guardian->duration];

            return response()->json(['status' => true, 'status_code' => 200, 'message' => ' تمت العملية بنجاح', 'data' => $data]);
        }
        return response()->json(['status' => true, 'status_code' => 200, 'message' => ' تمت العملية بنجاح', 'data' => $data]);

    }
}
