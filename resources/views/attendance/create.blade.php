@extends('admin.layout.index')
@section('content')
    <div class="page-content">
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
                            <span class="caption-subject bold uppercase">{{$page_title}}</span>
                        </div>
                        <div class="actions">

                        </div>
                    </div>
                    <div class="portlet-body form">
                        {{Form::open(['url'=>url('attendance'),'class'=>'form-horizontal','role'=>'form','method'=>"post","id"=>"attendance_form"])}}
                            <div class="form-body">
                                <div class="alert alert-danger display-hide">
                                    <button class="close" data-close="alert"></button>
                                    يوجد خطأ في ادخال البيانات,يرجى فحص القيم المدخلة
                                </div>
                                <div class="alert alert-success display-hide">
                                    <button class="close" data-close="alert"></button>
                                    تمت عملية الحفظ بنجاح!
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">الموظف</label>
                                    <div class="col-md-4">
                                        <select id="multiple" class="form-control select2" name="emp_id">

                                        <?php

                                        foreach ($emp as $e) {

                                            echo '<option value="' . $e->emp_id . '">' . $e->name . '</option>';
                                        }

                                        ?>

                                    </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">التاريخ</label>
                                    <div class="col-md-4">
                                        <div class="margin-bottom-5">
                                            <input type="text" class="form-control form-filter input-sm date-picker"
                                                   id="attend_date" name="attend_date" placeholder="From" data-date-format="yyyy-mm-dd"/>
                                        </div>
                                    </div>
                                          {{--  <input type="text" class="form-control form-filter input-sm date-picker" id="txtTo" name="txtTo" placeholder="To" data-date-format="dd/mm/yyyy"//>--}}
                                </div>
                                    <!--/span-->
                                <div class="form-group">
                                    <label class="control-label col-md-3"> الحضور</label>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <input type="text" class="form-control timepicker timepicker-24" id="in_time" name="in_time">
                                            <span class="input-group-btn">
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-clock-o"></i>
                                                    </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3"> الانصراف</label>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <input type="text" class="form-control timepicker timepicker-24" id="out_time" name="out_time">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-clock-o"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-actions left">
                                <div class="row">
                                    <div class="col-md-9">
                                        <button type="submit" class="btn  green">حفظ</button>
                                        <a href="{{url('/attendance')}}"
                                           class="btn  grey-salsa btn-outline">عودة</a>
                                    </div>
                                </div>
                            </div>
                        {{Form::close()}}
                          {{--  <div class="form-body form">
                                <div class="form-group">
                                    <label for="multiple" class="control-label col-md-3">المحامي</label>
                                    <div class="col-md-3">
                                        <select id="multiple" class="form-control select2">

                                            <option value="NC">ا.اكرم الشيخ خليل</option>
                                            <option value="OH">أ.ايمن القانوع</option>
                                            <option value="PA">أ.فتحي مكي</option>
                                            <option value="RI">أ.حسين صبحي</option>
                                            <option value="SC">أ.جمال ابو حصيرة</option>
                                            <option value="VT">أ.رائد سكر</option>
                                            <option value="VA">أ.محمد يونس</option>
                                            <option value="WV">أ.احمد عادل</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">تاريخ اليوم</label>
                                    <div class="col-md-3">
                                        <div class="input-group input-medium date date-picker"
                                             data-date-format="dd-mm-yyyy" data-date-start-date="+0d">
                                            <input type="text" class="form-control" readonly>
                                            <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                                        </div>

                                    </div>
                                </div>


                            </div>
                            <div class="form-actions " >
                                <button type="button" class="btn btn-sm green" onclick="get_report()">
                                    <i class="fa fa-search"></i> بـحـث</button>
                                <button type="button" class="btn btn-sm red">
                                    <i class="fa fa-times"></i> مـسـح</button>
                            </div>--}}


                    </div>
                </div>
                <!-- END SAMPLE FORM PORTLET-->

            </div>

        </div>
       {{-- <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase"> جدول الحضور والإنصراف</span>
                        </div>

                    </div>
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        --}}{{--  <form action="{{url('admin/user/'.$user_id)}}" class="form-horizontal" method="post">--}}{{--

                    <!-- END FORM-->
                    </div>
                    <div class="portlet-body">


                        <table class="table table-striped table-bordered table-hover table-checkable order-column"
                               id="users_tbl">
                            <thead>
                            <tr>
                                <th> #</th>
                                <th> الاسم</th>
                                <th> رقم الهوية</th>
                                <th>الوظيفه</th>
                                <th> ساعة الحضور</th>
                                <th> ساعة الانصراف</th>

                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>--}}
    </div>
    @push('css')

        <link href="{{url('')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css"
              rel="stylesheet" type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"
              rel="stylesheet" type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"
              rel="stylesheet" type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"
              rel="stylesheet" type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/clockface/css/clockface.css" rel="stylesheet"
              type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet"
              type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet"
              type="text/css"/>
        <style>
            .datepicker.datepicker-rtl {

                max-width: 200px;
            }
        </style>
    @endpush
    @push('js')
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
        <script src="{{url('')}}/assets/global/plugins/select2/js/select2.full.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/pages/scripts/components-select2.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"
                type="text/javascript"></script>
        <script>

            /*$(".date-picker").datetimepicker({
                format: 'yyyy-mm-dd hh:ii',
                autoclose: true,
                //todayBtn: true,
                //pickerPosition: "bottom-left"
            });*/
        </script>

        <script>
            var attendanceFormValidation = function () {

                // basic validation
                var handleValidation1 = function () {
                    // for more info visit the official plugin documentation:
                    // http://docs.jquery.com/Plugins/Validation

                    var form1 = $('#attendance_form');
                    var error1 = $('.alert-danger', form1);
                    var success1 = $('.alert-success', form1);
                    // Unique email


                    form1.validate({
                        errorElement: 'span', //default input error message container
                        errorClass: 'help-block help-block-error', // default input error message class
                        focusInvalid: false, // do not focus the last invalid input
                        ignore: "",  // validate all fields including form hidden input
                        messages: {
                            select_multi: {
                                maxlength: jQuery.validator.format("Max {0} items allowed for selection"),
                                minlength: jQuery.validator.format("At least {0} items must be selected")
                            }
                        },
                        rules: {

                            emp_id: {
                                required: true,

                            },
                            attend_date: {
                                required: true,
                            },
                            in_time: {
                                required: true,

                            },
                            out_time:{
                                required:true,
                            }

                        },

                        messages: { // custom messages for radio buttons and checkboxes
                            emp_id: {
                                required: "هذا الحقل مطلوب,الرجاء ادخال قيمة",
                            },
                            attend_date: {
                                required: "هذا الحقل مطلوب,الرجاء ادخال قيمة",
                            },
                            in_time: {
                                required: "هذا الحقل مطلوب,الرجاء ادخال قيمة",

                            },
                            out_time: {
                                required: "هذا الحقل مطلوب,الرجاء ادخال قيمة",
                            },


                        },

                        invalidHandler: function (event, validator) { //display error alert on form submit
                            success1.hide();
                            error1.show();
                            App.scrollTo(error1, -200);
                        },

                        errorPlacement: function (error, element) { // render error placement for each input type
                            var cont = $(element).parent('.input-group');
                            if (cont) {
                                cont.after(error);
                            } else {
                                element.after(error);
                            }
                        },

                        highlight: function (element) { // hightlight error inputs

                            $(element)
                                .closest('.form-group').addClass('has-error'); // set error class to the control group
                        },

                        unhighlight: function (element) { // revert the change done by hightlight
                            $(element)
                                .closest('.form-group').removeClass('has-error'); // set error class to the control group
                        },

                        success: function (label) {
                            label
                                .closest('.form-group').removeClass('has-error'); // set success class to the control group
                        },

                        submitHandler: function (form) {

                            attendanceSubmit();


                        }
                    });


                }


                return {
                    //main function to initiate the module
                    init: function () {


                        handleValidation1();


                    }

                };

            }();


            attendanceFormValidation.init();

            function attendanceSubmit() {

                var form1 = $('#attendance_form');
                var error = $('.alert-danger', form1);
                var success = $('.alert-success', form1);

                var action = $('#attendance_form').attr('action');

                var formData = new FormData($('#attendance_form')[0]);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                        url: action,
                        type: 'POST',
                        dataType: 'json',
                        data: formData,

                        processData:
                            false,
                        contentType:
                            false,
                        success:

                            function (data) {
                                if (data.success) {

                                    success.show();
                                    error.hide();
                                    App.scrollTo(success, -200);
                                    success.fadeOut(2000);

                                    //window.location.href = '{{url('/attendance')}}';
                                }
                                else {
                                    success.hide();
                                    error.show();
                                    App.scrollTo(error, -200);
                                    error.fadeOut(2000);
                                }


                            }

                        ,
                        error: function (err) {

                            console.log(err);
                        }
                        /*  error:function(err){
                              console.log(err);

                          }*/
                    }
                )
                //   });
            }
        </script>
    @endpush;

@stop
