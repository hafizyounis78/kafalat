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
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>{{$title}}</div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"> </a>

                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                {{--  <form action="{{url('admin/user/'.$user_id)}}" class="form-horizontal" method="post">--}}
                {{Form::open(['url'=>url('storeRole'),'class'=>'form-horizontal','method'=>"post","id"=>"role_form"])}}

                <div class="form-body">
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button>
                        يوجد خطأ في ادخال البيانات,يرجى فحص القيم المدخلة
                    </div>
                    <div class="alert alert-success display-hide">
                        <button class="close" data-close="alert"></button>
                        تمت عملية الحفظ بنجاح!
                    </div>
                    <input id="hdn_role_id" name="hdn_role_id" type="hidden" value="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">الفئة</label>
                                <div class="col-md-9">
                                    <div class="input-icon">
                                        <i class="icon-user"></i>
                                        <input id="role_name" name="role_name" type="text" class="form-control"
                                               placeholder="الوصف" value=""></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-2">
                                <button id="btnSave" type="submit" class="btn  btn-primary">أضافة</button>
                            </div>
                            <div class="col-md-2">
                                <button id="btnCancel" type="button" class="btn  btn-danger" style="display: none"
                                        onclick="clearForm()">الغاء الامر
                                </button>
                            </div>
                        </div>
                    </div>


                </div>

            {{-- </form>--}}
            {{Form::close()}}
            <!-- END FORM-->
            </div>
        </div>

        <div class="portlet box yellow-casablanca">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>جدول فئات المستخدمين
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"> </a>

                </div>
            </div>
            <div class="portlet-body form">
                <div class="form-body">
                    <table class="table table-striped table-bordered table-hover  order-column" id="role_tbl">
                        <thead>
                        <tr>

                            <th> كود</th>
                            <th> الفئة</th>
                            <th>تحكم</th>

                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </div>
    @push('css')
        <link href="{{url('')}}/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet"
              type="text/css"/>
    @endpush
    @push('js')
        <script src="{{url('')}}/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <script src="{{url('')}}/assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>
        <script>

            $(document).ready(function () {
                $('#role_tbl').dataTable({

                    'processing': true,
                    'serverSide': true,
                    'ajax': '{{url('/role-data')}}',
                    'columns': [

                        {data: 'id', name: 'id'},
                        {data: 'name', name: 'name'},
                        {data: 'action', name: 'action'}
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
            })
        </script>
        <script src="{{url('')}}/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"
                type="text/javascript"></script>
        <script type="text/javascript">

            var taskFormValidation = function () {

                // basic validation
                var handleValidation1 = function () {
                    // for more info visit the official plugin documentation:
                    // http://docs.jquery.com/Plugins/Validation

                    var form1 = $('#role_form');
                    var error1 = $('.alert-danger', form1);
                    var success1 = $('.alert-success', form1);
                    // Unique email


                    form1.validate({
                        errorElement: 'span', //default input error message container
                        errorClass: 'help-block help-block-error', // default input error message class
                        focusInvalid: false, // do not focus the last invalid input
                        ignore: "",  // validate all fields including form hidden input

                        rules: {

                            role_name: {
                                required: true,

                            },


                        },

                        messages: { // custom messages for radio buttons and checkboxes
                            role_name: {
                                required: "هذه الحقل مطلوب,الرجاء ادخال قيمة",
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

                            roleSubmit();


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


            taskFormValidation.init();

            function roleSubmit() {

                var form1 = $('#role_form');
                var error = $('.alert-danger', form1);
                var success = $('.alert-success', form1);

                var action = $('#role_form').attr('action');

                var formData = new FormData($('#role_form')[0]);

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
                                    window.location.href = '{{url('/role')}}';

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

            function roleDelete(id) {

                var form1 = $('#role_form');
                var error = $('.alert-danger', form1);
                var success = $('.alert-success', form1);

                var x = '';
                var r = confirm('سيتم حذف القيمة ,هل انت متاكد من ذلك؟');
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
                            url: '{{url('deleteRole')}}',
                            data: {id: id},

                            success:

                                function (data) {
                                    if (data.success) {

                                        success.show();
                                        error.hide();
                                        App.scrollTo(success, -200);
                                        success.fadeOut(2000);
                                        window.location.href = '{{url('/role')}}';

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
            }

            function fillForm(id, name) {
                $('#hdn_role_id').val(id);
                $('#role_name').val(name);
                $('#btnSave').html('تعديل');
                $('#btnCancel').css("display", "block");


            }

            function clearForm(id, name) {
                $('#hdn_role_id').val('');
                $('#role_name').val('');
                $('#btnSave').html('اضافة');
                $('#btnCancel').css("display", "none");


            }
        </script>
    @endpush
@stop
