<?php

namespace App\Http\Controllers;

use App\Lookup;
use App\ReportHeader;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function s2()
    {
        if (in_array(9, auth()->user()->user_per)) {
            $this->data['sub_menu'] = 'setting';
            $this->data['location_title'] = 'اعدادات النظام';
            $this->data['location_link'] = '/setting/s2';
            $this->data['title'] = 'اعدادات النظام';
            $this->data['page_title'] = 'ثوابت النظام';
            $this->data['portlet_title'] = 'اضافة قيمة';
            //  dd($this->getStaticLookupList(191,1));
            return view(setting_vw() . '.s2')->with($this->data);
        }
        else
            return redirect()->to('home');
    }

    public function s2_data()
    {

        $table = Lookup::query();
        $num = 1;
        return datatables()->of($table)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('parent_name', function ($model) {// as foreach ($users as $user)

                return $this->getLookup($model->lookup_cat_id);
            })
            ->addColumn('action', function ($table) {// as foreach ($users as $user)

                return '
                <div class="col-md-4">
                <div class="col-md-5">
                <a href="#" onclick="fillForm(' . $table->id . ',\'' . $table->lookup_cat_details . '\',\'' . $table->lookup_type . '\')" type="button" class=" btn btn-icon-only green"><i class="fa fa-edit"></i></a>
                </div>

                <div class="col-md-5">
                <button type="button" data-toggle="modal" href="#detailModal" class="btn btn-icon-only btn-warning"
                onclick="addDetail(' . $table->id . ',\'' . $table->lookup_type . '\')"><i class="fa fa-stethoscope"></i></button>
                </div>
                </div>';
            })
            ->rawColumns(['action', 'parent_name'])
            ->toJson();
    }

    /*<div class="col-md-2">
    <button type="button" class="btn btn-icon-only red" onclick="settingDelete(' . $table->id . ')"><i class="fa fa-times"></i></button>
    </div>*/
    public function s2_save(Request $request)
    {
        $id = $request->hdn_table_id;

        if ($id == '') {
            $table = new Lookup();
            $table->lookup_cat_details = $request->lookup_cat_details;
            $table->lookup_cat_id = 0;
            $table->lookup_type = $request->lookup_type;

        } else {
            $table = Lookup::find($id);
            $table->lookup_cat_details = $request->lookup_cat_details;
            $table->lookup_type = $request->lookup_type;

        }
        if ($table->save()) {
            return response()->json(['success' => true]);//return redirect()->to(role_vw() . '/');//

        } else
            return response()->json(['success' => false]);

    }

    public function s2_detials_data(Request $request)
    {
        $id = $request->table_id;
        //  dd($id);
        $table = Lookup::where('lookup_cat_id', $id);
        $num = 1;
        return datatables()->of($table)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('action', function ($table) {// as foreach ($users as $user)
                return '
                <div class="col-md-12">
                <div class="col-md-2">
                <a href="#" onclick="fillDetailForm(' . $table->id . ',\'' . $table->lookup_cat_details . '\',\'' . $table->lookup_type . '\')" type="button" class=" btn btn-icon-only green"><i class="fa fa-edit"></i></a>
                </div><div class="col-md-2">
                <button type="button" class="btn btn-icon-only red" onclick="detailDelete(' . $table->id . ')"><i class="fa fa-times"></i></button></div></div>';
            })
            ->rawColumns(['action'])
            ->toJson();
    }


    public function s2_details_save(Request $request)
    {
        $id = $request->hdn_lookup_id;
        $did = $request->hdn_dtable_id;
        // dd($request->dlookup_cat_details);
        if ($did == '') {
            $table = new Lookup();
            $table->lookup_cat_id = $id;
            $table->lookup_cat_details = $request->dlookup_cat_details;
            $table->lookup_type = $request->dlookup_type;

        } else {

            $table = Lookup::find($did);
            $table->lookup_cat_details = $request->dlookup_cat_details;
            $table->lookup_type = $request->dlookup_type;
            //$table->lookup_type=$request->hdn_cat_type;

        }
        if ($table->save()) {
            return response()->json(['success' => true]);//return redirect()->to(role_vw() . '/');//

        } else
            return response()->json(['success' => false]);

    }

    public function s2_delete(Request $request)
    {

        $id = $request->id;
        $table = Lookup::find($id);
        if ($table)
            if ($table->delete()) {
                $dtable = Lookup::where('lookup_cat_id', $id)->delete();
                return response()->json(['success' => true]);
            }

    }

    public function s2_detail_delete(Request $request)
    {

        $id = $request->id;
        $table = Lookup::find($id);
        if (isset($table))
            if ($table->delete())
                return response()->json(['success' => true]);

    }

    public function s4()
    {
        if (in_array(10, auth()->user()->user_per)) {
            $this->data['sub_menu'] = 'setting';
            $this->data['location_title'] = 'اعدادات النظام';
            $this->data['location_link'] = '/setting/s2';
            $this->data['title'] = 'اعدادات النظام';
            $this->data['page_title'] = 'ثوابت النظام';
            $this->data['portlet_title'] = 'اضافة قيمة';
            return view(setting_vw() . '.s4')->with($this->data);
        }
        else
            return redirect()->to('home');
    }

    public function s4_data()
    {

        $table = ReportHeader::query();
        $num = 1;
        return datatables()->of($table)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('account_type_desc', function ($table) {// as foreach ($users as $user)
                //$account_name = [1 => 'يتيم', 2 => 'معاق', 3 => 'اسرة', 4 => 'طالب'];
                $account_name = [4 => 'يتيم', 1 => 'معاق', 3 => 'اسرة', 2 => 'طالب', 10 => 'حقول مشتركة'];
                return $account_name[$table->account_type];
            })
            ->filterColumn('account_type_desc', function ($query, $keyword) {
                $account_name = [4 => 'يتيم', 1 => 'معاق', 3 => 'اسرة', 2 => 'طالب', 10 => 'حقول مشتركة'];

                $account_type = array_search($keyword, $account_name);

                // dd($account_type);
                $query->where('account_type', $account_type);
            })
            ->addColumn('report_type_desc', function ($table) {// as foreach ($users as $user)
                $active_year = '';
                $active_both = '';
                $active_follow = '';
                if ($table->report_type == 1)
                    $active_year = 'active';
                if ($table->report_type == 0)
                    $active_both = 'active';
                if ($table->report_type == 2)
                    $active_follow = 'active';
                return '
                <div class="btn-group" data-toggle="buttons">
                <label class="btn green ' . $active_year . '" onclick="changeState(' . $table->id . ',1);">
                <input type="radio" class="toggle" > سنوي </label>
                <label class="btn green ' . $active_both . '" onclick="changeState(' . $table->id . ',0);">
                <input type="radio" class="toggle" > مشترك </label>
                <label class="btn green ' . $active_follow . '" onclick="changeState(' . $table->id . ',2);">
                <input type="radio" class="toggle" >متابعة </label>
                </div>';
            })
            ->rawColumns(['report_type_desc', 'account_type_desc'])
            ->toJson();
    }

    function s4_change_state(Request $request)
    {
        // dd($request->all());
        $id = $request->id;
        $state = $request->state;
        $item = ReportHeader::find($id);
        if (isset($item)) {
            $item->report_type = $state;
            if ($item->save())
                return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);

    }
}
