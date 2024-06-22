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
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="col-md-10">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject bold uppercase"> {{$location_title}}</span>
                            </div>
                        </div>
                        <div class="col-md-2 left">
                            <a href="{{url('/user/create')}}" class="btn sbold blue-madison"> اضافة مستخدم جديد
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <!--<div class="table-toolbar">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="btn-group">
                                        <a href="{{url('/user/create')}}" class="btn sbold blue-madison"> اضافة مستخدم جديد
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>-->
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="users_tbl">
                            <thead>
                            <tr>
                                <th>
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline"
                                           style="padding-right:10px">
                                        <input type="checkbox" class="group-checkable"
                                               data-set="#report1_tbl .checkboxes"/>
                                        <span></span>
                                    </label>
                                </th>
                                <th> # </th>
                                <th> الاسم </th>
                                <th> البريد الإلكتروني </th>
                                <th> نوع المسنخدم </th>
                                <th>تحكم</th>
                            </tr>
                            </thead>
                        </table>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="btn-group">
                                        <button class="btn red " type="button" id="btn-delete"
                                                title="حذف الكل">
                                            <i class="fa fa-times"></i>حذف الكل
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6"></div>
                                <div class="col-md-3">
                                    <div class="col-md-3">

                                    </div>
                                    <div class="col-md-3">

                                    </div>
                                    <div class="col-md-3 ">

                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        <div id="user-map" class="modal fade" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">موقع الموظف الحالي</h4>
                    </div>
                    <div class="modal-body">
                        <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- BEGIN MARKERS PORTLET-->
                                    <div id="map" class="gmaps">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn dark btn-outline">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script src="//maps.googleapis.com/maps/api/js?key=AIzaSyBYu1SJi3v5IIO7D1KT_AHNnqRKsSpQZ4A"
                async="" defer="defer" type="text/javascript"></script>

            //user map

        <script>
            function initMap2(lat, long) {
                var center = {lat: lat, lng: long};
                var map = new google.maps.Map(document.getElementById('map'), {zoom: 12, center: center}); // This is the map initiation in a #map element
                //   if (lat != null && long != null) {
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(lat, long), // the old position
                    map: map, // The map you created in your element by new google.maps.Map(...)
                    // icon: 'assets/marker.png',
                    title: 'This is the user Location',
                });

                //setTimeout(function() {
                if (lat != null && long != null) {
                    marker.position = new google.maps.LatLng(lat, long); // new position
                }
                else
                    marker.position = new google.maps.LatLng('', ''); // new position

                marker.setMap(map); // This reinitializes the marker
                //}, 10000); // For this example I set a 10s timeout
            }

            function initMap(lat, long) {

                var center = {lat: lat, lng: long};
                var map = new google.maps.Map(
                    document.getElementById('map'), {zoom: 12, center: center});
                if (lat != null && long != null)
                    var marker = new google.maps.Marker({
                        position: new google.maps.LatLng(lat, long),
                        map: map
                    });
            }
            $(document).ready(function () {

                $('#users_tbl').dataTable({

                    'processing': true,
                    'serverSide': true,
                    'ajax': '{{url('/user-data')}}',
                    /*id`, `name`, `email`, ``, ``, `gender`, `address`, `mobile`, `image`, `user_type`, ``, `company_id`, `supervisor_id`, ``*/
                    'columns': [
                        {data: 'delChk', name: 'delChk'},
                        {data: 'num', name: 'num'},
                        {data: 'name', name: 'name'},
                        {data: 'email', name: 'email'},
                        {data: 'user_type_desc', name: 'user_type_desc'},

                        {data:'action', name: 'action'},

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
            function deleteUser(id) {
                var x = '';
                var r = confirm('سيتم حذف المستخدم ,هل انت متاكد من ذلك؟');
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
                        url: '{{url('user/del-one')}}',
                        data: {id: id},

                        success: function (data) {
                            location.reload();
                        },
                        error: function (err) {

                            console.log(err);
                        }

                    })
                }
            }
            $('#btn-delete').on('click', function (e) {
                    e.preventDefault();
                    var x = '';

                    var currentToken = $('meta[name="csrf-token"]').attr('content');
                    var idArray = [];
                    var table = $('#users_tbl').DataTable();
                    table.$('input[type="checkbox"]').each(function () {
                        // If checkbox doesn't exist in DOM

                        // If checkbox is checked
                        if (this.checked) {
                            // alert($(this).attr('data-id'));
                            idArray.push($(this).attr('data-id'));
                            // Create a hidden element
                            /*$form.append(
                                $('<input>')
                                    .attr('type', 'hidden')
                                    .attr('name', this.name)
                                    .val(this.value)
                            );*/
                        }

                    });
                    //   alert('checked :' +idArray);
                    if (idArray.length > 0) {
                        var r = confirm('سيتم حذف المستخدمين  ,هل انت متاكد من ذلك؟');
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
                                url: '{{url('user/del-chk')}}',
                                data: {idArray: idArray},

                                success: function (data) {
                                    location.reload();
                                },
                                error: function (err) {

                                    console.log(err);
                                }

                            })
                        }
                    }
                }
            );
        </script>
    @endpush
@stop
