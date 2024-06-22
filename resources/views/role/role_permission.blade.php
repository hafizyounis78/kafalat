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
                                    <label for="multiple" class="control-label col-md-3">فئات المستخدمين</label>
                                    <div class="col-md-9">
                                        <select id="role" name="role" class="form-control select2"
                                                onchange="getRolePer();">
                                            <option value="0">اختر ..</option>

                                            <?php

                                            foreach ($roles as $role) {

                                                echo '<option value="' . $role->id . '">' . $role->display_name . '</option>';
                                            }

                                            ?>

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
                                    <?php

                                    foreach ($permissions as $permission) {

                                        echo '<option value="' . $permission->id . '">' . $permission->display_name . '</option>';
                                    }

                                    ?>

                                </select>
                            </div>
                        </div>
                        {{--   <div class="form-group last">
                               <label class="control-label col-md-3">Grouped Options</label>
                               <div class="col-md-9">
                                   <select multiple="multiple" class="multi-select" id="my_multi_select2" name="my_multi_select2[]">
                                       <optgroup label="NFC EAST">
                                           <option>Dallas Cowboys</option>
                                           <option>New York Giants</option>
                                           <option>Philadelphia Eagles</option>
                                           <option>Washington Redskins</option>
                                       </optgroup>
                                       <optgroup label="NFC NORTH">
                                           <option>Chicago Bears</option>
                                           <option>Detroit Lions</option>
                                           <option>Green Bay Packers</option>
                                           <option>Minnesota Vikings</option>
                                       </optgroup>
                                       <optgroup label="NFC SOUTH">
                                           <option>Atlanta Falcons</option>
                                           <option>Carolina Panthers</option>
                                           <option>New Orleans Saints</option>
                                           <option>Tampa Bay Buccaneers</option>
                                       </optgroup>
                                       <optgroup label="NFC WEST">
                                           <option>Arizona Cardinals</option>
                                           <option>St. Louis Rams</option>
                                           <option>San Francisco 49ers</option>
                                           <option>Seattle Seahawks</option>
                                       </optgroup>
                                   </select>
                               </div>
                           </div>--}}
                    </div>
                    <div class="form-actions left">
                        <div class="row">
                            <div class=" col-md-9">
                               {{-- <button type="submit" class="btn green">
                                    حفظ
                                </button>--}}
                                <button type="button" class="btn grey-salsa btn-outline">عودة</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END FORM-->
            </div>
        </div>


    </div>
    @push('css')
        <link href="{{url('')}}/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet"
              type="text/css"/>
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="{{url('')}}/assets/global/plugins/bootstrap-select/css/bootstrap-select-rtl.min.css"
              rel="stylesheet" type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/jquery-multi-select/css/multi-select-rtl.css" rel="stylesheet"
              type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet"
              type="text/css"/>
        <!-- END PAGE LEVEL PLUGINS -->
    @endpush
    @push('js')
        <script src="{{url('')}}/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <script src="{{url('')}}/assets/pages/scripts/components-select2.js" type="text/javascript"></script>
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{url('')}}/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <script src="{{url('')}}/assets/pages/scripts/components-multi-select.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->

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
                            $.ajax({
                                url:'{{url('role/selectPer')}}',
                                type: "POST",
                                data:  {role_id : $("#role").val(),
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
                                url:'{{url('role/deselectPer')}}',
                                type: "POST",
                                data:  {role_id : $("#role").val(),
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
                var id = $('#role').val();
                //  alert(id);
                $('#permissions').html('');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                        type: "POST",
                        url: '{{url('role/getPermissions')}}',
                        data: {id: id},

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
