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


        <div class="portlet box yellow-casablanca">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>جدول القيم
                </div>
                <div class="tools">


                </div>
            </div>
            <div class="portlet-body form">
                {{Form::open(['url'=>'','class'=>'form-horizontal','method'=>"post","id"=>"setting_form"])}}
                <div class="form-body">
                    <div class="alert alert-danger display-hide">

                        <button class="close" data-close="alert"></button>

                        لم تتم العملية بنجاح

                    </div>

                    <div class="alert alert-success display-hide">

                        <button class="close" data-close="alert"></button>

                        تمت عملية الحفظ بنجاح!

                    </div>
                    <table class="table table-striped table-bordered table-hover  order-column" id="setting_tbl">
                        <thead>
                        <tr>

                            <th> كود</th>
                            <th> الاسم</th>
                            <th> نوع الكفالة</th>
                            <th> نوع التقرير</th>

                        </tr>
                        </thead>
                    </table>
                </div>
                {{Form::close()}}
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
                $('#addDv').fadeOut();
                $.fn.dataTable.ext.errMode = 'none';
                $('#setting_tbl').on('error.dt', function (e, settings, techNote, message) {
                    console.log('An error has been reported by DataTables: ', message);
                })
                $('#setting_tbl').dataTable({

                    'processing': true,
                    'serverSide': true,
                    'ajax': '{{url('s4-data')}}',
                    'columns': [

                        {data: 'id', name: 'id'},
                        {data: 'header', name: 'header'},
                        {data: 'account_type_desc', name: 'account_type_desc'},
                        {data: 'report_type_desc', name: 'report_type_desc'},
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

                                    } else {
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

            function changeState(id, state) {

                var form1 = $('#setting_form');
                var error = $('.alert-danger', form1);
                var success = $('.alert-success', form1);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                        type: "POST",
                        url: '{{url('/setting/s4-change-state')}}',
                        data: {id: id, state: state},

                        success:

                            function (data) {
                                if (data.success) {

                                    success.show();
                                    error.hide();
                                    App.scrollTo(success, -200);
                                    success.fadeOut(2000);
                                    reloadDetailTable()
                                } else {
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


        </script>
    @endpush
@stop
