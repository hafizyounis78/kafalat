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

                {{Form::open(['url'=>url('run_rep'),'class'=>'form-horizontal','method'=>"post","id"=>"setting_form"])}}
                <div class="form-body">
                    <div class="row">

                        <div class="col-md-5">
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label col-md-4">الباحث</label>
                                <div class="col-md-8">
                                    <select id="visit_by" class="form-control select2"
                                            name="visit_by">
                                        <option value="0">جميع الموظفين</option>
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
                                <label class="control-label col-md-4">التقارير</label>
                                <div class="col-md-8">
                                    <select id="report_id" class="form-control select2"
                                            name="report_id">
                                        <option value="">اختر التقرير</option>
                                        <option value="1">تقرير احصائي بأنواع التقارير</option>
                                        <option value="2">تقرير احصائي بنشاطات الباحثين</option>
                                        <option value="3">تقرير حضور وانصراف الموظفين</option>


                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn btn-circle green">طباعة التقرير</button>
                            <button type="button" class="btn btn-circle blue" onclick="view_report();">عرض التقرير
                            </button>
                            <button type="button" class="btn btn-circle grey-salsa btn-outline" onclick="clearForm()">
                                مسح
                            </button>
                        </div>
                    </div>
                </div>


                {{Form::close()}}
            </div>
        </div>
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>عرض التقرير
                </div>
                <!--<div class="tools">
                    <a href="javascript:;" class="collapse"> </a>

                </div>-->
            </div>
            <div class="portlet-body form">
                <div class="form-body" id="report_table">

                </div>
            </div>
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
            /*$(function() {
                $("#rep1").on("click",function(e) {
                    e.preventDefault(); // cancel the link itself

                   $.post(this.href,function(data) {
                        $("#someContainer").html(data);
                    });
                   alert('dd');
                    var fromdate = $('#fromdate').val();
                    var todate = $('#todate').val();
                    var visit_by = $('#visit_by').val();

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: '{{url('/run_rep')}}',
                            data: {
                                id: id,
                                fromdate: fromdate,
                                todate: todate,
                                visit_by: visit_by
                            },

                            success: function (data) {
                                if (data.success) {
                                    // window.open(url('rep1'))

                                }

                            }


                        });
                    });
                });*/
            function view_report() {
                var fromdate = $('#fromdate').val();
                var todate = $('#todate').val();
                var visit_by = $('#visit_by').val();
                var report_id = $('#report_id').val();
                $('#report_table').html('');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: '{{url('/run_rep_view')}}',
                    data: {
                        fromdate: fromdate,
                        todate: todate,
                        visit_by: visit_by,
                        report_id: report_id
                    },

                    success: function (data) {
                        if (data.success) {
                            $('#report_table').html(data.html);

                        } else {
                            $('#report_table').html('No records');
                        }

                    }


                });
            }

            function clearForm() {
                $('#visit_by').val('');
                $('#report_id').val('');
                $('.select2').trigger('change');
                $('#fromdate').datepicker('setDate', '');
                $('#todate').datepicker('setDate', '');
            }
        </script>
    @endpush
@stop
