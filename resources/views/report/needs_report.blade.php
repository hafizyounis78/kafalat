@extends('admin.layout.index')
@section('content')
    <div class="page-content" xmlns="http://www.w3.org/1999/html">
        <meta name="csrf-token" content="{{ csrf_token()}}">
        <h1 class="page-title"> {{$title}}
            <small>{{$location_title}}</small>
        </h1>
        <div class="page-bar">
            @include('admin.layout.breadcrumb')

        </div>
        @if($errors->any())
            <div class="alert alert-danger">
                <button class="close" data-close="alert"></button>
                <h4>{{$errors->first()}}</h4>
            </div>
        @endif
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>معاير البحث
                </div>
                <!--<div class="tools">
                    <a href="javascript:;" class="collapse"> </a>

                </div>-->
            </div>
            <div class="portlet-body form">

                {{Form::open(['url'=>url(''),'class'=>'form-horizontal','method'=>"post","id"=>"search-form"])}}
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label col-md-5"> نوع الحساب</label>
                                <div class="col-md-7">
                                    <select id="account_type" class="form-control select2"
                                            name="account_type" onchange="checkSub_need();">
                                        <option value="">اختر..</option>
                                        <option value="1">يتيم</option>
                                        <option value="2">اسرة</option>
                                        <option value="3">معاق</option>
                                        <option value="4"> طالب</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-2">التاريخ </label>
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label col-md-5">تصنيف الاحتياج</label>
                                <div class="col-md-7">
                                    <select id="need_id" class="form-control select2"
                                            name="need_id" onchange="get_sub_need_list()">
                                        <option value="">اختر..</option>
                                        <?php

                                        foreach ($needsCategories as $value) {

                                            echo '<option value="' . $value->id . '">' . $value->lookup_cat_details . '</option>';
                                        }

                                        ?>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label col-md-4">نوع الإحتياج</label>
                                <div class="col-md-8">
                                    <select id="sub_need_id" class="form-control select2"
                                            name="sub_need_id" onchange="get_coutcome_need_list();">
                                        <option value="">اختر..</option>


                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label col-md-4">مخرج الاحتياج</label>
                                <div class="col-md-8">
                                    <select id="need_outcome_id" class="form-control select2"
                                            name="need_outcome_id">
                                        <option value="">اختر..</option>

                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label col-md-5">المحافظة</label>
                                <div class="col-md-7">
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
                        <div class="col-md-offset-8">
                            <div class="col-md-10">
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
                                        <button type="submit" class="btn green-meadow button-excel2 " title="أكسل"
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
                </div>
                {{Form::close()}}

            </div>

        </div>
        <div class="portlet light bordered">

            <div class="portlet-body">
                {{--<div class="table-toolbar">
                    <div class="col-md-2">

                    </div>
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-8">
                        <a style="float: left"
                           class="dt-button button-excel2 buttons-html5 btn yellow btn-outline"
                           tabindex="0" aria-controls="data-table" href="#"><i
                                class="fa fa-file-excel-o"></i>Excel</a>
                    </div>
                </div>--}}
                <table
                    class="table table-striped table-bordered table-hover table-checkable order-column"
                    id="report1_tbl">
                    <thead>
                    <tr>
                        <th width="5%"> #</th>
                        <th width="25%"> الاسم</th>
                        <th width="10%"> رقم الهوية</th>
                        <th width="10%"> نوع الحساب</th>
                        <th width="10%"> رقم الكفالة</th>
                        <th width="10%"> حالة التقرير</th>
                        <th width="10%"> تصنيف الاحتياج</th>
                        <th width="10%">نوع الاحتياج</th>
                        <th width="10%"> مخرج الاحتياج</th>
                        <th width="10%">المدينة</th>
                        {{--<th width="10%">عرض التقارير</th>--}}
                    </tr>
                    </thead>
                </table>
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

                    </tr>
                    </thead>
                </table>

            </div>


        </div>

        @push('css')
            <style>

                .datepicker {
                    width: 15%;

                }

                .select2 {
                    font-size: 12px;
                    height: 37px;
                }
            </style>
            <link href="{{url('')}}/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet"
                  type="text/css"/>
            <link href="{{url('')}}/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet"
                  type="text/css"/>
            <link href="{{url('')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css"
                  rel="stylesheet" type="text/css"/>
            <link href="{{url('')}}/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"
                  rel="stylesheet" type="text/css"/>

            <style>

                .hselect {
                    height: 41px !important;
                }

                .dt-buttons {
                    display: none;
                }

            </style>

        @endpush
        @push('js')
            <script src="{{url('')}}/assets/global/plugins/select2/js/select2.full.min.js"
                    type="text/javascript"></script>
            <script src="{{url('')}}/assets/pages/scripts/components-select2.js"
                    type="text/javascript"></script>
            <script src="{{url('')}}/assets/global/plugins/moment.min.js" type="text/javascript"></script>
            <script src="{{url('')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js"
                    type="text/javascript"></script>
            <script src="{{url('')}}/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"
                    type="text/javascript"></script>
            <script src="{{url('')}}/assets/pages/scripts/components-date-time-pickers.min.js"
                    type="text/javascript"></script>
            <script>
                $(document).ready(function () {
                    reloadvisitTable();
                    $('.buttons-excel').addClass('hidden');
                   /* $('.button-excel2').click(function () {
                        $('.buttons-excel').click()
                    });*/
                });
                $(document).on('submit', '#search-form', function (e) {
                    e.preventDefault();

                    exportExcelTable();
                    /* $('#excel-tbl').dataTable( {
                         "initComplete": function(settings, json) {
                             alert( 'DataTables has finished its initialisation.' );
                         }
                     } );*/

                });
                function reloadvisitTable() {
                    var account_type = $('#account_type').val();
                    var need_id = $('#need_id').val();
                    var sub_need_id = $('#sub_need_id').val();
                    var need_outcome_id = $('#need_outcome_id').val();
                    var fromdate = $('#fromdate').val();
                    var todate = $('#todate').val();
                    var district_id = $('#district_id').val();
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
                            "url": '{{url('/filterNeeds-data')}}',

                            "data": {

                                'account_type': account_type,
                                'need_id': need_id,
                                'sub_need_id': sub_need_id,
                                'need_outcome_id': need_outcome_id,
                                'fromdate': fromdate,
                                'todate': todate,
                                'district_id': district_id,

                            }
                            ,

                        },

                       /* "initComplete": function (settings, json) {
                            $('.buttons-excel').trigger("click");
                        },*/
                        'columns': [
                            {data: 'num', name: 'num', width: '5%'},
                            {data: 'full_name', name: 'full_name', width: '20%', orderable: true},
                            {data: 'beneficiary_identity', name: 'beneficiary_identity', width: '10%', orderable: true},
                            {data: 'account_name', name: 'account_name', width: '10%'},
                            {data: 'sponser_id', name: 'sponser_id', width: '10%', orderable: true},
                            {data: 'report_status', name: 'report_status', width: '10%', orderable: true},
                            {data: 'need_id', name: 'need_id', width: '10%', orderable: true},
                            {data: 'sub_need_id', name: 'sub_need_id', width: '10%', orderable: true},
                            {data: 'need_outcome_id', name: 'need_outcome_id', width: '10%'},
                            {data: 'city_name', name: 'city_name', width: '10%'},
                            /*{data: 'action', name: 'action', width: '5%'}*/
                        ],
                       /* lengthMenu: [
                            [-1],
                            ['Show all']
                        ],*/
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

                    });
                }
                function exportExcelTable() {

                    var account_type = $('#account_type').val();
                    var need_id = $('#need_id').val();
                    var sub_need_id = $('#sub_need_id').val();
                    var need_outcome_id = $('#need_outcome_id').val();
                    var fromdate = $('#fromdate').val();
                    var todate = $('#todate').val();
                    var district_id = $('#district_id').val();
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
                            "url": '{{url('/filterNeeds-data')}}',

                            "data": {
                                'account_type': account_type,
                                'need_id': need_id,
                                'sub_need_id': sub_need_id,
                                'need_outcome_id': need_outcome_id,
                                'fromdate': fromdate,
                                'todate': todate,
                                'district_id': district_id,
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
                            {data: 'full_name', name: 'full_name', width: '20%', orderable: true},
                            {data: 'beneficiary_identity', name: 'beneficiary_identity', width: '10%', orderable: true},
                            {data: 'account_name', name: 'account_name', width: '10%'},
                            {data: 'sponser_id', name: 'sponser_id', width: '10%', orderable: true},
                            {data: 'report_status', name: 'report_status', width: '10%', orderable: true},
                            {data: 'need_id', name: 'need_id', width: '10%', orderable: true},
                            {data: 'sub_need_id', name: 'sub_need_id', width: '10%', orderable: true},
                            {data: 'need_outcome_id', name: 'need_outcome_id', width: '10%'},
                            {data: 'city_name', name: 'city_name', width: '10%'},
                            /*{data: 'action', name: 'action', width: '5%'}*/
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
                function checkSub_need() {
                    if ($('#sub_need_id').val() != '')
                        get_coutcome_need_list();
                }

                function get_sub_need_list() {
                    $('#sub_need_id').val('<option value="0">اختر..</option>');
                    $('#need_outcome_id').val('<option value="0">اختر..</option>');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: '{{url('report/get-sub-need')}}',
                        data: {
                            need_id: $('#need_id').val(),

                        },

                        success: function (data) {
                            if (data.success) {
                                $('#sub_need_id').html(data.html);

                            }

                        }


                    });
                }

                function get_coutcome_need_list() {
                    $('#need_outcome_id').val('<option value="0">اختر..</option>');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: '{{url('report/get-outcome-need')}}',
                        data: {
                            sub_need_id: $('#sub_need_id').val(),
                            account_type: $('#account_type').val()

                        },

                        success: function (data) {
                            if (data.success) {
                                $('#need_outcome_id').html(data.html);

                            }

                        }


                    });
                }

                function clearForm() {
                    $('#account_type').val('');
                    $('#need_id').val('');
                    $('#sub_need_id').val('');
                    $('#need_outcome_id').val('');
                    $('.select2').trigger('change');
                    $('#fromdate').datepicker('setDate', '');
                    $('#todate').datepicker('setDate', '');
                    $('#district_id').val('');
                    reloadvisitTable();
                }
            </script>
    @endpush
@stop
