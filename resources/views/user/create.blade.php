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
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>انشاء مستخدم جديد
                </div>
                {{--<div class="tools">
                    <a href="javascript:;" class="collapse"> </a>
                    <a href="#portlet-config" data-toggle="modal" class="config"> </a>
                    <a href="javascript:;" class="reload"> </a>
                    <a href="javascript:;" class="remove"> </a>
                </div>--}}
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                {{--  <form action="{{url('admin/user/'.$user_id)}}" class="form-horizontal" method="post">--}}
                {{Form::open(['url'=>url('/user'),'class'=>'form-horizontal','method'=>"post",'id'=>'user_form'])}}


                <div class="form-body">
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button>
                        يوجد خطأ في ادخال البيانات,يرجى التدقيق في القيم.
                    </div>
                    <div class="alert alert-success display-hide">
                        <button class="close" data-close="alert"></button>
                        تمت العملية بنجاح
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">الاسم<span class="required"> * </span></label>

                        <div class="col-md-4">
                            <div class="input-icon">
                                <i class="icon-user"></i>
                                <input name="name" type="text" class="form-control input-circle"
                                       placeholder="الاسم" value=""></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">البريد الإلكتروني<span class="required"> * </span></label>

                        <div class="col-md-4">
                            <div class="input-group">
                                    <span class="input-group-addon input-circle-left">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                <input name="email" type="email" class="form-control input-circle-right"
                                       placeholder="البريد الإلكتروني" value=""></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">كلمة المرور<span class="required"> * </span></label>

                        <div class="col-md-4">
                            <div class="input-group">
                                <input id="password" name="password" type="password"
                                       class="form-control input-circle-left"
                                       placeholder="كلمة المرور" value="">
                                <span class="input-group-addon input-circle-right">
                                                                            <i class="fa fa-user"></i>
                                                                        </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"> تأكيد كلمة المرور<span
                                class="required"> * </span></label>

                        <div class="col-md-4">
                            <div class="input-group">
                                <input name="confirm_password" type="password" class="form-control input-circle-left"
                                       placeholder="تأكيد كلمة المرور" value="">
                                <span class="input-group-addon input-circle-right">
                                                                            <i class="fa fa-user"></i>
                                                                        </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">المسمى الوظيفي<span class="required"> * </span></label>
                        <div class="col-md-4">
                            <select id="title_id" class="form-control select2 hselect" name="title_id" onchange="check_user()">
                                <option value="">اختر ..</option>
                                <?php

                                foreach ($titles as $title) {

                                    echo '<option value="' . $title->id . '">' . $title->lookup_cat_details . '</option>';
                                }

                                ?>

                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3 ">نوع المستخدم <span
                                class="required"> * </span></label>
                        <div class="col-md-4">
                            <select id="user_type" name="user_type" class="form-control select2 hselect ">
                                <option value="">اختر ..</option>
                                <option value="1">مدير النظام</option>
                                <option value="2">مشرف</option>
                                <option value="3">باحث</option>
                            </select>
                        </div>
                    </div>

                        <div class="form-group" id="superDV">
                            <label class="control-label col-md-3">المشرف</label>
                            <div class="col-md-4">
                                <select id="supervised_by" class="form-control select2 hselect" name="supervised_by">
                                    <option value="0">اختر ..</option>

                                </select>
                            </div>
                        </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">المحافظة<span
                                class="required"> * </span></label>
                        <div class="col-md-4">
                            <select id="district_id" class="form-control select2-multiple hselect" name="district_id[]" multiple>
                                <option value="">اختر ..</option>
                                <?php

                                foreach ($districts as $district) {

                                    echo '<option value="' . $district->id . '">' . $district->lookup_cat_details . '</option>';
                                }

                                ?>

                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">العنوان<span class="required"> * </span></label>
                        <div class="col-md-4">
                            <div class="input-icon  input-group col-md-12">
                                <i class="icon-home"></i>
                                <input name="address" type="text" class="form-control input-circle"
                                       placeholder="العنوان" value=""></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">جوال<span class="required"> * </span></label>

                        <div class="col-md-4">
                            <div class="input-icon  input-group col-md-12">
                                <i class="fa fa-mobile-phone"></i>
                                <input name="mobile" type="text" class="form-control input-circle"
                                       placeholder="جوال" value=""></div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="control-label col-md-3">صورة المستخدم</label>

                        <div class="col-md-9">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail"
                                     style="max-width: 200px; max-height: 150px;"></div>
                                <div>
                                    <span class="btn default btn-file">
                                        <span class="fileinput-new"> اختر الصورة </span>
                                        <span class="fileinput-exists"> تغيير </span>
                                        <input type="file" name="user_image" id="user_image"> </span>
                                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">
                                        حذف </a>
                                </div>
                            </div>
                            {{--  <div class="clearfix margin-top-10">
                                  <span class="label label-danger">NOTE!</span> Image preview only works in IE10+, FF3.6+, Safari6.0+, Chrome6.0+ and Opera11.1+. In older browsers the filename is shown instead. </div>--}}
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn btn-circle green">حفظ</button>
                            <a href="{{url('/user')}}"
                               class="btn btn-circle grey-salsa btn-outline">الغاء</a>
                        </div>
                    </div>
                </div>
            {{-- </form>--}}
            {{Form::close()}}
            <!-- END FORM-->
            </div>
        </div>
    </div>
    @push('css')
        <link href="{{url('')}}/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet"
              type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet"
              type="text/css"/>
        <link href="{{url('/')}}/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet"
              type="text/css"/>


        <link href="{{url('')}}/assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet"
              type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/jquery-file-upload/blueimp-gallery/blueimp-gallery.min.css"
              rel="stylesheet" type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet"
              type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet"
              type="text/css"/>
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
        <script src="{{url('/')}}/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"
                type="text/javascript"></script>

        <!-- END PAGE LEVEL PLUGINS -->
        <script src="{{url('')}}/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/jquery-file-upload/js/vendor/tmpl.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/jquery-file-upload/js/vendor/load-image.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/jquery-file-upload/js/vendor/canvas-to-blob.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/jquery-file-upload/blueimp-gallery/jquery.blueimp-gallery.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/jquery-file-upload/js/jquery.iframe-transport.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/jquery-file-upload/js/jquery.fileupload.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-process.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-image.js"
                type="text/javascript"></script>

        <script src="{{url('')}}/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-validate.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-ui.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/pages/scripts/form-fileupload.js" type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"
                type="text/javascript"></script>

        <script>
            var userFormValidation = function () {
                var handleValidation = function () {
                    // for more info visit the official plugin documentation:
                    // http://docs.jquery.com/Plugins/Validation

                    var form3 = $('#user_form');
                    var error3 = $('.alert-danger', form3);
                    var success3 = $('.alert-success', form3);

                    // Unique email
                    var response = true;
                    $.validator.addMethod(
                        "uniqueEmail",
                        function (value, element) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                type: "POST",
                                url: '{{url('/user/availabileEmail')}}',

                                data: {email: value},
                                error: function (xhr, status, error) {
                                    alert(xhr.responseText);
                                },
                                beforeSend: function () {
                                },
                                complete: function () {
                                },
                                success: function (data) {
                                    if (data.success == true)
                                        response = true;
                                    else
                                        response = false;
                                }
                            });//END $.ajax
                            return response;
                        },
                        "Email is Already Taken"
                    );
                    form3.validate({
                        errorElement: 'span', //default input error message container
                        errorClass: 'help-block help-block-error', // default input error message class
                        focusInvalid: false, // do not focus the last invalid input
                        ignore: "", // validate all fields including form hidden input
                        rules: {
                            name: {
                                required: true
                            },
                            email: {
                                email: true,
                                required: true,
                                uniqueEmail: true
                            },
                            password: {
                                required: true
                            },
                            confirm_password: {
                                required: true,
                                equalTo: "#password"

                            },
                             district_id: {
                                 required: true,

                             },
                            mobile: {
                                required: true,
                                number:true

                            },
                            address: {
                                required: true,

                            },
                            title_id: {
                                required: true,

                            },
                            user_type: {
                                required: true,

                            },

                        },

                        messages: { // custom messages for radio buttons and checkboxes
                            name: {
                                required: "هذه الحقل مطلوب,الرجاء ادخال قيمة",

                            },
                            email: {
                                required: "هذه الحقل مطلوب,الرجاء ادخال قيمة",
                                equalTo: "هذا الايميل مستخدم حاليا,يرجى التأكد من الايميل المدخل",
                                email: "يرجى التأكد من البريد الالكتروني",
                            },
                            password: {
                                required: "هذه الحقل مطلوب,الرجاء ادخال قيمة",
                            },
                            confirm_password: {
                                required: "هذه الحقل مطلوب,الرجاء ادخال قيمة",
                                equalTo: "كلمة المرور غير متطابقة,يرجى التاكد "
                            },
                           mobile: {
                                required: "هذه الحقل مطلوب,الرجاء ادخال قيمة",
                                number:"ارقام فقط 0-9"
                            },
                            address: {
                                required: "هذه الحقل مطلوب,الرجاء ادخال قيمة",

                            },
                            title_id: {
                                required: "هذه الحقل مطلوب,الرجاء اختيار قيمة",

                            },
                            user_type: {
                                required: "هذه الحقل مطلوب,الرجاء اختيار قيمة",

                            },
                            district_id: {
                                 required: "هذه الحقل مطلوب,الرجاء اختيار قيمة",

                             },
                        },

                        errorPlacement: function (error, element) { // render error placement for each input type
                            if (element.parents('.mt-radio-list') || element.parents('.mt-checkbox-list')) {
                                if (element.parents('.mt-radio-list')[0]) {
                                    error.appendTo(element.parents('.mt-radio-list')[0]);
                                }
                                if (element.parents('.mt-checkbox-list')[0]) {
                                    error.appendTo(element.parents('.mt-checkbox-list')[0]);
                                }
                            } else if (element.parents('.mt-radio-inline') || element.parents('.mt-checkbox-inline')) {
                                if (element.parents('.mt-radio-inline')[0]) {
                                    error.appendTo(element.parents('.mt-radio-inline')[0]);
                                }
                                if (element.parents('.mt-checkbox-inline')[0]) {
                                    error.appendTo(element.parents('.mt-checkbox-inline')[0]);
                                }
                            } else if (element.parent(".input-group").size() > 0) {
                                error.insertAfter(element.parent(".input-group"));
                            } else if (element.attr("data-error-container")) {
                                error.appendTo(element.attr("data-error-container"));
                            } else {
                                error.insertAfter(element); // for other inputs, just perform default behavior
                            }
                        },

                        invalidHandler: function (event, validator) { //display error alert on form submit
                            success3.hide();
                            error3.show();
                            App.scrollTo(error3, -200);
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
                            success3.show();
                            error3.hide();
                            App.scrollTo(success3, -200);
                            setTimeout(function () {
                                userSubmit();

                            }, 1000);
                        }

                    });

                    //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
                    $('.select2me', form3).change(function () {
                        form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
                    });

                    //initialize datepicker

                    $('.date-picker .form-control').change(function () {
                        form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
                    })
                }
                return {
                    //main function to initiate the module
                    init: function () {
                        handleValidation();

                    }

                };
            }();

            userFormValidation.init();

            function userSubmit() {

                var action = $('#user_form').attr('action');

                var formData = new FormData($('#user_form')[0]);
                $.ajax({
                        url: action,
                        type: 'POST',
                        dataType: 'json',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {

                            window.location.href = '{{url('').'/user'}}';
                        },
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

            function check_user() {

                if ($('#title_id').val() == 82 ||$('#title_id').val() == 177) {

                    $('#supervised_by').val('0').trigger('change');
                    $('#superDV').fadeIn();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: '{{url('user/get-supervisor')}}',
                        data: {title_id: $('#title_id').val()},

                        success: function (data) {
                            if (data.success) {
                                $('#supervised_by').html(data.html);
                            }

                        }
                    });
                }
                else {
                    $('#supervised_by').val('0').trigger('change');
                    $('#superDV').fadeOut();
                    $('#supervised_by').html('<option value="0">اختر ..</option>');
                    // $('#supervised_by').select(0);

                }


            }
        </script>
    @endpush
@stop
