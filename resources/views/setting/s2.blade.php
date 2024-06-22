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
        <div class="portlet box green" id="addDv">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>{{$title}}</div>
                <div class="tools">
                   {{-- <a href="javascript:;" class="collapse"> </a>--}}

                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                {{--  <form action="{{url('admin/user/'.$user_id)}}" class="form-horizontal" method="post">--}}
                {{Form::open(['url'=>url('setting/s2-save'),'class'=>'form-horizontal','method'=>"post","id"=>"setting_form"])}}
                <input type="hidden" id="hdn_table_id" name="hdn_table_id" value="{{''}}">
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
                        <label class="col-md-3 control-label">الاسم</label>
                        <div class="col-md-4">
                            <div class="col-md-12 ">

                                <input name="lookup_cat_details" id="lookup_cat_details" type="text"
                                       class="form-control"
                                       placeholder="الاسم" value=""></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">النوع</label>
                        <div class="col-md-4">
                            <div class=" col-md-12 ">

                                <input name="lookup_type" id="lookup_type" type="text" class="form-control"
                                       placeholder="النوع" value=""></div>
                        </div>
                    </div>
                </div>
                <div class="form-actions left">
                    <div class="row">
                        <div class=" col-md-9">
                            <button type="submit" class="btn green">حفظ</button>
                            <button type="button" onclick="clearForm()" class="btn  red-intense">الغاء</button>

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
                    <i class="fa fa-gift"></i>جدول الثوابت
                </div>
                <div class="tools">
                    <button type="button" onclick="openDv()" class="btn btn-icon-only blue-madison">
                        <i class="fa fa-plus"></i></button>

                </div>
            </div>
            <div class="portlet-body form">
                <div class="form-body">
                    <table class="table table-striped table-bordered table-hover  order-column" id="setting_tbl">
                        <thead>
                        <tr>

                            <th> كود</th>
                            <th> الاسم</th>
                            <th> الاب</th>
                            <th> النوع</th>
                            <th>تحكم</th>

                        </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>

    </div>
    <div class="modal fade bs-modal-lg" id="detailModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true"></button>
                    <h4 class="modal-title">اضافة القيم الفرعية </h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN SAMPLE TABLE PORTLET-->
                            <div class="portlet box green">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-gift"></i>القيم الفرعية
                                    </div>
                                    <div class="tools">
                                       {{-- <a href="javascript:;" class="collapse"> </a>--}}

                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                    {{--  <form action="{{url('admin/user/'.$user_id)}}" class="form-horizontal" method="post">--}}
                                    {{Form::open(['url'=>url('/setting/save-lookup-detail'),'class'=>'form-horizontal','method'=>"post","id"=>"detail_form"])}}
                                    <input type="hidden" id="hdn_dtable_id" name="hdn_dtable_id" value="{{''}}">
                                    <input type="hidden" id="hdn_lookup_id" name="hdn_lookup_id" value="{{''}}">
                                    <input type="hidden" id="hdn_cat_type" name="hdn_cat_type" value="{{''}}">

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
                                            <label class="col-md-3 control-label">الاسم</label>
                                            <div class="col-md-4">
                                                <div class="col-md-12 ">

                                                    <input name="dlookup_cat_details" id="dlookup_cat_details"
                                                           type="text"
                                                           class="form-control"
                                                           placeholder="الاسم" value=""></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">النوع</label>
                                            <div class="col-md-4">
                                                <div class="col-md-12 ">

                                                    <input name="dlookup_type" id="dlookup_type" type="text"
                                                           class="form-control"
                                                           placeholder="النوع" value=""></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions left">
                                        <div class="row">
                                            <div class=" col-md-9">
                                                <button type="submit" class="btn green">حفظ</button>
                                                <button type="button" onclick="clearDetailForm()"
                                                        class="btn  red-intense">الغاء
                                                </button>

                                            </div>
                                        </div>
                                    </div>
                                {{-- </form>--}}
                                {{Form::close()}}
                                <!-- END FORM-->
                                </div>
                            </div>
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-comments"></i>جدول القيم
                                    </div>
                                   {{-- <div class="tools">
                                        <a href="javascript:;" class="collapse"> </a>
                                        <a href="#portlet-config" data-toggle="modal"
                                           class="config"> </a>
                                        <a href="javascript:;" class="reload"> </a>
                                        <a href="javascript:;" class="remove"> </a>
                                    </div>--}}
                                </div>

                                <div class="portlet-body">
                                    <div class="">
                                        <table class="table table-bordered table-hover" id="specttb">
                                            <thead>
                                            <tr>
                                                <th> كود</th>
                                                <th> الاسم</th>
                                                <th> النوع</th>
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
                $('#addDv').fadeOut();
                $.fn.dataTable.ext.errMode = 'none';
                $('#setting_tbl').on('error.dt', function (e, settings, techNote, message) {
                    console.log('An error has been reported by DataTables: ', message);
                })
                $('#setting_tbl').dataTable({

                    'processing': true,
                    'serverSide': true,
                    'ajax': '{{url('s2-data')}}',
                    'columns': [

                        {data: 'id', name: 'id'},
                        {data: 'lookup_cat_details', name: 'lookup_cat_details'},
                        {data: 'parent_name', name: 'parent_name'},
                        {data: 'lookup_type', name: 'lookup_type'},
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

            var settingFormValidation = function () {

                // basic validation
                var handleValidation1 = function () {
                    // for more info visit the official plugin documentation:
                    // http://docs.jquery.com/Plugins/Validation

                    var form1 = $('#setting_form');
                    var error1 = $('.alert-danger', form1);
                    var success1 = $('.alert-success', form1);
                    // Unique email


                    form1.validate({
                        errorElement: 'span', //default input error message container
                        errorClass: 'help-block help-block-error', // default input error message class
                        focusInvalid: false, // do not focus the last invalid input
                        ignore: "",  // validate all fields including form hidden input

                        rules: {

                            name: {
                                required: true,

                            },

                        },

                        messages: { // custom messages for radio buttons and checkboxes
                            name: {
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

                            settingSubmit();


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


            settingFormValidation.init();

            function settingSubmit() {

                var form1 = $('#setting_form');
                var error = $('.alert-danger', form1);
                var success = $('.alert-success', form1);

                var action = $('#setting_form').attr('action');

                var formData = new FormData($('#setting_form')[0]);

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
                                    window.location.href = '{{url('/setting/s2')}}';

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

                    }
                )
                //   });
            }

            function settingDelete(id) {

                var form1 = $('#setting_form');
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
                            url: '{{url('/setting/s2-delete')}}',
                            data: {id: id},

                            success:

                                function (data) {
                                    if (data.success) {

                                        success.show();
                                        error.hide();
                                        App.scrollTo(success, -200);
                                        success.fadeOut(2000);
                                        window.location.href = '{{url('/setting/s2')}}';

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

            function fillForm(id, name, type) {
                $('#hdn_table_id').val(id);
                $('#lookup_cat_details').val(name);
                $('#lookup_type').val(type);

                $('#addDv').fadeIn();
                var itemUp = $('#lookup_cat_details');
                App.scrollTo(itemUp, -200);


            }

            function clearForm() {
                $('#hdn_table_id').val('');
                $('#lookup_cat_details').val('');
                $('#lookup_type').val('');
                $('#addDv').fadeOut();

            }

            /****************details***************/

            var detailFormValidation = function () {

                // basic validation
                var handleValidation1 = function () {
                    // for more info visit the official plugin documentation:
                    // http://docs.jquery.com/Plugins/Validation

                    var form1 = $('#detail_form');
                    var error1 = $('.alert-danger', form1);
                    var success1 = $('.alert-success', form1);
                    // Unique email


                    form1.validate({
                        errorElement: 'span', //default input error message container
                        errorClass: 'help-block help-block-error', // default input error message class
                        focusInvalid: false, // do not focus the last invalid input
                        ignore: "",  // validate all fields including form hidden input

                        rules: {

                            dlookup_cat_details: {
                                required: true,
                            },
                            dlookup_type: {
                                required: true,
                            },
                        },

                        messages: { // custom messages for radio buttons and checkboxes
                            dlookup_cat_details: {
                                required: "هذه الحقل مطلوب,الرجاء ادخال قيمة",
                            },
                            dlookup_type: {
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

                            detailSubmit();


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
            detailFormValidation.init();

            function detailSubmit() {

                var form1 = $('#detail_form');
                var error = $('.alert-danger', form1);
                var success = $('.alert-success', form1);

                var action = $('#detail_form').attr('action');

                var formData = new FormData($('#detail_form')[0]);

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
                                    reloadDetailTable();
                                    clearDetailForm();

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

                    }
                )
                //   });
            }

            function reloadDetailTable() {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                $('#specttb').DataTable().destroy();
                $.fn.dataTable.ext.errMode = 'none';
                $('#specttb').on('error.dt', function (e, settings, techNote, message) {
                    console.log('An error has been reported by DataTables: ', message);
                })

                $('#specttb').dataTable({

                    'processing': true,
                    'serverSide': true,
                    'ajax': {
                        "type": "post",
                        "url": '{{url('s2-details-data')}}',//"s2-details-data",

                        "data": {
                            'table_id': $('#hdn_lookup_id').val()
                        }
                        ,

                    },


                    'columns': [
                        {data: 'id', name: 'id'},
                        {data: 'lookup_cat_details', name: 'lookup_cat_details'},
                        {data: 'lookup_type', name: 'lookup_type'},
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

            function fillDetailForm(id, name, type) {

                $('#hdn_dtable_id').val(id);
                $('#dlookup_cat_details').val(name);
                $('#dlookup_type').val(type);

            }

            function detailDelete(id) {

                var form1 = $('#detail_form');
                var error = $('.alert-danger', form1);
                var success = $('.alert-success', form1);


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                        type: "POST",
                        url: '{{url('/setting/s2-detail-delete')}}',
                        data: {id: id},

                        success:

                            function (data) {
                                if (data.success) {

                                    success.show();
                                    error.hide();
                                    App.scrollTo(success, -200);
                                    success.fadeOut(2000);
                                    reloadDetailTable()
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

            function clearDetailForm() {
                $('#hdn_dtable_id').val('');
                $('#dlookup_cat_details').val('');
                $('#dlookup_type').val('');



            }

            function addDetail(id, cat_type) {
                //  alert(id);
                $('#hdn_lookup_id').val(id);
                $('#hdn_cat_type').val(cat_type);
                $('#hdn_dtable_id').val('');
                reloadDetailTable()
            }
            function openDv() {
                $('#addDv').fadeIn();
            }
        </script>
    @endpush
@stop
