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
        <div class="portlet box blue-hoki">
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

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label col-md-3">التاريخ </label>
                                    <div class="col-md-9">
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
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="control-label col-md-4">حالة التقرير</label>
                                    <div class="col-md-8">
                                        <select id="reportStatus" class="form-control select2 hselect"
                                                name="reportStatus">
                                            <option value="">اختر ..</option>
                                            <?php

                                            foreach ($reportStatus as $value) {

                                                echo '<option value="' . $value->id . '">' . $value->lookup_cat_details . '</option>';
                                            }

                                            ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label col-md-4"> التقاير</label>
                                    <div class="col-md-8">
                                        <select id="all_report" class="form-control select2"
                                                name="all_report">
                                            <option value="1">اخر تقرير</option>
                                            <option value="2">جميع التقارير</option>

                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
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
                        </div>
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
                                <div class="col-md-3">
                                    <div class="btn-group">
                                        <button type="button" class="btn purple-plum" title="بحث"
                                                onclick="reloadvisitTable()">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                {{--<div class="col-md-3">
                                    <div class="btn-group">
                                        <button class="btn green-meadow button-excel2 " title="أكسل"
                                                id="btn-excel">
                                            <i class="fa fa-file-excel-o"></i>
                                        </button>
                                    </div>
                                </div>--}}
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
                    class="table table-striped table-bordered table-hover table-checkable order-column"
                    id="report1_tbl">
                    <thead>
                    <tr>
                        <th width="5%"> #</th>
                        <th width="30%"> اســــــــــــــــم المســتفــيد</th>
                        <th width="10%"> رقم الهوية</th>
                        <th width="5%"> نوع الحساب</th>
                        <th width="5%"> المدينة</th>
                        {{--   <th width="10%"> جوال</th>--}}
                        <th width="5%"> تاريخ الزيارة</th>
                        <th width="5%"> نوع الزيارة</th>
                        <th width="15%"> حالة التقرير</th>
                        <th width="10%"> اسم الباحث</th>
                        <th width="5%"> رقم الكفالة</th>
                        <th width="5%">تحكم</th>
                    </tr>
                    </thead>
                </table>
            </div>


        </div>
        <div class="modal fade bs-modal-lg" id="reportModal" tabindex="-1" role="dialog" aria-hidden="true">
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
                                <div class="portlet box blue">
                                    <div class="portlet-title">
                                        <div class="caption">حالة التقرير
                                            <i class="fa fa-comments"></i>
                                        </div>

                                    </div>

                                    <div class="portlet-body">
                                        <div class="">
                                            <table class="table table-bordered table-hover" id="report_status_tb">
                                                <thead>
                                                <tr>
                                                    <th> #</th>
                                                    <th> تاريخ</th>
                                                    <th> الحالة</th>
                                                    <th>سبب الرفض</th>
                                                    <th> الموظف</th>

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

                    var name = $('#name').val();
                    var ben_id = $('#ben_id').val();
                    //  var visit_type = $('#visit_type').val();
                    var account_type = $('#account_type').val();
                    var visit_by = $('#visit_by').val();
                    var fromdate = $('#fromdate').val();
                    var todate = $('#todate').val();
                    var district_id = $('#district_id').val();
                    var reportStatus = $('#reportStatus').val();
                    var sponser_id = $('#param_sponser_id').val();
                    var beneficiary_id = $('#param_beneficiary_id').val();
                    var all_report = $('#all_report').val();
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
                            "url": '{{url('/filter-enquiry-data')}}',

                            "data": {
                                'ben_id': ben_id,
                                'name': name,
                                'visit_by': visit_by,
                                'account_type': account_type,
                                'all_report': all_report,
                                'fromdate': fromdate,
                                'todate': todate,
                                'district_id': district_id,
                                'sponser_id': sponser_id,
                                'reportStatus': reportStatus,
                                'beneficiary_id': beneficiary_id

                            }
                            ,

                        },

                        /* "initComplete": function (settings, json) {
                             $('.buttons-excel').trigger("click");
                         },*/
                        /*
                         <th width="5%"> #</th>
                        <th width="30%"> الاسم</th>
                        <th width="10%"> رقم الهوية</th>
                        <th width="5%"> نوع الحساب</th>
                        <th width="5%"> المدينة</th>
                     {{--   <th width="10%"> جوال</th>--}}
                        <th width="5%"> تاريخ الزيارة</th>
                        <th width="5%"> نوع الزيارة</th>
                        <th width="15%"> حالة التقرير</th>
                        <th width="10%"> اسم الباحث</th>
                        <th width="5%"> رقم الكفالة</th>
                        <th width="5%">عرض جميع الحركات</th>
                        */
                        'columns': [
                            {data: 'num', name: 'num'},
                            {data: 'full_name', name: 'full_name', orderable: true},
                            {data: 'beneficiary_identity', name: 'beneficiary_identity', orderable: true},
                            {data: 'account_name', name: 'account_name',},
                            {data: 'city_name', name: 'city_name', orderable: true},
                            /*  {data: 'mobile_no', name: 'mobile_no', width: '10%', orderable: true},*/
                            {data: 'visit_date', name: 'references_list.visit_date'},
                            {data: 'visit_name', name: 'visit_name'},
                            {data: 'report_status', name: 'report_status', orderable: true},
                            {data: 'user_name', name: 'user_name', orderable: true},
                            {data: 'sponser_id', name: 'sponser_id', orderable: true},
                            {data: 'action', name: 'action'},
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


                function getAllReportStatus(referance_key) {


                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });


                    $('#report_status_tb').DataTable().destroy();
                    $.fn.dataTable.ext.errMode = 'none';
                    $('#report_status_tb').on('error.dt', function (e, settings, techNote, message) {
                        console.log('An error has been reported by DataTables: ', message);
                    })

                    $('#report_status_tb').dataTable({

                        'processing': true,
                        'serverSide': true,
                        'ajax': {
                            "type": "post",
                            "url": '{{url('/report/get-report-status-byReference')}}',//"s2-details-data",

                            "data": {
                                'referance_key': referance_key
                            }
                            ,

                        },


                        'columns': [

                            {data: 'id', name: 'id'},
                            {data: 'created_at', name: 'created_at'},
                            {data: 'report_status', name: 'report_status'},
                            {data: 'reject_reason', name: 'reject_reason'},
                            {data: 'user_name', name: 'user_name'},
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
                    $('#all_report').val(1);
                    $('#reportStatus').val('');

                    reloadvisitTable();
                }
            </script>
    @endpush
@stop
