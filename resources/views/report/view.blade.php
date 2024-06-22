@extends('admin.layout.index')
@section('content')
    <div class="page-content">
        <meta name="csrf-token" content="{{ csrf_token()}}">
        <h1 class="page-title"> {{$title}}
            <small>{{$location_title}}</small>
        </h1>
        <div class="page-bar">
            @include('admin.layout.breadcrumb')

        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>معاير البحث
                        </div>
                        <!-- <div class="tools">
                             <a href="javascript:;" class="collapse"> </a>

                         </div>-->
                    </div>
                    <div class="portlet-body form">
                        <form role="form" class="form-horizontal" id="seach-form">
                            <input type="hidden" id="banf_id_hdn">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">نوع التقرير</label>
                                            <div class="col-md-8">
                                                <select id="account_type" class="form-control select2"
                                                        name="account_type">
                                                    <option value="">جميع التقارير</option>
                                                    <option value="1">تقارير اليتيم</option>
                                                    <option value="2">تقارير الاسر</option>
                                                    <option value="3">تقارير المعاق</option>
                                                    <option value="4">تقارير الطالب</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">نوع الزيارة</label>
                                            <div class="col-md-8">
                                                <select id="visit_type" class="form-control select2"
                                                        name="visit_type">
                                                    <option value="">جميع الزيارات</option>
                                                    <?php

                                                    foreach ($accountTypes as $accountType) {

                                                        echo '<option value="' . $accountType->id . '">' . $accountType->lookup_cat_details . '</option>';
                                                    }

                                                    ?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">التاريخ </label>
                                            <div class="col-md-4">
                                                <div class="input-group input-large date-picker input-daterange"
                                                     data-date="10/11/2012" data-date-format="yyyy/mm/dd">
                                                    <input type="text" class="form-control" name="fromdate"
                                                           id="fromdate">
                                                    <span class="input-group-addon"> الى </span>
                                                    <input type="text" class="form-control" name="todate" id="todate">
                                                </div>
                                                <!-- /input-group -->
                                                {{--  <span class="help-block"> Select date range </span>--}}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">المحافظة</label>
                                            <div class="col-md-8">
                                                <select id="district_id" class="form-control select2 hselect"
                                                        name="district_id">
                                                    <option value="">اختر ..</option>
                                                    <?php

                                                    foreach ($districts as $district) {

                                                        echo '<option value="' . $district->id . '">' . $district->lookup_cat_details . '</option>';
                                                    }

                                                    ?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">الباحث</label>
                                            <div class="col-md-8">
                                                <select id="visit_by" class="form-control select2"
                                                        name="visit_by">
                                                    <option value="">جميع الموظفين</option>
                                                    <?php

                                                    foreach ($users as $user) {

                                                        echo '<option value="' . $user->id . '">' . $user->name . '</option>';
                                                    }

                                                    ?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">الاسم</label>
                                            <div class="col-md-8">
                                                <input type="text" id="name" class="form-control">
                                            </div>
                                            {{-- <span class="help-block"> This is inline help </span>--}}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">رقم الهوية</label>
                                            <div class="col-md-8">
                                                <input type="text" id="ben_id" class="form-control">
                                            </div>
                                            {{-- <span class="help-block"> This is inline help </span>--}}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">حالة التقرير</label>
                                            <div class="col-md-8">
                                                <select id="VisitorRecommend" class="form-control select2 hselect"
                                                        name="VisitorRecommend">
                                                    <option value="">اختر ..</option>
                                                    <?php

                                                    foreach ($VisitorRecommends as $VisitorRecommend) {

                                                        echo '<option value="' . $VisitorRecommend->id . '">' . $VisitorRecommend->lookup_cat_details . '</option>';
                                                    }

                                                    ?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">رقم الكفالة</label>
                                            <div class="col-md-8">
                                                <input type="text" id="param_sponser_id" class="form-control">
                                            </div>
                                            {{-- <span class="help-block"> This is inline help </span>--}}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">رقم الحالة</label>
                                            <div class="col-md-8">
                                                <input type="text" id="param_beneficiary_id" class="form-control">
                                            </div>
                                            {{-- <span class="help-block"> This is inline help </span>--}}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="col-md-3">
                                            <div class="btn-group">
                                                <button type="button" class="btn purple-plum" title="بحث"
                                                        onclick="reloadvisitTable()">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="btn-group">
                                                <button class="btn green-meadow button-excel2 " title="أكسل"
                                                        id="btn-excel">
                                                    <i class="fa fa-file-excel-o"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-3 ">
                                            <div class="btn-group">
                                                <button class="btn red " type="button" onclick="clearForm()"
                                                        title="مسح">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </form>
                    </div>

                </div>
                <div class="portlet light bordered">

                    <div class="portlet-body">
                        <table
                            class="table table-striped table-bordered table-hover table-checkable order-column "
                            id="report1_tbl">
                            <thead>
                            <tr>
                                <th width="2%">
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline"
                                           style="padding-right:10px">
                                        <input type="checkbox" class="group-checkable"
                                               data-set="#report1_tbl .checkboxes"/>
                                        <span></span>
                                    </label>
                                </th>
                                <th width="5%"> #</th>
                                <th width="25%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  الاســـــــــــــــم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                <th width="10%"> رقم الهوية</th>
                                <th width="10%"> النوع</th>
                                <th width="10%"> المدينة</th>
                                <th width="10%"> جوال</th>
                                <th width="10%"> تاريخ الزيارة</th>
                                <th width="10%"> نوع الزيارة</th>
                                <th width="10%"> توصيات <br/>الباحث</th>
                                <th width="10%"> حالة التقرير</th>
                                <th width="10%"> اسم الباحث</th>
                                <th width="10%"> رقم الكفالة</th>
                                <th width="5%">عرض التقارير</th>
                                <th width="5%">التحكم</th>
                            </tr>
                            </thead>
                        </table>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="btn-group">
                                    <button class="btn red " type="button" id="btn-delete"
                                            title="حذف الكل">
                                        <i class="fa fa-times"></i>حذف الكل
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-3">
                                <div class="col-md-3">

                                </div>
                                <div class="col-md-3">

                                </div>
                                <div class="col-md-3 ">

                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="portlet light bordered" style="display:none;">

                    <div class="portlet-body">
                        <table
                            class="table table-striped table-bordered table-hover table-checkable order-column"
                            id="excel_tbl">
                            <thead>
                            <tr>
                                <th width="5%"> #</th>
                                <th width="25%"> الاسم</th>
                                <th width="10%"> رقم الهوية</th>
                                <th width="10%"> الجنس</th>
                                <th width="10%">تاريخ الميلاد</th>
                                <th width="10%"> الحالة الإجتماعية</th>
                                <th width="10%"> نوع الحساب</th>
                                <th width="5%"> رقم الحالة</th>
                                <th width="25%"> رقم الكفالة</th>
                                <th width="10%"> تاريخ الزيارة</th>
                                <th width="10%"> نوع الزيارة</th>
                                <th width="10%">حالة التقرير</th>
                                <th width="10%"> اهداف الزيارة</th>
                                <th width="10%">تطورات صحية</th>
                                <th width="10%">تطورات تعليمية</th>
                                <th width="10%">تطورات اقتصادية</th>
                                <th width="10%">تطورات المسكن</th>
                                <th width="10%">تطورات اجتماعية</th>
                                <th width="10%">ملاحظات عامة</th>
                                <th width="10%">توصيات الباحث</th>
                                <th width="10%">سبب الغاء / إيقاف الكفالة</th>
                                <th width="10%"> الجنسية</th>
                                <th width="10%"> المحافظة</th>
                                <th width="10%"> المدينة</th>
                                <th width="10%">تفصيل العنوان</th>
                                <th width="10%"> جوال</th>
                                <th width="10%">جوال اخر</th>
                                <th width="10%">هاتف</th>
                                <th width="10%">الاقامة الحالية</th>
                                <th width="10%">اقرب مركز تحفيظ</th>
                                <th width="10%">اقرب جمعية</th>
                                <th width="10%">الوصي</th>
                                <th width="10%">رقم هوية الوصي</th>
                                <th width="10%">نوع العلاقة</th>
                                <th width="10%">اسم المدرسة</th>
                                <th width="10%">المرحلة الدراسية</th>
                                <th width="10%">الصف</th>
                                <th width="10%">نتيجة العام %</th>
                                <th width="10%">المستوى الحالي</th>
                                <th width="10%">المداومة على الصلاة</th>
                                <th width="10%">حفظ القران</th>
                                <th width="10%">عدد الأجزاء</th>
                                <th width="10%">عدد السور</th>
                                <th width="10%">مهارات ومواهب</th>
                                <th width="10%">الحالة الصحية</th>
                                <th width="10%">تفاصيل الحالة الصحية</th>
                                <th width="10%">تفاصيل الوضع الغذائي</th>
                                <th width="10%">تفاصيل الأنشطة الحالية</th>
                                <th width="10%">الجامعة/الكلية</th>
                                <th width="10%">التخصص الرئيسي</th>
                                <th width="10%">المستوى الدراسي</th>
                                <th width="10%">التقدير الحالي %</th>
                                <th width="10%">المستوى الحالي</th>
                                <th width="10%">نوع الاعاقة</th>
                                <th width="10%">تفصيل الاعاقة</th>
                                <th width="10%">تفاصيل السكن الحالي</th>
                                <th width="10%"> مساحة السكن</th>
                                <th width="10%"> ملكية السكن</th>
                                <th width="10%">احتياجات السكن</th>
                                <th width="5%"> احتياجات التطوير</th>
                                {{-- <th width="25%"> الاحتياج الحالي</th>
                                <th width="10%"> تفاصيل الاحتياج</th>
                                <th width="10%"> تكلفة الاحتياج</th>
                                <th width="10%">العملة</th>--}}
                                <th width="10%"> اسم المشروع المقترح</th>
                                <th width="10%"> وصف المشروع</th>
                                <th width="10%"> عوامل نجاح المشروع</th>
                                <th width="10%"> احتياجات اخرى</th>
                                <th width="10%">قصة نجاح</th>

                            </tr>
                            </thead>
                        </table>

                    </div>


                </div>
            </div>


        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>

    <div class="modal fade bs-modal-lg" id="yearlyVisitsModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true"></button>
                    <h4 class="modal-title">التقرير السنوي للحالة</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN SAMPLE TABLE PORTLET-->
                            <div class="portlet box green">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-print"></i>
                                    </div>
                                    <!-- <div class="tools">
                                         <a href="javascript:;" class="collapse"> </a>
                                         <a href="#portlet-config" data-toggle="modal"
                                            class="config"> </a>
                                         <a href="javascript:;" class="reload"> </a>
                                         <a href="javascript:;" class="remove"> </a>
                                     </div>-->
                                </div>

                                <div class="portlet-body form">

                                    {{Form::open(['url'=>url('print'),'class'=>'form-horizontal','method'=>"post","id"=>"print_form"])}}
                                    <div class="form-body">

                                        <input type="hidden" id="ben_id_hdn" name="ben_id_hdn" value="">
                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label col-md-5">محتوى التقرير</label>
                                                    <div class="col-md-7">
                                                        <select id="properties" class="form-control select2-multiple"
                                                                name="properties[]" multiple>


                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="btn-group">
                                                    <button class="btn red " type="button" onclick="clearForm()">
                                                        <i class="fa fa-remove"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="submit" id="btn_print"
                                                        class="btn btn-icon-only grey-cascade"><i
                                                        class="fa fa-print"></i></button>
                                            </div>

                                        </div>

                                    </div>
                                    {{Form::close()}}

                                </div>
                            </div>

                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">اغلاق
                    </button>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade bs-modal-lg" id="visitsModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true"></button>
                    <h4 class="modal-title">جدول الزيارات</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN SAMPLE TABLE PORTLET-->
                            <div class="portlet box green">
                                <div class="portlet-title">
                                    <div class="caption">محتوى التقرير
                                        <i class="fa fa-print"></i>
                                    </div>
                                    <!-- <div class="tools">
                                         <a href="javascript:;" class="collapse"> </a>
                                         <a href="#portlet-config" data-toggle="modal"
                                            class="config"> </a>
                                         <a href="javascript:;" class="reload"> </a>
                                         <a href="javascript:;" class="remove"> </a>
                                     </div>-->
                                </div>

                                <div class="portlet-body form">

                                    {{Form::open(['url'=>url('print'),'class'=>'form-horizontal','method'=>"post","id"=>"print_form"])}}
                                    <div class="form-body">

                                        <input type="hidden" id="ben_id_hdn" name="ben_id_hdn" value="">
                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label col-md-5">محتوى التقرير</label>
                                                    <div class="col-md-7">
                                                        <select id="properties" class="form-control select2-multiple"
                                                                name="properties[]" multiple>


                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="btn-group">
                                                    <button class="btn red " type="button" onclick="clearForm()">
                                                        <i class="fa fa-remove"></i>
                                                    </button>
                                                </div>
                                            </div>


                                        </div>

                                    </div>
                                    {{Form::close()}}

                                </div>
                            </div>
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">الزيارات
                                        <i class="fa fa-comments"></i>
                                    </div>
                                    <!-- <div class="tools">
                                         <a href="javascript:;" class="collapse"> </a>
                                         <a href="#portlet-config" data-toggle="modal"
                                            class="config"> </a>
                                         <a href="javascript:;" class="reload"> </a>
                                         <a href="javascript:;" class="remove"> </a>
                                     </div>-->
                                </div>

                                <div class="portlet-body">
                                    <div class="">
                                        <table class="table table-bordered table-hover" id="visits_tb">
                                            <thead>
                                            <tr>
                                                <th> #</th>
                                                <th> تاريخ</th>
                                                <th> الموظف</th>
                                                <th> نوع الزيارة</th>
                                                <th>تاريخ الاضافة</th>
                                                <th>تحكم</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- END SAMPLE TABLE PORTLET-->
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">اغلاق
                    </button>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="detailModal" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-full">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true"></button>
                    <h4 class="modal-title">تقرير الزيارة</h4>
                </div>

                <div class="modal-body">
                    <div class="scroller" style="height:400px" data-always-visible="1" data-rail-visible1="1">
                        <div class="row ">
                            <div class="col-md-12">
                                <div class="portlet light bordered">

                                    <div class="portlet-body">
                                        <div class="tabbable-custom ">
                                            <ul class="nav nav-tabs ">
                                                <li class="active" id="tab1">
                                                    <a href="#tab_1" data-toggle="tab">البيانات الشخصية </a>
                                                </li>

                                                <li id="schoolTab" style="display: none">
                                                    <a href="#tab_2" data-toggle="tab"> الحالة التعليمية </a>
                                                </li>
                                                <li id="religonTab" style="display: none">
                                                    <a href="#tab_3" data-toggle="tab">الحالة التربوية </a>
                                                </li>
                                                <li id="universityTab" style="display: none">
                                                    <a href="#tab_4" data-toggle="tab">بيانات الدراسة</a>
                                                </li>
                                                <li id="healthTab" style="display: none;">
                                                    <a href="#tab_5" data-toggle="tab">الحالة الصحية </a>
                                                </li>
                                                <li id="obstructionsTab" style="display:none;">
                                                    <a href="#tab_6" data-toggle="tab">تقرير الإعاقة </a>
                                                </li>
                                                <li>
                                                    <a href="#tab_7" data-toggle="tab"> بيانات السكن </a>
                                                </li>
                                                <li>
                                                    <a href="#tab_8" data-toggle="tab">احتياجات </a>
                                                </li>
                                                <li>
                                                    <a href="#tab_9" data-toggle="tab">مشروع مقترح </a>
                                                </li>
                                                <li>
                                                    <a href="#tab_staticalCard" data-toggle="tab">البطاقة الإحصائية</a>
                                                </li>
                                                <li>
                                                    <a href="#tab_10" data-toggle="tab">تقرير الزيارة </a>
                                                </li>
                                                <li>
                                                    <a href="#tab_11" data-toggle="tab">مرفقات</a>
                                                </li>
                                                <li>
                                                    <a href="#tab_reportStatus" data-toggle="tab">حالة التقرير</a>
                                                </li>

                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tab_1">

                                                    <div class="portlet light ">

                                                        <div class="portlet-body form">
                                                            <!-- BEGIN FORM-->
                                                            <form action="#" class="horizontal-form">
                                                                <div class="form-body">
                                                                    <!--  <h3 class="form-section">البيانات الشخصية</h3>-->
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    class="control-label">الاسم</label>
                                                                                <input type="text" id="full_name"
                                                                                       class="form-control"
                                                                                       placeholder=""
                                                                                       value="{{isset($one_profile->full_name)}}"
                                                                                       disabled>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <!--/span-->
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">رقم
                                                                                    الهوية</label>
                                                                                <input type="text"
                                                                                       id="beneficiary_identity"
                                                                                       value=""
                                                                                       class="form-control"
                                                                                       placeholder="" disabled>
                                                                                {{--  <span class="help-block"> This field has error. </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">تاريخ
                                                                                    الميلاد
                                                                                </label>
                                                                                <input type="text" id="birth_date"
                                                                                       value=""
                                                                                       class="form-control"
                                                                                       placeholder="" disabled>
                                                                                {{--  <span class="help-block"> This field has error. </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    class="control-label">الجنس</label>
                                                                                <input type="text" id="gender"
                                                                                       class="form-control"
                                                                                       placeholder=""
                                                                                       value="" disabled>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <!--/span-->
                                                                    </div>
                                                                    <!--/row-->
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">الحالة
                                                                                    الإجتماعية
                                                                                </label>
                                                                                <input type="text" id="marital_status"
                                                                                       value=""
                                                                                       class="form-control"
                                                                                       disabled>
                                                                                {{--  <span class="help-block"> This field has error. </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    class="control-label">الجنسية </label>
                                                                                <input type="text" id="nationality"
                                                                                       class="form-control"
                                                                                       placeholder=""
                                                                                       value="" disabled>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">نوع
                                                                                    التقرير</label>
                                                                                <input type="text" id="txtaccount_type"
                                                                                       class="form-control"
                                                                                       placeholder=""
                                                                                       value="" disabled>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <!--/span-->
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">رقم
                                                                                    الحالة</label>
                                                                                <input type="text" id="beneficiary_id"
                                                                                       value=""
                                                                                       class="form-control"
                                                                                       disabled>
                                                                                {{--  <span class="help-block"> This field has error. </span>--}}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">رقم
                                                                                    الكفالة</label>
                                                                                <input type="text" id="sponser_id"
                                                                                       class="form-control"
                                                                                       placeholder=""
                                                                                       value="" disabled>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <!--/span-->
                                                                    </div>

                                                                    <!--/row-->
                                                                    <h3 class="form-section">العنوان</h3>
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    class="control-label">المحافظة</label>
                                                                                <input type="text" id="governorate"
                                                                                       class="form-control"
                                                                                       placeholder=""
                                                                                       value="" disabled>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <!--/span-->
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">المدينة
                                                                                </label>
                                                                                <input type="text" id="city"
                                                                                       value=""
                                                                                       class="form-control"
                                                                                       disabled>
                                                                                {{--  <span class="help-block"> This field has error. </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">الحي
                                                                                </label>
                                                                                <input type="text" id="neighborhood"
                                                                                       value=""
                                                                                       class="form-control"
                                                                                       disabled>
                                                                                {{--  <span class="help-block"> This field has error. </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">تفصيل
                                                                                    العنوان </label>
                                                                                <input type="text" id="full_address"
                                                                                       class="form-control"
                                                                                       placeholder=""
                                                                                       value="" disabled>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">اخط العرض</label>
                                                                                <input type="text" id="latitude"
                                                                                       class="form-control"
                                                                                       placeholder=""
                                                                                       value="" >
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">
                                                                                    خط الطول</label>
                                                                                <input type="text"
                                                                                       id="longitude"
                                                                                       class="form-control"
                                                                                       placeholder=""
                                                                                       value="" >
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">اقرب مركز
                                                                                    تحفيظ</label>
                                                                                <input type="text" id="nearist_quran"
                                                                                       class="form-control"
                                                                                       placeholder=""
                                                                                       value="" disabled>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">اقرب
                                                                                    جمعية</label>
                                                                                <input type="text"
                                                                                       id="nearist_institute"
                                                                                       class="form-control"
                                                                                       placeholder=""
                                                                                       value="" disabled>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <!--/span-->
                                                                    </div>


                                                                    <h3 class="form-section">بيانات الإتصال</h3>
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">موبايل
                                                                                    1</label>
                                                                                <input type="text" id="mobile_no"
                                                                                       class="form-control"
                                                                                       placeholder=""
                                                                                       value="" disabled>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <!--/span-->
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">موبايل 2
                                                                                </label>
                                                                                <input type="text" id="mobile_no1"
                                                                                       value=""
                                                                                       class="form-control"
                                                                                       disabled>
                                                                                {{--  <span class="help-block"> This field has error. </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    class="control-label">هاتف </label>
                                                                                <input type="text" id="phone"
                                                                                       class="form-control"
                                                                                       placeholder=""
                                                                                       value="" disabled>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <!--/span-->
                                                                    </div>
                                                                    <div id="guardianDv">
                                                                        <h3 class="form-section"> بيانات الوصي</h3>
                                                                        <div class="row">
                                                                            <div class="col-md-2">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        class="control-label">الوصي</label>
                                                                                    <input type="text" id="guardian"
                                                                                           class="form-control"
                                                                                           placeholder=""
                                                                                           value="" disabled>
                                                                                </div>
                                                                            </div>
                                                                            <!--/span-->
                                                                            <div class="col-md-2">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">رقم
                                                                                        هوية
                                                                                        الوصي </label>
                                                                                    <input type="text"
                                                                                           id="guardian_identity"
                                                                                           class="form-control"
                                                                                           placeholder=""
                                                                                           value="" disabled>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">نوع
                                                                                        العلاقة
                                                                                    </label>
                                                                                    <input type="text"
                                                                                           id="guardian_relation"
                                                                                           class="form-control"
                                                                                           placeholder=""
                                                                                           value="" disabled>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">
                                                                                        تاريخ انتهاء البطاق
                                                                                    </label>
                                                                                    <input type="text"
                                                                                           id="card_date_expired"
                                                                                           class="form-control"
                                                                                           placeholder=""
                                                                                           value="" disabled>
                                                                                </div>
                                                                            </div>
                                                                            <!--/span-->
                                                                            <div class="col-md-2">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">
                                                                                        تاريخ انتهاء الوصاية
                                                                                    </label>
                                                                                    <input type="text"
                                                                                           id="guardianship_date_expired"
                                                                                           class="form-control"
                                                                                           placeholder=""
                                                                                           value="" disabled>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-2">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        class="control-label">جوال</label>
                                                                                    <input type="text" id="guardian_mobile1"
                                                                                           class="form-control"
                                                                                           placeholder=""
                                                                                           value="" disabled>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        class="control-label">جوال
                                                                                        طوارئ</label>
                                                                                    <input type="text"
                                                                                           id="guardian_mobile2"
                                                                                           class="form-control"
                                                                                           placeholder=""
                                                                                           value="" disabled>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">المحافظة
                                                                                    </label>
                                                                                    <input type="text"
                                                                                           id="guardian_district"
                                                                                           class="form-control"
                                                                                           placeholder=""
                                                                                           value="" disabled>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">المدينة
                                                                                    </label>
                                                                                    <input type="text"
                                                                                           id="guardian_city"
                                                                                           class="form-control"
                                                                                           placeholder=""
                                                                                           value="" disabled>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">الحي
                                                                                    </label>
                                                                                    <input type="text"
                                                                                           id="guardian_neighborhood"
                                                                                           class="form-control"
                                                                                           placeholder=""
                                                                                           value="" disabled>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">العنوان
                                                                                    </label>
                                                                                    <input type="text"
                                                                                           id="full_address"
                                                                                           class="form-control"
                                                                                           placeholder=""
                                                                                           value="" disabled>
                                                                                </div>
                                                                            </div>
                                                                            <!--/span-->
                                                                        </div>
                                                                        <h3 class="form-section"> بيانات المعيل</h3>
                                                                        <div class="row">
                                                                            <div class="col-md-2">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        class="control-label">المعيل</label>
                                                                                    <input type="text"
                                                                                           id="supporter_name"
                                                                                           class="form-control"
                                                                                           placeholder=""
                                                                                           value="" disabled>
                                                                                </div>
                                                                            </div>
                                                                            <!--/span-->
                                                                            <div class="col-md-2">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">رقم
                                                                                        هوية
                                                                                        المعيل </label>
                                                                                    <input type="text"
                                                                                           id="supporter_identity"
                                                                                           class="form-control"
                                                                                           placeholder=""
                                                                                           value="" disabled>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">نوع
                                                                                        العلاقة
                                                                                    </label>
                                                                                    <input type="text"
                                                                                           id="supporter_relationship"
                                                                                           class="form-control"
                                                                                           placeholder=""
                                                                                           value="" disabled>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            <!-- END FORM-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane " id="tab_2">

                                                    <div class="portlet light ">

                                                        <div class="portlet-body form">
                                                            <!-- BEGIN FORM-->
                                                            <form action="#" class="horizontal-form">
                                                                <div class="form-body">
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">اسم
                                                                                    المدرسة</label>
                                                                                <input type="text" id="school_name"
                                                                                       class="form-control"
                                                                                       placeholder=""
                                                                                       value=""
                                                                                       disabled>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <!--/span-->
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">المرحلة
                                                                                    الدراسية</label>
                                                                                <input type="text" id="study_level"
                                                                                       value=""
                                                                                       class="form-control"
                                                                                       placeholder="" disabled>
                                                                                {{--  <span class="help-block"> This field has error. </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">الصف
                                                                                </label>
                                                                                <input type="text" id="study_class"
                                                                                       value=""
                                                                                       class="form-control"
                                                                                       placeholder="" disabled>
                                                                                {{--  <span class="help-block"> This field has error. </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">نتيجة العام
                                                                                    %
                                                                                </label>
                                                                                <input type="text" id="current_avg"
                                                                                       class="form-control"
                                                                                       placeholder=""
                                                                                       value="" disabled>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <!--/span-->
                                                                    </div>
                                                                    <!--/row-->
                                                                    <div class="row">

                                                                        <!--/span-->
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">المستوى
                                                                                </label>
                                                                                <input type="text" id="currentlevel"
                                                                                       value=""
                                                                                       class="form-control"
                                                                                       disabled>
                                                                                {{--  <span class="help-block"> This field has error. </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">

                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <!--/span-->
                                                                    </div>
                                                                    <!--/row-->

                                                                </div>
                                                                {{-- <div class="form-actions left">
                                                                    <button type="button" class="btn default">Cancel</button>
                                                                    <button type="submit" class="btn blue">
                                                                        <i class="fa fa-check"></i> Save</button>
                                                                </div>--}}
                                                            </form>
                                                            <!-- END FORM-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane " id="tab_3">

                                                    <div class="portlet light ">

                                                        <div class="portlet-body form">
                                                            <!-- BEGIN FORM-->
                                                            <form action="#" class="horizontal-form">
                                                                <div class="form-body">
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">المداومة
                                                                                    على
                                                                                    الصلاة</label>
                                                                                <input type="text" id="praying"
                                                                                       class="form-control"
                                                                                       placeholder=""
                                                                                       value=""
                                                                                       disabled>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <!--/span-->
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">حفظ
                                                                                    القران</label>
                                                                                <input type="text" id="memorizes_quran"
                                                                                       value=""
                                                                                       class="form-control"
                                                                                       placeholder="" disabled>
                                                                                {{--  <span class="help-block"> This field has error. </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">عدد الأجزاء
                                                                                </label>
                                                                                <input type="text" id="parts_no"
                                                                                       value=""
                                                                                       class="form-control"
                                                                                       placeholder="" disabled>
                                                                                {{--  <span class="help-block"> This field has error. </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">عدد السور
                                                                                </label>
                                                                                <input type="text" id="sura_no"
                                                                                       class="form-control"
                                                                                       placeholder=""
                                                                                       value="" disabled>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <!--/span-->
                                                                    </div>
                                                                    <!--/row-->
                                                                    <div class="row">

                                                                        <!--/span-->
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">مهارات
                                                                                    ومواهب
                                                                                </label>
                                                                                <input type="text" id="skills"
                                                                                       value=""
                                                                                       class="form-control"
                                                                                       disabled>
                                                                                {{--  <span class="help-block"> This field has error. </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">

                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <!--/span-->
                                                                    </div>
                                                                    <!--/row-->

                                                                </div>
                                                                {{-- <div class="form-actions left">
                                                                    <button type="button" class="btn default">Cancel</button>
                                                                    <button type="submit" class="btn blue">
                                                                        <i class="fa fa-check"></i> Save</button>
                                                                </div>--}}
                                                            </form>
                                                            <!-- END FORM-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane " id="tab_4">

                                                    <div class="portlet light ">

                                                        <div class="portlet-body form">
                                                            <!-- BEGIN FORM-->
                                                            <form action="#" class="horizontal-form">
                                                                <div class="form-body">
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">الجامعة/الكلية
                                                                                </label>
                                                                                <input type="text" id="university_name"
                                                                                       class="form-control"
                                                                                       placeholder=""
                                                                                       value=""
                                                                                       disabled>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <!--/span-->
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">المستوى
                                                                                    الدراسي
                                                                                </label>
                                                                                <input type="text"
                                                                                       id="university_level"
                                                                                       value=""
                                                                                       class="form-control"
                                                                                       placeholder="" disabled>
                                                                                {{--  <span class="help-block"> This field has error. </span>--}}
                                                                            </div>
                                                                        </div>


                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">التخصص
                                                                                    الرئيسي</label>
                                                                                <input type="text" id="university_major"
                                                                                       class="form-control"
                                                                                       placeholder=""
                                                                                       value="" disabled>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <!--/span-->
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">التقدير
                                                                                    الحالي</label>
                                                                                <input type="text"
                                                                                       id="university_current_avg"
                                                                                       value=""
                                                                                       class="form-control"
                                                                                       disabled>
                                                                                {{--  <span class="help-block"> This field has error. </span>--}}
                                                                            </div>
                                                                        </div>

                                                                        <!--/span-->
                                                                    </div>
                                                                    <!--/row-->
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">المستوى
                                                                                    الحالي</label>
                                                                                <input type="text" id="current_level"
                                                                                       class="form-control"
                                                                                       placeholder=""
                                                                                       value="" disabled>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <!--/span-->

                                                                        <!--/span-->
                                                                    </div>
                                                                </div>
                                                                {{-- <div class="form-actions left">
                                                                    <button type="button" class="btn default">Cancel</button>
                                                                    <button type="submit" class="btn blue">
                                                                        <i class="fa fa-check"></i> Save</button>
                                                                </div>--}}
                                                            </form>
                                                            <!-- END FORM-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane " id="tab_5">

                                                    <div class="portlet light ">

                                                        <div class="portlet-body form">
                                                            <!-- BEGIN FORM-->
                                                            <form action="#" class="horizontal-form">
                                                                <div class="form-body">
                                                                    <div class="row">

                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">الحالة
                                                                                    الصحية</label>
                                                                                <input type="text"
                                                                                       id="health_status"
                                                                                       value=""
                                                                                       class="form-control"
                                                                                       placeholder="" disabled>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">تفاصيل
                                                                                    الحالة
                                                                                    الصحية</label>
                                                                                <textarea type="text"
                                                                                          id="health_status_details"
                                                                                          class="form-control"
                                                                                          placeholder=""
                                                                                          disabled></textarea>
                                                                                {{--  <span class="help-block"> This field has error. </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">تفاصيل
                                                                                    الوضع
                                                                                    الغذائي
                                                                                </label>
                                                                                <textarea type="text" id="food_details"
                                                                                          class="form-control"
                                                                                          placeholder=""
                                                                                          disabled></textarea>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <!--/span-->
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">تفاصيل
                                                                                    الأنشطة
                                                                                    الحالية
                                                                                </label>
                                                                                <textarea type="text"
                                                                                          id="workout_details"
                                                                                          class="form-control"
                                                                                          placeholder=""
                                                                                          disabled></textarea>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <!--/row-->

                                                                </div>
                                                                {{-- <div class="form-actions left">
                                                                    <button type="button" class="btn default">Cancel</button>
                                                                    <button type="submit" class="btn blue">
                                                                        <i class="fa fa-check"></i> Save</button>
                                                                </div>--}}
                                                            </form>
                                                            <!-- END FORM-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane " id="tab_6">

                                                    <div class="portlet light ">

                                                        <div class="portlet-body form">
                                                            <!-- BEGIN FORM-->
                                                            <form action="#" class="horizontal-form">
                                                                <div class="form-body">
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">نوع
                                                                                    الاعاقة</label>
                                                                                <input type="text" id="obstruction_type"
                                                                                       class="form-control"
                                                                                       placeholder=""
                                                                                       value=""
                                                                                       disabled>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <!--/span-->
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">تفصيل
                                                                                    الاعاقة
                                                                                </label>
                                                                                <textarea type="text"
                                                                                          id="obstruction_details"
                                                                                          class="form-control"
                                                                                          placeholder=""
                                                                                          disabled></textarea>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <!--/row-->

                                                                </div>
                                                                {{-- <div class="form-actions left">
                                                                    <button type="button" class="btn default">Cancel</button>
                                                                    <button type="submit" class="btn blue">
                                                                        <i class="fa fa-check"></i> Save</button>
                                                                </div>--}}
                                                            </form>
                                                            <!-- END FORM-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane " id="tab_7">

                                                    <div class="portlet light ">

                                                        <div class="portlet-body form">
                                                            <!-- BEGIN FORM-->
                                                            <form action="#" class="horizontal-form">
                                                                <div class="form-body">
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">تفاصيل
                                                                                    السكن
                                                                                    الحالي
                                                                                </label>
                                                                                <textarea type="text" id="live_details"
                                                                                          class="form-control"
                                                                                          placeholder=""
                                                                                          disabled></textarea>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>

                                                                        <!--/span-->
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">مساحة السكن
                                                                                </label>
                                                                                <input type="text"
                                                                                       id="live_area"
                                                                                       value=""
                                                                                       class="form-control"
                                                                                       placeholder="" disabled>
                                                                                {{--  <span class="help-block"> This field has error. </span>--}}
                                                                            </div>
                                                                        </div>

                                                                        <!--/span-->

                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">ملكية
                                                                                    السكن</label>
                                                                                <input type="text" id="live_type"
                                                                                       class="form-control"
                                                                                       placeholder=""
                                                                                       value="" disabled>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <!--/span-->

                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">احتياجات
                                                                                    السكن</label>
                                                                                <input type="text" id="live_needs"
                                                                                       value=""
                                                                                       class="form-control"
                                                                                       disabled>
                                                                                {{--  <span class="help-block"> This field has error. </span>--}}
                                                                            </div>
                                                                        </div>

                                                                        <!--/span-->
                                                                    </div>
                                                                    <!--/row-->
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">احتياجات
                                                                                    التطوير</label>
                                                                                <input type="text"
                                                                                       id="development_needs"
                                                                                       class="form-control"
                                                                                       placeholder=""
                                                                                       value="" disabled>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <!--/span-->
                                                                        <div class="col-md-6">

                                                                        </div>

                                                                        <!--/span-->
                                                                    </div>
                                                                </div>
                                                                {{-- <div class="form-actions left">
                                                                    <button type="button" class="btn default">Cancel</button>
                                                                    <button type="submit" class="btn blue">
                                                                        <i class="fa fa-check"></i> Save</button>
                                                                </div>--}}
                                                            </form>
                                                            <!-- END FORM-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane " id="tab_8">

                                                    <div class="portlet light ">

                                                        <div class="portlet-body form">
                                                            <!-- BEGIN FORM-->
                                                            <div class="row">
                                                                <div class="table-scrollable">
                                                                    <table
                                                                        class="table table-striped table-bordered table-advance table-hover ">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>الاحتياج الحالي</th>
                                                                            <th>تكلفة الاحتياج</th>
                                                                            <th> العملة</th>
                                                                            <th>تفصيل الاحتياج</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody id="OrphanNeedDv">

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <!-- END FORM-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane " id="tab_9">

                                                    <div class="portlet light ">

                                                        <div class="portlet-body form">
                                                            <!-- BEGIN FORM-->
                                                            <form action="#" class="horizontal-form">
                                                                <div class="form-body">
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">اسم المشروع
                                                                                    المقترح</label>
                                                                                <input type="text" id="project_name"
                                                                                       class="form-control"
                                                                                       placeholder=""
                                                                                       value=""
                                                                                       disabled>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <!--/span-->
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">وصف
                                                                                    المشروع</label>
                                                                                <textarea type="text"
                                                                                          id="project_details"
                                                                                          class="form-control"
                                                                                          placeholder=""
                                                                                          disabled></textarea>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">عوامل نجاح
                                                                                    المشروع</label>
                                                                                <textarea type="text"
                                                                                          id="success_indecation"
                                                                                          class="form-control"
                                                                                          placeholder=""
                                                                                          disabled></textarea>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>

                                                                        <!--/span-->

                                                                        <!--/span-->
                                                                    </div>
                                                                    <!--/row-->

                                                                </div>
                                                                {{-- <div class="form-actions left">
                                                                    <button type="button" class="btn default">Cancel</button>
                                                                    <button type="submit" class="btn blue">
                                                                        <i class="fa fa-check"></i> Save</button>
                                                                </div>--}}
                                                            </form>
                                                            <!-- END FORM-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane " id="tab_staticalCard">
                                                    <div class="portlet light ">
                                                        <div class="portlet-body ">
                                                            <div class="row">
                                                                <div class="table-scrollable">
                                                                    <table
                                                                        class="table table-striped table-bordered table-advance table-hover ">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>تصنيف الاحتياج</th>
                                                                            <th>نوع الاحتياج</th>
                                                                            <th>مخرج الاحتياج</th>
                                                                            {{--<th> قصة نجاح</th>--}}
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody id="staticalCard_tb">

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">احتياجات اخرى
                                                                        </label>
                                                                        <textarea type="text"
                                                                                  id="need_details"
                                                                                  class="form-control"
                                                                                  placeholder=""
                                                                                  disabled></textarea>
                                                                        {{-- <span class="help-block"> This is inline help </span>--}}
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">قصة نجاح
                                                                        </label>
                                                                        <textarea type="text"
                                                                                  id="story_details"
                                                                                  class="form-control"
                                                                                  placeholder=""
                                                                                  disabled></textarea>
                                                                        {{-- <span class="help-block"> This is inline help </span>--}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                                <div class="tab-pane " id="tab_10">

                                                    <div class="portlet light ">

                                                        <div class="portlet-body form">
                                                            <!-- BEGIN FORM-->
                                                            <form action="#" class="horizontal-form">
                                                                <div class="form-body">
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">اهداف
                                                                                    الزيارة</label>
                                                                                <textarea type="text" id="visitor_goals"
                                                                                          class="form-control"
                                                                                          placeholder=""
                                                                                          disabled></textarea>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <!--/span-->
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">تطورات
                                                                                    صحية </label>
                                                                                <textarea type="text"
                                                                                          id="health_updates"
                                                                                          class="form-control"
                                                                                          placeholder=""
                                                                                          disabled></textarea>
                                                                                {{--  <span class="help-block"> This field has error. </span>--}}
                                                                            </div>
                                                                        </div>


                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">تطورات
                                                                                    تعليمية</label>
                                                                                <textarea type="text"
                                                                                          id="educational_updates"
                                                                                          class="form-control"
                                                                                          placeholder=""
                                                                                          disabled></textarea>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <!--/span-->
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">تطورات
                                                                                    اقتصادية </label>
                                                                                <textarea type="text"
                                                                                          id="economical_updates"
                                                                                          class="form-control"
                                                                                          placeholder=""
                                                                                          disabled></textarea>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>


                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">تطورات
                                                                                    اجتماعية</label>
                                                                                <textarea type="text"
                                                                                          id="social_updates"
                                                                                          class="form-control"
                                                                                          placeholder=""
                                                                                          disabled></textarea>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">تطورات
                                                                                    المسكن</label>
                                                                                <textarea type="text"
                                                                                          id="living_updates"
                                                                                          class="form-control"
                                                                                          placeholder=""
                                                                                          disabled></textarea>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">ملاحظات
                                                                                    عامة
                                                                                </label>
                                                                                <textarea type="text"
                                                                                          id="general_note"
                                                                                          class="form-control"
                                                                                          placeholder=""
                                                                                          disabled></textarea>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <!--/span-->
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">توصيات
                                                                                    الباحث</label>
                                                                                <textarea type="text"
                                                                                          id="visitor_recommend"
                                                                                          class="form-control"
                                                                                          placeholder=""
                                                                                          disabled></textarea>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>

                                                                        <!--/span-->

                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">سبب الغاء /
                                                                                    إيقاف الكفالة</label>
                                                                                <textarea type="text"
                                                                                          id="visitor_stop_resone"
                                                                                          class="form-control"
                                                                                          placeholder=""
                                                                                          disabled></textarea>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>

                                                                        <!--/span-->
                                                                    </div>
                                                                </div>
                                                                {{-- <div class="form-actions left">
                                                                    <button type="button" class="btn default">Cancel</button>
                                                                    <button type="submit" class="btn blue">
                                                                        <i class="fa fa-check"></i> Save</button>
                                                                </div>--}}
                                                            </form>
                                                            <!-- END FORM-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane " id="tab_11">

                                                    <!-- The four columns -->
                                                    <div id="img_content">
                                                        {{--<div class="row">
                                                            <div class="column">
                                                                <img src = "{{url("public/storage/reports/nZIhNNrXSJ.jpeg")}}" alt="Nature" style="width:100%"
                                                                onclick="myFunction(this);">
                                                            </div>
                                                            <div class="column">
                                                                <img src="img_snow.jpg" alt="Snow" style="width:100%"
                                                                     onclick="myFunction(this);">
                                                            </div>
                                                            <div class="column">
                                                                <img src="img_mountains.jpg" alt="Mountains" style="width:100%"
                                                                     onclick="myFunction(this);">
                                                            </div>
                                                            <div class="column">
                                                                <img src="img_lights.jpg" alt="Lights" style="width:100%"
                                                                     onclick="myFunction(this);">
                                                            </div>
                                                        </div>--}}
                                                    </div>
                                                    <div class="container">
                                                    <span onclick="this.parentElement.style.display='none'"
                                                          class="closebtn">&times;</span>
                                                        <img id="expandedImg" style="width:100%">
                                                        <div id="imgtext"></div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane " id="tab_reportStatus">

                                                    <div class="portlet light ">

                                                        <div class="portlet-body form">
                                                            <!-- BEGIN FORM-->
                                                            <form action="#" class="horizontal-form">
                                                                <div
                                                                    class="alert alert-danger alert-danger-report_status  display-hide">
                                                                    <button class="close" data-close="alert"></button>
                                                                    يرجى التأكد من القيم المدخلة
                                                                </div>
                                                                <div
                                                                    class="alert alert-success alert-success-report_status display-hide">
                                                                    <button class="close" data-close="alert"></button>
                                                                    تمت العملية بنجاح
                                                                </div>
                                                                <div class="form-body">
                                                                    <input type="hidden" id="referance_key"
                                                                           value="{{''}}"
                                                                           name="referance_key">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label col-md-4">حالة
                                                                                    التقرير</label>
                                                                                <div class="col-md-8 ">
                                                                                    <select id="report_status"
                                                                                            class="form-control select2"
                                                                                            name="report_status">
                                                                                        <option value="">اختر..ر
                                                                                        </option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!--/span-->
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label col-md-4">سبب
                                                                                    الرفض
                                                                                </label>
                                                                                <div class="col-md-8">
                                                                                    <input type="text"
                                                                                           id="reject_reason"
                                                                                           value=""
                                                                                           class="form-control"
                                                                                           placeholder="">
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <button type="button" class="btn blue"
                                                                                    onclick="save_report_status();">
                                                                                <i class="fa fa-check"></i> حفظ
                                                                            </button>
                                                                        </div>
                                                                        <!--/span-->
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="table-scrollable">
                                                                            <table
                                                                                class="table tabbable-bordered table-hover ">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th>#</th>
                                                                                    <th>الحالة</th>
                                                                                    <th>المستخدم</th>
                                                                                    <th>تاريخ الحالة</th>
                                                                                    <th>سبب الرفض</th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody id="report_status_tb">

                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <!--/row-->
                                                                </div>
                                                                {{-- <div class="form-actions left">
                                                                    <button type="button" class="btn blue"
                                                                            onclick="save_report_status();">
                                                                        <i class="fa fa-check"></i> Save
                                                                    </button>
                                                                </div>--}}
                                                            </form>
                                                            <!-- END FORM-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">اغلاق
                    </button>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade bs-modal-lg" id="ben-map" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true"></button>
                    <h4 class="modal-title">عرض بيانات الموقع </h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN SAMPLE TABLE PORTLET-->
                            <div class="portlet box green-haze">
                                <div class="portlet-title">
                                    <div class="caption ">
                                        <i class="fa fa-briefcase"></i>موقع المستفيد على الخريطة
                                    </div>
                                </div>

                                <div class="portlet-body form">


                                    <div id="map" style="width:100%;height:810px;"></div>

                                </div>

                            </div>
                            <!-- END SAMPLE TABLE PORTLET-->
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">اغلاق
                    </button>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    @push('css')
        <link href="{{url('')}}/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet"
              type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet"
              type="text/css"/>
        <style>
            .datepicker {
                width: 15%;

            }

            .select2 {
                font-size: 12px;
                height: 37px;
            }

            .dt-buttons {
                display: none;
            }

            /* The grid: Four equal columns that floats next to each other */
            .column {
                float: left;
                width: 25%;
                padding: 10px;
            }

            /* Style the images inside the grid */
            .column img {
                opacity: 0.8;
                cursor: pointer;
            }

            .column img:hover {
                opacity: 1;
            }

            /* Clear floats after the columns */
            .row:after {
                content: "";
                display: table;
                clear: both;
            }

            /* The expanding image container (positioning is needed to position the close button and the text) */
            .container {
                position: relative;
                display: none;
            }

            /* Expanding image text */
            #imgtext {
                position: absolute;
                bottom: 15px;
                left: 15px;
                color: white;
                font-size: 20px;
            }

            /* Closable button inside the image */
            .closebtn {
                position: absolute;
                top: 10px;
                right: 15px;
                color: white;
                font-size: 35px;
                cursor: pointer;
            }
        </style>
        <link href="{{url('')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css"
              rel="stylesheet" type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"
              rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
              integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
              crossorigin=""/>
    @endpush
    @push('js')
        <script src="{{url('')}}/assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/pages/scripts/components-date-time-pickers.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/select2/js/select2.full.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/pages/scripts/components-select2.js"
                type="text/javascript"></script>
        <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
                integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
                crossorigin=""></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <script>
            $(document).ready(function () {
                reloadvisitTable();
                $('.buttons-excel').addClass('hidden');
                /* $('.button-excel2').click(function () {
                     $('.buttons-excel').click()
                 });*/
            })

            function getVisits($id) {
                $('#banf_id_hdn').val();
                $('#banf_id_hdn').val($id);
                reloadDetailTable($id)

            }

            function reloadDetailTable(id) {
                $('#ben_id_hdn').val('');
                $('#ben_id_hdn').val(id);
                //alert(id)

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                $('#visits_tb').DataTable().destroy();
                $.fn.dataTable.ext.errMode = 'none';
                $('#visits_tb').on('error.dt', function (e, settings, techNote, message) {
                    console.log('An error has been reported by DataTables: ', message);
                })

                $('#visits_tb').dataTable({

                    'processing': true,
                    'serverSide': true,
                    'ajax': {
                        "type": "post",
                        "url": '{{url('/visits-data')}}',//"s2-details-data",

                        "data": {
                            'id': id
                        }
                        ,

                    },


                    'columns': [

                        {data: 'id', name: 'id'},
                        {data: 'visit_date', name: 'visit_date'},
                        {data: 'user_name', name: 'user_name'},
                        {data: 'visit_name', name: 'visit_name'},
                        {data: 'visit_date', name: 'visit_date'},
                        {data: 'action', name: 'action'},


                    ],
                    "language": {
                        "aria": {
                            "sortAscending": ": activate to sort column ascending",
                            "sortDescending": ": activate to sort column descending"
                        },
                        "emptyTable": "لايوجد بيانات في الجدول للعرض",
                        "info": "عرض _START_ الى  _END_ من _TOTAL_ سجلات",
                        "infoEmpty": "No records found",
                        "infoFiltered": "(filtered1 from _MAX_ total records)",
                        "lengthMenu": "عرض _MENU_",
                        "search": "بحث:",
                        "zeroRecords": "No matching records found",
                        "paginate": {
                            "previous": "Prev",
                            "next": "Next",
                            "last": "Last",
                            "first": "First"
                        }
                    },

                })


            }

            function reloadvisitTable() {
                var name = $('#name').val();
                var ben_id = $('#ben_id').val();
                var visit_type = $('#visit_type').val();
                var account_type = $('#account_type').val();
                var visit_by = $('#visit_by').val();
                var fromdate = $('#fromdate').val();
                var todate = $('#todate').val();
                var district_id = $('#district_id').val();
                var VisitorRecommend = $('#VisitorRecommend').val();
                var sponser_id = $('#param_sponser_id').val();
                var beneficiary_id = $('#param_beneficiary_id').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                $('#report1_tbl').DataTable().destroy();
                $.fn.dataTable.ext.errMode = 'none';
                $('#report1_tbl').on('error.dt', function (e, settings, techNote, message) {
                    console.log('An error has been reported by DataTables: ', message);
                })

                $('#report1_tbl').dataTable({

                    'processing': true,
                    'serverSide': true,
                    'ajax': {
                        "type": "post",
                        "url": '{{url('/filterVisits-data')}}',//"s2-details-data",

                        "data": {
                            'ben_id': ben_id,
                            'name': name,
                            'visit_by': visit_by,
                            'account_type': account_type,
                            'visit_type': visit_type,
                            'fromdate': fromdate,
                            'todate': todate,
                            'district_id': district_id,
                            'sponser_id': sponser_id,
                            'VisitorRecommend': VisitorRecommend,
                            'beneficiary_id': beneficiary_id
                        }
                        ,

                    },


                    'columns': [

                        {data: 'delChk', name: 'delChk', width: '5%'},
                        {data: 'num', name: 'num', width: '5%'},
                        {data: 'full_name', name: 'full_name', width: '20%', orderable: true},
                        {data: 'beneficiary_identity', name: 'beneficiary_identity', width: '10%', orderable: true},
                        {data: 'account_name', name: 'account_name', width: '10%'},
                        {data: 'city_name', name: 'city_name', width: '10%', orderable: true},
                        {data: 'mobile_no', name: 'mobile_no', width: '10%', orderable: true},
                        {data: 'visit_date', name: 'references_list.visit_date', width: '10%'},
                        {data: 'visit_name', name: 'visit_name', width: '10%'},
                        {data: 'VisitorRecommend', name: 'VisitorRecommend', width: '10%', orderable: true},
                        {data: 'report_status', name: 'report_status', width: '10%', orderable: true},
                        {data: 'user_name', name: 'user_name', width: '10%', orderable: true},
                        {data: 'sponser_id', name: 'sponser_id', width: '10%', orderable: true},


                        {data: 'control', name: 'control', width: '5%'},
                        {data: 'action', name: 'action', width: '5%'},

                    ],
                    aoColumnDefs: [
                        {bSortable: false, aTargets: ["_all"]}
                    ],
                    buttons: [
                        {
                            extend: 'pdf',
                            className: 'btn yellow btn-outline ',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                            }
                        }

                    ],
                    "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable

                    "language": {
                        "aria": {
                            "sortAscending": ": activate to sort column ascending",
                            "sortDescending": ": activate to sort column descending"
                        },
                        "emptyTable": "لايوجد بيانات في الجدول للعرض",
                        "info": "عرض _START_ الى  _END_ من _TOTAL_ سجلات",
                        "infoEmpty": "No records found",
                        "infoFiltered": "(filtered1 from _MAX_ total records)",
                        "lengthMenu": "عرض _MENU_",
                        "search": "بحث:",
                        "zeroRecords": "No matching records found",
                        "paginate": {
                            "previous": "Prev",
                            "next": "Next",
                            "last": "Last",
                            "first": "First"
                        }
                    },

                })
                $('#report1_tbl').find('.group-checkable').change(function () {
                    var set = jQuery(this).attr("data-set");
                    var checked = jQuery(this).is(":checked");
                    jQuery(set).each(function () {
                        if (checked) {
                            $(this).prop("checked", true);
                            $(this).parents('tr').addClass("active");
                        } else {
                            $(this).prop("checked", false);
                            $(this).parents('tr').removeClass("active");
                        }
                    });
                });

                $('#report1_tbl').on('change', 'tbody tr .checkboxes', function () {
                    $(this).parents('tr').toggleClass("active");
                });
                //  exportExcelTable();
            }

            function exportExcelTable() {


                var name = $('#name').val();
                var ben_id = $('#ben_id').val();
                var visit_type = $('#visit_type').val();
                var account_type = $('#account_type').val();
                var visit_by = $('#visit_by').val();
                var fromdate = $('#fromdate').val();
                var todate = $('#todate').val();
                var district_id = $('#district_id').val();
                var VisitorRecommend = $('#VisitorRecommend').val();
                var sponser_id = $('#param_sponser_id').val();
                var beneficiary_id = $('#param_beneficiary_id').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                $('#excel_tbl').DataTable().destroy();
                $.fn.dataTable.ext.errMode = 'none';
                $('#excel_tbl').on('error.dt', function (e, settings, techNote, message) {
                    console.log('An error has been reported by DataTables: ', message);
                })

                $('#excel_tbl').dataTable({

                    'processing': true,
                    'serverSide': true,
                    'ajax': {
                        "type": "post",
                        "url": '{{url('/filterExcel-data')}}',//"s2-details-data",

                        "data": {
                            'ben_id': ben_id,
                            'name': name,
                            'visit_by': visit_by,
                            'account_type': account_type,
                            'visit_type': visit_type,
                            'fromdate': fromdate,
                            'todate': todate,
                            'district_id': district_id,
                            'sponser_id': sponser_id,
                            'VisitorRecommend': VisitorRecommend,
                            'beneficiary_id': beneficiary_id
                        }
                        ,
                        /* "success": function (data) {
                             //alert('fff');

                         }
        */
                    },
                    "initComplete": function (settings, json) {
                        $('.buttons-excel').trigger("click");
                    },

                    'columns': [
                        {data: 'num', name: 'num', width: '5%'},
                        {data: 'full_name', name: 'full_name'},
                        {data: 'beneficiary_identity', name: 'beneficiary_identity'},
                        {data: 'gender_name', name: 'gender_name'},
                        {data: 'birth_date', name: 'birth_date'},
                        {data: 'marital_status_name', name: 'marital_status_name'},
                        {data: 'account_name', name: 'account_name'},
                        {data: 'beneficiary_id', name: 'beneficiary_id'},
                        {data: 'sponser_id', name: 'sponser_id'},
                        {data: 'visit_date', name: 'visit_date'},
                        {data: 'visit_name', name: 'visit_name'},
                        {data: 'report_status', name: 'report_status'},
                        {data: 'visitor_goals', name: 'visitor_goals'},
                        {data: 'health_updates', name: 'health_updates'},
                        {data: 'educational_updates', name: 'educational_updates'},
                        {data: 'economical_updates', name: 'visitor_goals'},
                        {data: 'living_updates', name: 'living_updates'},
                        {data: 'social_updates', name: 'social_updates'},
                        {data: 'general_note', name: 'general_note'},
                        {data: 'VisitorRecommend', name: 'VisitorRecommend'},
                        {data: 'visitor_stop_resone', name: 'visitor_stop_resone'},
                        {data: 'nationality_name', name: 'nationality_name'},
                        {data: 'governorate_name', name: 'governorate_name'},
                        {data: 'city_name', name: 'city_name'},
                        {data: 'full_address', name: 'full_address'},
                        {data: 'mobile_no', name: 'mobile_no'},
                        {data: 'mobile_no1', name: 'mobile_no1'},
                        {data: 'phone', name: 'phone'},
                        {data: 'home_location', name: 'home_location'},
                        {data: 'nearist_quran', name: 'nearist_quran'},
                        {data: 'nearist_institute', name: 'nearist_institute'},
                        {data: 'guardian', name: 'guardian'},
                        {data: 'guardian_identity', name: 'guardian_identity'},
                        {data: 'guardian_relation_name', name: 'guardian_relation_name'},
                        {data: 'school_name', name: 'school_name'},
                        {data: 'study_level_name', name: 'study_level_name'},
                        {data: 'study_class_name', name: 'study_class_name'},
                        {data: 'current_avg', name: 'current_avg'},
                        {data: 'currentlevel_name', name: 'currentlevel_name'},
                        {data: 'praying_name', name: 'praying_name'},
                        {data: 'memorizes_quran', name: 'memorizes_quran'},
                        {data: 'parts_no', name: 'parts_no'},
                        {data: 'sura_no', name: 'sura_no'},
                        {data: 'skills', name: 'skills'},
                        {data: 'health_status_name', name: 'health_status_name'},
                        {data: 'health_status_details', name: 'health_status_details'},
                        {data: 'food_details', name: 'food_details'},
                        {data: 'workout_details', name: 'workout_details'},
                        {data: 'university_name', name: 'university_name'},
                        {data: 'university_major', name: 'university_major'},
                        {data: 'university_level', name: 'university_level'},
                        {data: 'current_avg', name: 'current_avg'},
                        {data: 'current_level', name: 'current_level'},
                        {data: 'obstruction_type', name: 'obstruction_type'},
                        {data: 'obstruction_details', name: 'obstruction_details'},
                        {data: 'live_details', name: 'live_details'},
                        {data: 'live_area', name: 'live_area'},
                        {data: 'live_type_name', name: 'live_type_name'},
                        {data: 'live_needs_name', name: 'live_needs_name'},
                        {data: 'development_needs', name: 'development_needs'},
                        /*  {data: 'what_needed_name', name: 'what_needed_name'},
                          {data: 'needed_details', name: 'needed_details'},
                          {data: 'needed_price', name: 'needed_price'},
                          {data: 'currency_name', name: 'currency_name'},*/
                        {data: 'project_name', name: 'project_name'},
                        {data: 'project_details', name: 'project_details'},
                        {data: 'success_indecation', name: 'success_indecation'},
                        {data: 'need_details', name: 'need_details'},
                        {data: 'story_details', name: 'story_details'},


                    ],
                    lengthMenu: [
                        [-1],
                        ['Show all']
                    ],
                    buttons: [
                        {
                            extend: 'excel',
                            className: 'btn yellow btn-outline ',
                            exportOptions: {
                                modifier: {
                                    page: 'all',
                                    search: 'applied'
                                }// 'all',     'current'
                                /*columns: [0, 1, 2, 3, 4, 5, 6, 7, 8,9,10,11,12,13,14,15,16,17,18,19,20,
                                    21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,
                                    48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64]*/
                            }

                        }

                    ],
                    // "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
                    "dom": 'Blfrtip',

                    "language": {
                        "aria": {
                            "sortAscending": ": activate to sort column ascending",
                            "sortDescending": ": activate to sort column descending"
                        },
                        "emptyTable": "لايوجد بيانات في الجدول للعرض",
                        "info": "عرض _START_ الى  _END_ من _TOTAL_ سجلات",
                        "infoEmpty": "No records found",
                        "infoFiltered": "(filtered1 from _MAX_ total records)",
                        "lengthMenu": "عرض _MENU_",
                        "search": "بحث:",
                        "zeroRecords": "No matching records found",
                        "paginate": {
                            "previous": "Prev",
                            "next": "Next",
                            "last": "Last",
                            "first": "First"
                        }
                    },

                })

                /*  $('.buttons-excel').trigger("click");*/
            }

            function viewReport(id) {
                clearReport();
                $('ul li').each(function (i) {
                    $(this).removeClass('active'); // This is your rel value
                });
                $('.tab-content > .tab-pane').each(function (i) {
                    $(this).removeClass('active'); // This is your rel value
                });

                $('#tab1').addClass('active');
                $('#tab_1').addClass('active');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: '{{url('/one-visit')}}',
                    data: {referance_key: id},

                    success: function (data) {
                        if (data.success) {
                            /*  $account_name = [1 => 'يتيم', 2 => 'معاق', 3 => 'اسرة', 4 => 'طالب'];___old
                              $account_name = [4=> 'يتيم', 1 => 'معاق', 3=> 'اسرة', 2=> 'طالب'];*/

                            $('#referance_key').val(data.visit.referance_key);
                            $('#report_status_tb').html(data.visit.report_status_table);
                            if (data.visit.one_profile.account_type == 3) {//obstruction

                                $('#schoolTab').css('display', 'block');
                                $('#religonTab').css('display', 'none');
                                $('#healthTab').css('display', 'none');
                                $('#guardianDv').css('display', 'none');
                                $('#universityTab').css('display', 'none');
                                $('#obstructionsTab').css('display', 'block');
                                // university
                                //  alert(data.visit.one_university);
                                /* if (data.visit.one_university != null) {

                                     $('#university_name').val(data.visit.one_university.university_name);
                                     $('#university_level').val(data.visit.one_university.university_level);
                                     $('#university_major').val(data.visit.one_university.university_major);
                                     $('#current_avg').val(data.visit.one_university.current_avg);
                                     $('#current_level').val(data.visit.one_university.current_level);
                                 }*/

                                // ٍSCHOOL
                                if (data.visit.one_school != null) {
                                    $('#school_name').val(data.visit.one_school.school_name);
                                    $('#study_level').val(data.visit.one_school.study_level);
                                    $('#study_class').val(data.visit.one_school.study_class);
                                    $('#current_avg').val(data.visit.one_school.current_avg);
                                    $('#currentlevel').val(data.visit.one_school.currentlevel);
                                }
                                // obstructions
                                if (data.visit.one_obstruction != null) {
                                    $('#obstruction_type').val(data.visit.one_obstruction.obstruction_type);
                                    $('#obstruction_details').val(data.visit.one_obstruction.obstruction_details);
                                }
                            }
                            if (data.visit.one_profile.account_type == 4) {//student

                                $('#schoolTab').css('display', 'none');
                                $('#religonTab').css('display', 'none');
                                $('#healthTab').css('display', 'none');
                                $('#guardianDv').css('display', 'none');
                                $('#universityTab').css('display', 'block');
                                $('#obstructionsTab').css('display', 'none');
                                if (data.visit.one_university != null) {

                                    $('#university_name').val(data.visit.one_university.university_name);
                                    $('#university_level').val(data.visit.one_university.university_level);
                                    $('#university_major').val(data.visit.one_university.university_major);
                                    $('#university_current_avg').val(data.visit.one_university.current_avg);
                                    $('#current_level').val(data.visit.one_university.current_level);
                                }
                            }
                            if (data.visit.one_profile.account_type == 2) {//family

                                $('#schoolTab').css('display', 'none');
                                $('#religonTab').css('display', 'none');
                                $('#healthTab').css('display', 'none');
                                $('#guardianDv').css('display', 'none');
                                $('#universityTab').css('display', 'none');
                                $('#obstructionsTab').css('display', 'none');
                            }

                            if (data.visit.one_profile.account_type == 1) {//يتيم
                                $('#schoolTab').css('display', 'block');
                                $('#religonTab').css('display', 'block');
                                $('#healthTab').css('display', 'block');
                                $('#guardianDv').css('display', 'block');


                                $('#universityTab').css('display', 'none');
                                $('#obstructionsTab').css('display', 'none');

                                $('#guardian').val(data.visit.one_profile.guardian);
                                $('#guardian_identity').val(data.visit.one_profile.guardian_identity);
                                $('#guardian_relation').val(data.visit.one_profile.guardian_relation);
                                // ٍSCHOOL
                                if (data.visit.one_school != null) {
                                    $('#school_name').val(data.visit.one_school.school_name);
                                    $('#study_level').val(data.visit.one_school.study_level);
                                    $('#study_class').val(data.visit.one_school.study_class);
                                    $('#current_avg').val(data.visit.one_school.current_avg);
                                    $('#currentlevel').val(data.visit.one_school.currentlevel);
                                }
                                // RELEGION
                                if (data.visit.one_religion != null) {
                                    $('#praying').val(data.visit.one_religion.praying);
                                    $('#memorizes_quran').val(data.visit.one_religion.memorizes_quran);
                                    $('#parts_no').val(data.visit.one_religion.parts_no);
                                    $('#sura_no').val(data.visit.one_religion.sura_no);
                                    $('#skills').val(data.visit.one_religion.skills);
                                }
                                // Helth
                                if (data.visit.one_health != null) {
                                    $('#health_status').val(data.visit.one_health.health_status);
                                    $('#health_status_details').val(data.visit.one_health.health_status_details);
                                    $('#food_details').val(data.visit.one_health.food_details);
                                    $('#workout_details').val(data.visit.one_health.workout_details);
                                }
                            }


                            if (data.visit.one_profile != null) {

                                $('#full_name').val(data.visit.one_profile.full_name);
                                $('#beneficiary_identity').val(data.visit.one_profile.beneficiary_identity);
                                $('#txtaccount_type').val(data.visit.one_profile.account_type_desc);
                                $('#beneficiary_id').val(data.visit.one_profile.beneficiary_id);
                                $('#sponser_id').val(data.visit.one_profile.sponser_id);
                                $('#gender').val(data.visit.one_profile.gender);
                                $('#birth_date').val(data.visit.one_profile.birth_date);
                                $('#guardian').val(data.visit.one_profile.guardian);
                                $('#guardian_identity').val(data.visit.one_profile.guardian_identity);
                                $('#guardian_relation').val(data.visit.one_profile.guardian_relation);
                                $('#nationality').val(data.visit.one_profile.nationality);
                                $('#governorate').val(data.visit.one_profile.governorate);
                                $('#city').val(data.visit.one_profile.city);
                                $('#neighborhood').val(data.visit.one_profile.neighborhood);
                                $('#full_address').val(data.visit.one_profile.full_address);
                                $('#home_location').val(data.visit.one_profile.home_location);
                                $('#latitude').val(data.visit.one_profile.latitude);
                                $('#longitude').val(data.visit.one_profile.longitude);
                                $('#mobile_no').val(data.visit.one_profile.mobile_no);
                                $('#mobile_no1').val(data.visit.one_profile.mobile_no1);
                                $('#phone').val(data.visit.one_profile.phone);
                                $('#marital_status').val(data.visit.one_profile.marital_status);
                                $('#nearist_quran').val(data.visit.one_profile.nearist_quran);
                                $('#nearist_institute').val(data.visit.one_profile.nearist_institute);
                            }
                            if (data.visit.one_guardian != null) {
                                $('#supporter_name').val(data.visit.one_guardian.supporter_name);
                                $('#supporter_identity').val(data.visit.one_guardian.supporter_identity);
                                $('#supporter_relationship').val(data.visit.one_guardian.supporter_relationship_name);
                                $('#guardian_district').val(data.visit.one_guardian.district_name);
                                $('#guardian_city').val(data.visit.one_guardian.city_name);
                                $('#guardian_neighborhood').val(data.visit.one_guardian.neighborhood);
                                $('#guardian_full_address').val(data.visit.one_guardian.full_address);
                                $('#guardian_mobile1').val(data.visit.one_guardian.mobile1);
                                $('#guardian_mobile2').val(data.visit.one_guardian.mobile2);
                                $('#card_date_expired').val(data.visit.one_guardian.card_date_expired);
                                $('#guardianship_date_expired').val(data.visit.one_guardian.guardianship_date_expired);
                            }
                            // Live
                            if (data.visit.one_live != null) {
                                $('#live_details').html(data.visit.one_live.live_details);
                                $('#live_area').val(data.visit.one_live.live_area);
                                $('#live_type').val(data.visit.one_live.live_type);
                                $('#live_needs').val(data.visit.one_live.live_needs);
                                $('#development_needs').val(data.visit.one_live.development_needs);
                            }
                            // Needs
                            if (data.visit.one_orphan != null) {
                                $('#OrphanNeedDv').html(data.visit.one_orphan);
                                //    $('#staticalCard_tb').html(data.visit.one_statisticard);
                            }
                            // Statical card
                            if (data.visit.one_statisticard != null) {
                                $('#staticalCard_tb').html(data.visit.one_statisticard);
                            }
                            if (data.visit.one_story != null) {

                                $('#story_details').val(data.visit.one_story.story_details);
                            }
                            if (data.visit.one_otherNeed != null) {
                                $('#need_details').val(data.visit.one_otherNeed.need_details);
                            }
                            // Statical card
                            if (data.visit.report_status_list != null) {
                                $('#report_status').html(data.visit.report_status_list);
                            }
                            // Family Needs
                            if (data.visit.one_family != null) {
                                $('#project_name').val(data.visit.one_family.project_name);
                                $('#project_details').val(data.visit.one_family.project_details);
                                $('#success_indecation').val(data.visit.one_family.success_indecation);
                            }
                            // visit Report
                            if (data.visit.one_visit_report != null) {

                                $('#visitor_goals').val(data.visit.one_visit_report.visitor_goals);
                                $('#health_updates').val(data.visit.one_visit_report.health_updates);
                                $('#educational_updates').val(data.visit.one_visit_report.educational_updates);
                                $('#economical_updates').val(data.visit.one_visit_report.economical_updates);
                                $('#social_updates').val(data.visit.one_visit_report.social_updates);
                                $('#living_updates').val(data.visit.one_visit_report.living_updates);
                                $('#general_note').val(data.visit.one_visit_report.general_note);
                                $('#visitor_recommend').val(data.visit.one_visit_report.visitor_recommend);
                                $('#visitor_stop_resone').val(data.visit.one_visit_report.visitor_stop_resone);
                            }

                            //Images
                            if (data.visit.one_image != null) {
                                $('#img_content').html(data.visit.one_image)
                            }

                        }

                    }


                });
            }

            function myFunction(imgs) {
                // Get the expanded image
                var expandImg = document.getElementById("expandedImg");
                // Get the image text
                var imgText = document.getElementById("imgtext");
                // Use the same src in the expanded image as the image being clicked on from the grid
                expandImg.src = imgs.src;
                // Use the value of the alt attribute of the clickable image as text inside the expanded image
                imgText.innerHTML = imgs.alt;
                // Show the container element (hidden with CSS)
                expandImg.parentElement.style.display = "block";
            }

            function printReport(id) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: '{{url('/print-visit')}}',
                    data: {referance_key: id},

                    success: function (data) {
                        if (data.success) {


                        }

                    }


                });
            }

            function clearReport() {
                $('.form-control').val('');
                $('#staticalCardDv').html('');
                $('#OrphanNeedDv').html('');
            }

            function clearForm() {
                $('#name').val('');
                $('#ben_id').val('');
                $('#visit_type').val('');
                $('#account_type').val('');
                $('#visit_by').val('');
                $('#district_id').val('');
                $('#param_beneficiary_id').val('');
                $('#param_sponser_id').val('');
                $('#VisitorRecommend').val('');
                $('.select2').trigger('change');
                $('#fromdate').datepicker('setDate', '');
                $('#todate').datepicker('setDate', '');
                reloadvisitTable();

            }

            function get_prop() {
                var report_type = $('#report_type').val();
                var id = $('#ben_id_hdn').val();
                var html = '';
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: '{{url('/get-rep-prop')}}',
                    data: {id: id, rep_type: report_type},

                    success: function (data) {
                        if (data.success) {

                            // alert(data.btn_url)
                            $('#properties').html(data.html);

                        }

                    }


                });

                /*  if(report_type==1)
                  {
                      html='  <option value="0">اختر التقرير</option>'


                  }
                  else if(report_type==2)
                  {

                  }
                  else
                  {

                  }*/
                $('#properity_by').val(html);
            }

            function deleteBef(id) {
                var x = '';
                var r = confirm('سيتم حذف المنتفع وكافة تقارير الزيارة الخاصة به ,هل انت متاكد من ذلك؟');
                var currentToken = $('meta[name="csrf-token"]').attr('content');


                if (r == true) {
                    x = 1;
                } else {
                    x = 0;
                }
                if (x == 1) {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: "POST",
                        url: '{{url('bef/del-one')}}',
                        data: {id: id},

                        success: function (data) {
                            location.reload();
                        },
                        error: function (err) {

                            console.log(err);
                        }

                    })
                }
            }

            function save_report_status() {
                /*  if ($('#report_status').val() == '' || $('#report_status').val() == null) {
                       $('.alert-danger-report_status').show();
                       $('.alert-danger-report_status').fadeOut(2000);
                       $('#report_status').closest('.form-group').addClass('has-error');
                       //$('#report_status').val().parent().addClass('has-error');
                       return;
                   } else {
                       $('#report_status').closest('.form-group').removeClass('has-error');
                   }
                   $.ajaxSetup({
                       headers: {
                           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                       }
                   });
        */
                $.ajax({
                    type: "POST",
                    url: '{{url('bef/change-report-status')}}',
                    data: {
                        referance_key: $('#referance_key').val(),
                        report_status: $('#report_status').val(),
                        reject_reason: $('#reject_reason').val()
                    },

                    success: function (data) {
                        if (data.success) {
                            alert('تمت العملية بنجاح');
                            $('#report_status_tb').html(data.html);
                            $('#report_status').val('').trigger('change');
                            $('#reject_reason').val('');

                        } else {
                            alert('لم تتم العملية بنجاح')
                        }
                    },
                    error: function (err) {

                        console.log(err);
                    }

                })
            }

            $('#btn-delete').on('click', function (e) {
                    e.preventDefault();
                    var x = '';

                    var currentToken = $('meta[name="csrf-token"]').attr('content');
                    var idArray = [];
                    var table = $('#report1_tbl').DataTable();
                    table.$('input[type="checkbox"]').each(function () {
                        // If checkbox doesn't exist in DOM

                        // If checkbox is checked
                        if (this.checked) {
                            // alert($(this).attr('data-id'));
                            idArray.push($(this).attr('data-id'));
                            // Create a hidden element
                            /*$form.append(
                                $('<input>')
                                    .attr('type', 'hidden')
                                    .attr('name', this.name)
                                    .val(this.value)
                            );*/
                        }

                    });
                    //   alert('checked :' +idArray);
                    if (idArray.length > 0) {
                        var r = confirm('سيتم حذف المنتفعين وكافة تقارير الزيارة الخاصة بهم ,هل انت متاكد من ذلك؟');
                        if (r == true) {
                            x = 1;
                        } else {
                            x = 0;
                        }
                        if (x == 1) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                type: "POST",
                                url: '{{url('bef/del-chk')}}',
                                data: {idArray: idArray},

                                success: function (data) {
                                    location.reload();
                                },
                                error: function (err) {

                                    console.log(err);
                                }

                            })
                        }
                    }
                }
            );
            $(document).on('submit', '#seach-form', function (e) {
                e.preventDefault();

                exportExcelTable();
                /* $('#excel-tbl').dataTable( {
                     "initComplete": function(settings, json) {
                         alert( 'DataTables has finished its initialisation.' );
                     }
                 } );*/

            });

            var mymap = L.map('map').setView([31.354675, 34.308826], 13);
            var marker = null;

            function initMap2(latitude = '', longitude = '', address = '') {

                //  var mymap = L.map('map').setView([51.505, -0.09], 13);
                if (marker != null)
                    mymap.removeLayer(marker);
                L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                    maxZoom: 18,
                    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                        '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                        'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                    id: 'mapbox/streets-v11',
                    tileSize: 512,
                    zoomOffset: -1
                }).addTo(mymap);
                if (latitude != null) {


                    marker = L.marker([latitude, longitude]).addTo(mymap);
                    marker.bindPopup("<b>العنوان</b><br>" + address).openPopup();
                }
            }

            $('#ben-map').on('shown.bs.modal', function () {

                setTimeout(function () {
                    mymap.invalidateSize();
                }, 1);
            })

        </script>
    @endpush
@stop
