@extends('admin.layout.index')
@section('content')
    <div class="page-content">
        <meta name="csrf-token" content="{{ csrf_token()}}">
        <h1 class="page-title"> {{$title}}
            <small>{{$page_title}}</small>
        </h1>
        <div class="page-bar">
            @include('admin.layout.breadcrumb')

        </div>
        <div class="row">
            <div class="col-md-12 ">
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption font-red-sunglo">
                            <i class="icon-settings font-red-sunglo"></i>
                            <span class="caption-subject bold uppercase">معايير البحث</span>
                        </div>

                    </div>
                    <div class="portlet-body form">
                        <form role="form" class="form-horizontal">
                            <div class="form-body">
                                <div class="row ">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">الموظف</label>
                                                <div class="col-md-8">
                                                    <select id="user_id" class="form-control select2" name="user_id">
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">التاريخ </label>
                                                <div class="col-md-4">
                                                    <div class="input-group input-large date-picker input-daterange"
                                                         data-date="10/11/2012" data-date-format="yyyy/mm/dd">
                                                        <input type="text" class="form-control" name="from" id="from">
                                                        <span class="input-group-addon"> الى </span>
                                                        <input type="text" class="form-control" name="to" id="to"></div>
                                                    <!-- /input-group -->
                                                    {{--  <span class="help-block"> Select date range </span>--}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class=" col-md-4">
                                                <button type="button" class="btn green" onclick="view_Report();">عرض
                                                </button>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </form>
                    </div>
                </div>
                <!-- END SAMPLE FORM PORTLET-->

            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase"> {{$page_title}}</span>
                        </div>

                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
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
                        </div>
                        <table class="table table-striped table-bordered table-hover table-checkable order-column"
                               id="report_tbl">
                            <thead>
                            <tr>
                                <th> #</th>
                                <th> الاسم</th>
                                <th>كود الموظف</th>
                                <th>المسمى الوظيفي</th>
                                <th>تاريخ الحركة</th>
                                <th> ساعة الحضور</th>
                                <th> ساعة الانصراف</th>
                                  <th>عدد الساعات</th>

                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
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
                height: 1%;

            }
        </style>
        <link href="{{url('')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css"
              rel="stylesheet" type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"
              rel="stylesheet" type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"
              rel="stylesheet" type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"
              rel="stylesheet" type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css"/>

    @endpush
    @push('js')
        <script src="{{url('')}}/assets/global/plugins/select2/js/select2.full.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/pages/scripts/components-select2.js"
                type="text/javascript"></script>
        {{--<script>
            $(document).ready(function() {
                $('#attendance_date').datepicker({
                    beforeShow: function(input, inst)
                    {
                        $.datepicker._pos = $.datepicker._findPos(input); //this is the default position
                        $.datepicker._pos[0] = whatever; //left
                        $.datepicker._pos[1] = whatever; //top
                    }
                });
            })
        </script>--}}

        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{url('')}}/assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{url('')}}/assets/pages/scripts/components-date-time-pickers.min.js"
                type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- END PAGE LEVEL PLUGINS -->
        <script>

            /*  $(function() {
                  $('#form_datetime').datepicker({ dateFormat: 'yyy-dd-mm HH:MM:ss' }).val();
              });*/
            //  $("#datepicker").datepicker("option", "dateFormat", "yy-mm-dd ");
        </script>

        <script>


            function view_Report() {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#report_tbl').DataTable().destroy();

                //  var form = $('#report_form');
                // alert(attend_date)
                $('#report_tbl').dataTable({

                    'processing': true,
                    'serverSide': true,
                    buttons: [
                        {
                            extend: 'excel',
                            className: 'btn yellow btn-outline ',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6,7]
                            }
                        }

                    ],
                    "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable

                    'ajax': {
                        "type": "post",
                        "url": "attendance-data",

                        "data": {
                            'from': $('#from').val(),
                            'to': $('#to').val(),
                            'user_id': $('#user_id').val(),

                        }
                        ,

                    },


                    'columns': [
                        {data: 'num', name: 'num'},
                        {data: 'user_id', name: 'user_id'},
                        {data: 'user_name', name: 'user_name'},
                        {data: 'title_desc', name: 'title_desc'},
                        {data: 'attendance_date', name: 'attendance_date'},
                        {data: 'attend_time', name: 'attend_time'},
                        {data: 'leave_time', name: 'leave_time'},
                         {data: 'total_hour', name: 'total_hour'},

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

                $('.buttons-excel').addClass('hidden');
                $('.button-excel2').click(function () {
                    $('.buttons-excel').click()
                });

            }


        </script>
    @endpush
@stop
