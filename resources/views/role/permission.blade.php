@extends('admin.layout.index')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token()}}">
    <div class="page-content">
        <h1 class="page-title"> {{$title}}
            <small>{{$page_title}}</small>
        </h1>
        <div class="page-bar">
            @include('admin.layout.breadcrumb')

        </div>
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>واجهات النظام</div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"> </a>

                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                {{--  <form action="{{url('admin/user/'.$user_id)}}" class="form-horizontal" method="post">--}}
                {{Form::open(['url'=>url('storePermission'),'class'=>'form-horizontal','method'=>"post","id"=>"perm_form"])}}

                <div class="form-body">
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button>
                        يوجد خطأ في ادخال البيانات,يرجى فحص القيم المدخلة
                    </div>
                    <div class="alert alert-success display-hide">
                        <button class="close" data-close="alert"></button>
                        تمت عملية الحفظ بنجاح!
                    </div>
                    <input id="hdn_permission_id" name="hdn_permission_id" type="hidden" value="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">اسم الشاشة
                                    <span class="required"> * </span></label>
                                <div class="col-md-6">
                                    <div class="input-icon">
                                        <i class="icon-user"></i>
                                        <input id="display_name" name="display_name" type="text" class="form-control "
                                               placeholder="اسم الشاشة" value=""></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">القائمة
                                    <span class="required"> * </span></label>
                                <div class="col-md-6 ">
                                    <div class="input-group">
                                        <select id="menu_id" name="menu_id" class="form-control select2 ">

                                            <option value="">اختر قائمة</option>

                                            <?php

                                            foreach ($menus as $menu) {

                                                echo '<option value="' . $menu->id . '">' . $menu->menu_name . '</option>';
                                            }

                                            ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">الرابط
                                    <span class="required"> * </span></label>
                                <div class="col-md-6">
                                    <div class="input-icon">
                                        <i class="icon-link"></i>
                                        <input id="screen_link" name="screen_link" type="text" class="form-control "
                                               placeholder="الرابط" value=""></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">ترتيب الشاشة
                                    <span class="required"> * </span></label>
                                <div class="col-md-6 ">
                                    <input id="screen_order" name="screen_order" type="number" class="form-control input"
                                           placeholder="" value="0" min="0"></div>
                        </div>
                    </div>
                </div>
                </div>
                <div class="form-actions left">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="col-md-1">
                            <button id="btnSave" name="btnSave" type="submit" class="btn green">حفظ</button></div>
                            <div class="col-md-1">
                                <button id="btnCancel" type="button" class="btn  btn-danger  btn-outline" style="display: none" onclick="clearForm()">الغاء الامر</button></div>
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
                    <i class="fa fa-gift"></i>جدول واجهات النظام
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

                            <th> كود </th>
                            <th> الاسم </th>
                            <th>القائمة </th>
                            <th>الرابط </th>
                            <th>الترتيب </th>
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
               'ajax': '{{url('/permission-data')}}',
               'columns': [

                   {data: 'id', name: 'id'},
                   {data: 'display_name', name: 'display_name'},
                   {data:'menu_desc',name:'menu_desc'},
                   {data:'screen_link',name:'screen_link'},
                   {data:'screen_order',name:'screen_order'},
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
                       "previous":"Prev",
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

        var permFormValidation = function () {

            // basic validation
            var handleValidation1 = function () {
                // for more info visit the official plugin documentation:
                // http://docs.jquery.com/Plugins/Validation

                var form1 = $('#perm_form');
                var error1 = $('.alert-danger', form1);
                var success1 = $('.alert-success', form1);
                // Unique email


                form1.validate({
                    errorElement: 'span', //default input error message container
                    errorClass: 'help-block help-block-error', // default input error message class
                    focusInvalid: false, // do not focus the last invalid input
                    ignore: "",  // validate all fields including form hidden input

                    rules: {

                        display_name: {
                            required: true,

                        },
                        menu_id: {
                            required: true,

                        },
                        screen_link: {
                            required: true,

                        },
                        screen_order: {
                            required: true,
                            minlength: 0

                        }


                    },

                    messages: { // custom messages for radio buttons and checkboxes
                        display_name: {
                            required: "هذه الحقل مطلوب,الرجاء ادخال قيمة",
                        },
                        menu_id: {
                            required: "هذه الحقل مطلوب,الرجاء ادخال قيمة",
                        },
                        screen_link: {
                            required: "هذه الحقل مطلوب,الرجاء ادخال قيمة",

                        },
                        screen_order: {
                            required: "هذه الحقل مطلوب,الرجاء ادخال قيمة",
                            minlength: "القيمة المدخلة جيب ان تكون اكبر من 0 "
                        }


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

                        permSubmit();


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

        permFormValidation.init();

        function permSubmit() {

            var form1 = $('#perm_form');
            var error = $('.alert-danger', form1);
            var success = $('.alert-success', form1);

            var action = $('#perm_form').attr('action');

            var formData = new FormData($('#perm_form')[0]);

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
                                window.location.href = '{{url('/permission')}}';

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
        function permDelete(id) {

            var form1 = $('#perm_form');
            var error = $('.alert-danger', form1);
            var success = $('.alert-success', form1);


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                    type: "POST",
                    url: '{{url('deletePermission')}}',
                    data: {id:id},

                    success:

                        function (data) {
                            if (data.success) {

                                success.show();
                                error.hide();
                                App.scrollTo(success, -200);
                                success.fadeOut(2000);
                                window.location.href = '{{url('/permission')}}';

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
        function fillForm(id,name,menu,link,order)
        {
            $('#hdn_permission_id').val(id);
            $('#display_name').val(name);
            $('#menu_id').val(menu).trigger('change');;
            $('#screen_link').val(link);
            $('#screen_order').val(order);
            $('#btnSave').html('تعديل');
            $('#btnCancel').css("display", "block");


        }
        function clearForm()
        {
            $('#hdn_permission_id').val('');
            $('#display_name').val('');
            $('#menu_id').val('').trigger('change');;
            $('#screen_link').val('');
            $('#screen_order').val(0);
            $('#btnSave').html('اضافة');
            $('#btnCancel').css("display", "none");


        }
    </script>
    @endpush
@stop
