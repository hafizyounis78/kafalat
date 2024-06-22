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
                <div class="portlet box green" id="searchDv" style="display: none">
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">اسم الوصي</label>
                                            <div class="col-md-8">
                                                <input type="text" id="guardian_name" class="form-control">
                                            </div>
                                            {{-- <span class="help-block"> This is inline help </span>--}}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">رقم هوية الوصي</label>
                                            <div class="col-md-8">
                                                <input type="text" id="guardian_id" class="form-control">
                                            </div>
                                            {{-- <span class="help-block"> This is inline help </span>--}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">اسم المعيل</label>
                                            <div class="col-md-8">
                                                <input type="text" id="supporter_name" class="form-control">
                                            </div>
                                            {{-- <span class="help-block"> This is inline help </span>--}}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">رقم هوية المعيلة</label>
                                            <div class="col-md-8">
                                                <input type="text" id="supporter_id" class="form-control">
                                            </div>
                                            {{-- <span class="help-block"> This is inline help </span>--}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">التاريخ </label>
                                            <div class="col-md-8">
                                                <div class="input-group input-large date-picker input-daterange"
                                                     data-date="10/11/2012" data-date-format="yyyy/mm/dd">
                                                    <input type="text" class="form-control" name="card_fromdate"
                                                           id="card_fromdate">
                                                    <span class="input-group-addon"> الى </span>
                                                    <input type="text" class="form-control" name="card_todate"
                                                           id="card_todate">
                                                </div>
                                                <!-- /input-group -->
                                                {{--  <span class="help-block"> Select date range </span>--}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">التاريخ </label>
                                            <div class="col-md-8">
                                                <div class="input-group input-large date-picker input-daterange"
                                                     data-date="10/11/2012" data-date-format="yyyy/mm/dd">
                                                    <input type="text" class="form-control" name="guardian_fromdate"
                                                           id="guardian_fromdate">
                                                    <span class="input-group-addon"> الى </span>
                                                    <input type="text" class="form-control" name="guardian_todate"
                                                           id="guardian_todate">
                                                </div>
                                                <!-- /input-group -->
                                                {{--  <span class="help-block"> Select date range </span>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">المحافظة</label>
                                            <div class="col-md-8">
                                                <select id="district" class="form-control select2 hselect"
                                                        name="district" onchange="getCity();">
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">المدن</label>
                                            <div class="col-md-8">
                                                <select id="city_id" class="form-control select2 hselect"
                                                        name="city_id">
                                                    <option value="">اختر ..</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6"></div>
                                    <div class="col-md-3">
                                        <div class="col-md-3">
                                            <div class="btn-group">
                                                <button type="button" class="btn purple-plum" title="بحث"
                                                        onclick="reloadGuardianTable()">
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
                                                    <i class="fa fa-refresh"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-3 ">
                                            <div class="btn-group">
                                                <button class="btn gray " type="button" onclick="closeSearchForm()"
                                                        title="اغلاق">
                                                    <i class="fa fa-circle-o-notch"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </form>
                    </div>

                </div st>
                <div class="portlet box  blue-sharp ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-comments"></i>جدول البيانات
                        </div>
                        <div class="tools">
                            <button type="button" onclick="openDv()" class="btn  btn-xs btn-icon-only gray">

                                <i class="fa fa-search font-blue"></i></button>
                        </div>
                    </div>

                    <div class="portlet-body">


                        <table class="table table-bordered table-hover" id="guardianTable">
                            <thead>
                            <tr>
                                <th> #</th>
                                <th> اسم الوصي</th>
                                <th>رقم الهوية</th>
                                <th>جوال اساسي</th>
                                <th>جوال طوارئ</th>
                                <th>المحافظة</th>
                                <th>المدينة</th>
                                {{--<th>الحي</th>--}}
                                <th>المعيل</th>
                                <th>تاريخ انتهاء البطاقة</th>
                                <th>تاريخ انتهاء الوصاية</th>
                                <th>رقم الكفالة</th>
                                <th> عرض الكفالات</th>

                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>


        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>

    <div class="modal fade bs-modal-lg" id="sponsoredModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true"></button>
                    <h4 class="modal-title">عرض بيانات المكفولين </h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN SAMPLE TABLE PORTLET-->
                            <div class="portlet box green">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-comments"></i>جدول البيانات
                                    </div>
                                    <div class="tools">

                                    </div>
                                </div>

                                <div class="portlet-body">

                                    <div class="">
                                        <table class="table table-bordered table-hover" id="sponsoredTable">
                                            <thead>
                                            <tr>
                                                <th> #</th>
                                                <th> الاسم</th>
                                                <th> رقم الهوية</th>
                                                <th> تاريخ الميلاد</th>
                                                <th> نوع الكفالة</th>
                                                <th> تاريخ الكفالة</th>
                                                <th> رقم الكفالة</th>
                                                <th> تفاصيل الزيارات</th>
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
    <div class="modal fade bs-modal-lg" id="guardian-map" tabindex="-1" role="dialog" aria-hidden="true">
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
                                        <i class="fa fa-briefcase"></i>موقع الوصى على الخريطة
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
                                                    <button class="btn red " type="button">
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
                                                    <a href="#tab_10" data-toggle="tab">تقرير الزيارة </a>
                                                </li>


                                                <li>
                                                    <a href="#tab_11" data-toggle="tab">مرفقات</a>
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
                                                                        <h3 class="form-section"> بيانات الكفيل</h3>
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        class="control-label">الوصي</label>
                                                                                    <input type="text" id="guardian"
                                                                                           class="form-control"
                                                                                           placeholder=""
                                                                                           value="" disabled>
                                                                                    {{-- <span class="help-block"> This is inline help </span>--}}
                                                                                </div>
                                                                            </div>
                                                                            <!--/span-->
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">رقم
                                                                                        هوية
                                                                                        الوصي </label>
                                                                                    <input type="text"
                                                                                           id="guardian_identity"
                                                                                           class="form-control"
                                                                                           placeholder=""
                                                                                           value="" disabled>
                                                                                    {{-- <span class="help-block"> This is inline help </span>--}}
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">نوع
                                                                                        العلاقة
                                                                                    </label>
                                                                                    <input type="text"
                                                                                           id="guardian_relation"
                                                                                           class="form-control"
                                                                                           placeholder=""
                                                                                           value="" disabled>
                                                                                    {{-- <span class="help-block"> This is inline help </span>--}}
                                                                                </div>
                                                                            </div>
                                                                            <!--/span-->
                                                                        </div>
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
                                                            <form action="#" class="horizontal-form">
                                                                <div class="form-body">
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">الاحتياج
                                                                                    الحالي</label>
                                                                                <input type="text" id="what_needed"
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
                                                                                <label class="control-label">تكلفة
                                                                                    الاحتياج</label>
                                                                                <input type="text"
                                                                                       id="needed_price"
                                                                                       value=""
                                                                                       class="form-control"
                                                                                       placeholder="" disabled>
                                                                                {{--  <span class="help-block"> This field has error. </span>--}}
                                                                            </div>
                                                                        </div>

                                                                        <!--/span-->

                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    class="control-label">العملة</label>
                                                                                <input type="text" id="currency"
                                                                                       class="form-control"
                                                                                       placeholder=""
                                                                                       value="" disabled>
                                                                                {{-- <span class="help-block"> This is inline help </span>--}}
                                                                            </div>
                                                                        </div>
                                                                        <!--/span-->
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">تفاصيل
                                                                                    الاحتياج</label>
                                                                                <textarea type="text"
                                                                                          id="needed_details"
                                                                                          class="form-control"
                                                                                          placeholder=""
                                                                                          disabled></textarea>
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
    <div class="modal fade bs-modal-lg" id="guardianImageModal"  tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">معرض الصور والوثائق</h4>
                </div>
                <div class="modal-body">
                    <!-- The four columns -->
                    <div id="guardianImg_content">

                    </div>
                    <div class="container">
                                                    <span onclick="this.parentElement.style.display='none'"
                                                          class="closebtn">&times;</span>
                        <img id="guardian_expandedImg" style="width:50%">
                        <div id="guardian_imgtext"></div>
                    </div>
                </div>
            </div>
            {{--<div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Close</button>
                <button type="button" class="btn green">Save changes</button>
            </div>--}}
        </div>
    </div>

    @push('css')
        {{-- <link rel="stylesheet" type="text/css" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"/>--}}
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
              integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
              crossorigin=""/>
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
        {{-- <script type='text/javascript' src='https://unpkg.com/leaflet@1.6.0/dist/leaflet.js'></script>--}}
        <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
                integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
                crossorigin=""></script>

        <!-- END PAGE LEVEL PLUGINS -->



        <script>
            $(document).ready(function () {

                reloadGuardianTable();
                reloadSupportTable();

            })


            function clearForm() {
                $('.form-control').val('');
                $('#fromdate').datepicker('setDate', '');
                $('#todate').datepicker('setDate', '');
                reloadGuardianTable();

            }

            function closeSearchForm() {
                // clearForm();
                openDv();


            }

            function getCity() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: '{{url('guardian/get-city')}}',
                    data: {district_id: $('#district').val()},

                    success: function (data) {
                        if (data.success) {
                            $('#city_id').html(data.html);
                        }
                    }
                });
            }

            function reloadGuardianTable() {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                $('#guardianTable').DataTable().destroy();
                $.fn.dataTable.ext.errMode = 'none';
                $('#guardianTable').on('error.dt', function (e, settings, techNote, message) {
                    console.log('An error has been reported by DataTables: ', message);
                })

                $('#guardianTable').dataTable({

                    'processing': true,
                    'serverSide': true,
                    'ajax': {
                        "type": "post",
                        "url": '{{url('guardian/guardian-data')}}',//"s2-details-data",

                        "data": {
                            'guardian_name': $('#guardian_name').val(),
                            'guardian_id': $('#guardian_id').val(),
                            'supporter_name': $('#supporter_name').val(),
                            'supporter_id': $('#supporter_id').val(),
                            'card_fromdate': $('#card_fromdate').val(),
                            'card_todate': $('#card_todate').val(),
                            'guardian_fromdate': $('#guardian_fromdate').val(),
                            'guardian_todate': $('#guardian_todate').val(),
                            'district': $('#district').val(),
                            'city_id': $('#city_id').val(),
                        }
                        ,

                    },


                    'columns': [
                        {data: 'id', name: 'id'},
                        {data: 'name', name: 'name'},
                        {data: 'guardian_identity', name: 'guardian_identity'},
                        {data: 'mobile1', name: 'mobile1'},
                        {data: 'mobile2', name: 'mobile2'},
                        {data: 'district', name: 'district'},
                        {data: 'city', name: 'city'},
                        /*  {data: 'neighborhood', name: 'neighborhood'},*/
                        {data: 'supporter_name', name: 'supporter_name'},
                        {data: 'card_date_expired', name: 'card_date_expired'},
                        {data: 'guardianship_date_expired', name: 'guardianship_date_expired'},
                        {data: 'sponser_id', name: 'sponser_id'},
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

            function reloadSupportTable() {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                $('#reloadSupportTable').DataTable().destroy();
                $.fn.dataTable.ext.errMode = 'none';
                $('#reloadSupportTable').on('error.dt', function (e, settings, techNote, message) {
                    console.log('An error has been reported by DataTables: ', message);
                })

                $('#reloadSupportTable').dataTable({

                    'processing': true,
                    'serverSide': true,
                    'ajax': {
                        "type": "post",
                        "url": '{{url('guardian/support-data')}}',//"s2-details-data",

                        "data": {
                            //  'user_id': $('#hdn_user_id').val(),
                            'from': $('#P_FROM_DATE').val(),
                            'to': $('#P_TO_DATE').val(),
                            'name': $('#name').val()
                        }
                        ,

                    },


                    'columns': [
                        {data: 'id', name: 'id'},
                        {data: 'name', name: 'name'},
                        {data: 'support_identity', name: 'support_identity'},
                        {data: 'support_relationship', name: 'support_relationship'},
                        {data: 'expired_date', name: 'expired_date'},
                        {data: 'support_expired_date', name: 'support_expired_date'},
                        {data: 'sponser_id', name: 'sponser_id'},
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

            function reloadSponsoredTable(guardian_identity) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                $('#sponsoredTable').DataTable().destroy();
                $.fn.dataTable.ext.errMode = 'none';
                $('#sponsoredTable').on('error.dt', function (e, settings, techNote, message) {
                    console.log('An error has been reported by DataTables: ', message);
                })

                $('#sponsoredTable').dataTable({

                    'processing': true,
                    'serverSide': true,
                    'ajax': {
                        "type": "post",
                        "url": '{{url('guardian/sponsored-data')}}',//"s2-details-data",

                        "data": {
                            'guardian_identity': guardian_identity,
                        }
                        ,

                    },
                    'columns':
                        [
                            {data: 'id', name: 'id'},
                            {data: 'full_name', name: 'full_name'},
                            {data: 'beneficiary_identity', name: 'beneficiary_identity'},
                            {data: 'birth_date', name: 'birth_date'},
                            {data: 'account_name', name: 'account_name'},
                            {data: 'created_at', name: 'created_at'},
                            {data: 'sponser_id', name: 'sponser_id'},
                            {data: 'action', name: 'action'},
                        ],
                    "language":
                        {
                            "aria":
                                {
                                    "sortAscending":
                                        ": activate to sort column ascending",
                                    "sortDescending":
                                        ": activate to sort column descending"
                                }
                            ,
                            "emptyTable":
                                "لايوجد بيانات في الجدول للعرض",
                            "info":
                                "عرض _START_ الى  _END_ من _TOTAL_ سجلات",
                            "infoEmpty":
                                "No records found",
                            "infoFiltered":
                                "(filtered1 from _MAX_ total records)",
                            "lengthMenu":
                                "عرض _MENU_",
                            "search":
                                "بحث:",
                            "zeroRecords":
                                "No matching records found",
                            "paginate":
                                {
                                    "previous":
                                        "Prev",
                                    "next":
                                        "Next",
                                    "last":
                                        "Last",
                                    "first":
                                        "First"
                                }
                        }
                    ,

                })


            }

            function openSponsoredModal(guardian_identity) {
                //  $('#hdn_guardian_identity').val(id);
                if (guardian_identity != null)
                    reloadSponsoredTable(guardian_identity);
            }

            function openImageModal(guardian_id) {
                //  $('#hdn_guardian_identity').val(id);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: '{{url('guardian/get-image')}}',
                        data: {guardian_id: guardian_id},

                        success: function (data) {
                            if (data.success) {
                                $('#guardianImg_content').html(data.html);
                            }
                        }
                    });

            }
            function myFunction(imgs) {
                // Get the expanded image
                var expandImg = document.getElementById("guardian_expandedImg");
                // Get the image text
                var imgText = document.getElementById("guardian_imgtext");
                // Use the same src in the expanded image as the image being clicked on from the grid
                expandImg.src = imgs.src;
                // Use the value of the alt attribute of the clickable image as text inside the expanded image
                imgText.innerHTML = imgs.alt;
                // Show the container element (hidden with CSS)
                expandImg.parentElement.style.display = "block";
            }
            function viewReport(id) {
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
                                    $('#obstruction_details').html(data.visit.one_obstruction.obstruction_details);
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
                                    $('#health_status_details').html(data.visit.one_health.health_status_details);
                                    $('#food_details').html(data.visit.one_health.food_details);
                                    $('#workout_details').html(data.visit.one_health.workout_details);
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
                                $('#mobile_no').val(data.visit.one_profile.mobile_no);
                                $('#mobile_no1').val(data.visit.one_profile.mobile_no1);
                                $('#phone').val(data.visit.one_profile.phone);
                                $('#marital_status').val(data.visit.one_profile.marital_status);
                                $('#nearist_quran').val(data.visit.one_profile.nearist_quran);
                                $('#nearist_institute').val(data.visit.one_profile.nearist_institute);
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
                                $('#what_needed').val(data.visit.one_orphan.what_needed);
                                $('#needed_price').val(data.visit.one_orphan.needed_price);
                                $('#currency').val(data.visit.one_orphan.currency);
                                $('#needed_details').html(data.visit.one_orphan.needed_details);
                            }
                            // Family Needs
                            if (data.visit.one_family != null) {
                                $('#project_name').val(data.visit.one_family.project_name);
                                $('#project_details').html(data.visit.one_family.project_details);
                                $('#success_indecation').html(data.visit.one_family.success_indecation);
                            }
                            // visit Report
                            if (data.visit.one_visit_report != null) {
                                $('#visitor_goals').html(data.visit.one_visit_report.visitor_goals);
                                $('#health_updates').html(data.visit.one_visit_report.health_updates);
                                $('#educational_updates').html(data.visit.one_visit_report.educational_updates);
                                $('#economical_updates').html(data.visit.one_visit_report.economical_updates);
                                $('#social_updates').html(data.visit.one_visit_report.social_updates);
                                $('#visitor_recommend').html(data.visit.one_visit_report.visitor_recommend);
                                $('#visitor_stop_resone').html(data.visit.one_visit_report.visitor_stop_resone);
                            }

                            //Images
                            if (data.visit.one_image != null) {
                                $('#img_content').html(data.visit.one_image)
                            }

                        }

                    }


                });
            }

            function getVisits(id) {
                $('#banf_id_hdn').val();
                $('#banf_id_hdn').val(id);
                $('#visitsModal').modal('show')
                reloadDetailTable(id)

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

            function initMap(latitude, longitude, address) {
                var osmUrl = 'http://{s}.tile.osm.org/{z}/{x}/{y}.png';
                osmAttrib = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                    // create the tile layer with correct attribution
                    osm = L.tileLayer(osmUrl, {
                        minZoom: 4,
                        tileSize: 512,
                        zoomOffset: -1,
                        maxZoom: 17,
                        attribution: osmAttrib
                    });
                var map = null;
                if (map == null)
                    map = new L.map('map').setView([latitude, longitude], 13).addLayer(osm);


                //  $.getJSON("https://sta.ci.taiwan.gov.tw/STA_Rain/v1.0/Things?$expand=Locations&$select=name,properties&$count=true", function (data) {
                var markerGroup = L.featureGroup();


                var latLng = L.latLng(latitude, longitude);
                var myMarker = L.marker(latLng).addTo(markerGroup);

                var popupContent = "<p> العنوان: <b>" + address;


                /*if (itemData.properties && itemData.properties.popupContent) {
                    popupContent += itemData.properties.popupContent;
                }*/
                myMarker.bindPopup(popupContent);

                //   map.addPopup(popup);
                markerGroup.addTo(map);
                map.fitBounds(markerGroup.getBounds());

            }

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

            $('#guardian-map').on('shown.bs.modal', function () {
                setTimeout(function () {
                    mymap.invalidateSize();
                }, 1);
            })

            function openDv() {

                $('#searchDv').fadeToggle();

            }
        </script>
    @endpush
@stop
