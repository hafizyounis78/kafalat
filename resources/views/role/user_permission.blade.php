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
                    <i class="fa fa-gift"></i>{{$page_title }}</div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"> </a>

                </div>
            </div>

            <div class="portlet-body form">
                <!-- BEGIN FORM-->

                <form action="index.html" class="form-horizontal form-row-seperated">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"> المستخدم</label>
                                    <div class="col-md-5">
                                        <select  class="form-control select2" id="user_id" onchange="getRolePer();">

                                            <option value="0">اختر..</option>



                                            @foreach ($users as $user)


                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach


                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group last">
                            <label class="control-label col-md-3">شاشات النظام</label>
                            <div class="col-md-9">
                                <select multiple="multiple" class="multi-select" id="permissions"
                                        name="my_multi_select1[]">


                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions left">
                        <div class="row">
                            <div class="col-md-9">
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END FORM-->
            </div>
        </div>


    </div>
    @push('css')
        {{--<link href="{{url('')}}/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>--}}
        {{--<link href="{{url('')}}/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet"--}}
              {{--type="text/css"/>--}}
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="{{url('')}}/assets/global/plugins/bootstrap-select/css/bootstrap-select-rtl.css"
              rel="stylesheet" type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/jquery-multi-select/css/multi-select-rtl.css" rel="stylesheet"
              type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet"
              type="text/css"/>
        <!-- END PAGE LEVEL PLUGINS -->
    @endpush
    @push('js')
        <script src="{{url('')}}/assets/global/plugins/select2/js/select2.full.js" type="text/javascript"></script>
        <script src="{{url('')}}/assets/pages/scripts/components-select2.js" type="text/javascript"></script>
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{url('')}}/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js"
                type="text/javascript"></script>
        {{--<script src="{{url('')}}/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>--}}
        <script src="{{url('')}}/assets/pages/scripts/components-multi-select.js" type="text/javascript"></script>
        <script>

            var ComponentsDropdowns = function () {

                var handleMultiSelect = function () {
                    $('#permissions').multiSelect({
                        //   selectableOptgroup: true,

                        afterSelect: function(values){
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            if($("#user_id").val()!=0)
                            $.ajax({
                                url:'{{url('role/selectUserPer')}}',
                                type: "POST",
                                data:  {user_id : $("#user_id").val(),
                                    values : values},
                                error: function(xhr, status, error) {
                                    //var err = eval("(" + xhr.responseText + ")");
                                    alert(xhr.responseText);
                                },
                                beforeSend: function(){},
                                complete: function(){},
                                success: function(returndb){
                                    if(returndb != '')
                                        $('#my_multi_select2').multiSelect('deselect', values);
                                }
                            });//END $.ajax
                        },
                        afterDeselect: function(values){
                            $.ajax({
                                url:'{{url('role/deselectUserPer')}}',
                                type: "POST",
                                data:  {user_id : $("#user_id").val(),
                                    values : values},
                                error: function(xhr, status, error) {
                                    //var err = eval("(" + xhr.responseText + ")");
                                    alert(xhr.responseText);
                                },
                                beforeSend: function(){},
                                complete: function(){},
                                success: function(returndb){
                                    if(returndb != '')
                                        $('#my_multi_select2').multiSelect('select', values);
                                }
                            });//END $.ajax
                        },

                        selectableHeader: "<div class='btn-danger' align='center'><b> غـيـر مـتـاحـة </b></div>",
                        selectionHeader: "<div class='btn-success' align='center'><b> مـتـاحــة </b></div>"
                    });

                }

                return {
                    //main function to initiate the module
                    init: function () {
                        handleMultiSelect();
                    }
                };

            }();

            function getRolePer() {

                var user_id = $('#user_id').val();
                //  alert(id);
                $('#permissions').html('');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                        type: "POST",
                        url: '{{url('role/getRolePermissions')}}',
                        data: {user_id:user_id},

                        success:

                            function (data) {
                                if (data.success) {
                                    $('#permissions').html(data.per);
                                    $("#permissions").multiSelect('refresh');
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
    @endpush
@stop
