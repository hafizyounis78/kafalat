<?php

namespace App\Http\Controllers;

use App\BeneficiariesProfile;
use App\Lookup;
use App\ReferencesList;
use Illuminate\Http\Request;

class ReportController01 extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['sub_menu'] = 'report-display';
        $this->data['location_title'] = 'عرض التقارير';
        $this->data['location_link'] = 'report';
        $this->data['title'] = 'التقارير';
        $this->data['page_title'] = 'عرض التقارير ';
        $this->data['visitTypes']=Lookup::where('lookup_cat_id',8)->get();
        return view(report_vw() . '.view')->with($this->data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reportData(Request $request)
    {

       // $name = $request->name;
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $type = $request->type;

        $benfs = BeneficiariesProfile::query();
      /*  if ($request->has('name') && $request->name != '')
            $benfs = $benfs->where('full_name', 'LIKE', '%' . $name . '%');*/

        if ($request->has('fromdate') && $request->fromdate != '')
            $benfs = $benfs->whereDate('created_at', '>=', $fromdate);

        if ($request->has('todate') && $request->todate != '')
            $benfs = $benfs->whereDate('created_at', '<=', $todate);

        if ($request->has('type') && $request->type != '')
            $benfs = $benfs->where('account_type', $type);

        $benfs = $benfs->get();
        $num = 1;
        return datatables()->of($benfs)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('action', function ($table) {// as foreach ($users as $user)
                return '
                <div class="col-md-6">

                <div class="col-md-2">
                <button type="button" data-toggle="modal" href="#detailModal" class="btn btn-warning"
                onclick="getVisits(' . $table->beneficiary_identity . ')"><i class="fa fa-tasks"></i></button>
                </div>
                </div>';
            })
            ->toJson();
    }

    public function visitsData(Request $request)
    {
        $beneficiary_identity = $request->id;

        $model = ReferencesList::where('beneficiary_identity', '=',$beneficiary_identity);
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
                <div class="col-md-6">

                <div class="col-md-2">
                <button type="button" data-toggle="modal" href="#" class="btn purple-plum"
                onclick="viewReport(' . $table->id . ')"><i class="fa fa-print"></i></button>
                </div>
                </div>';
            })
            ->toJson();
    }

    public function filterVisitsData(Request $request)
    {
        $beneficiary_identity = $request->ben_id;
        $visit_type=$request->visit_type;
        $from=$request->fromdate;
        $to=$request->todate;

        $model = ReferencesList::where('beneficiary_identity', '=',$beneficiary_identity);
        if($visit_type!='')
            $model=$model->where('visit_type','=',$visit_type);
        if($from !='')
            $model=$model->whereDate('visit_date','>=',$from);
        if($to !='')
            $model=$model->whereDate('visit_date','<=',$to);
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
                <div class="col-md-6">

                <div class="col-md-2">
                <button type="button" data-toggle="modal" href="#" class="btn purple-plum"
                onclick="viewReport(' . $table->id . ')"><i class="fa fa-print"></i></button>
                </div>
                </div>';
            })
            ->toJson();
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
