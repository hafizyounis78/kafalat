<!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>-->
@extends('admin.layout.index')
@section('content')
    <div class="page-content">
        <meta name="csrf-token" content="{{ csrf_token()}}">


        <div class="row">
            <input type="hidden" id="user_id" value="{{$user_id}}">
            <div class="col-md-12">

                <!--		 <div class="portlet-body form">



                              <div class="form-body">-->

                <div class="portlet box green-haze">
                    <div class="portlet-title">
                        <div class="caption ">
                            <i class="fa fa-briefcase"></i>موقع الموظف على الخريطة
                        </div>
                    </div>

                    <div class="portlet-body form">

                        <form class="form-horizontal form-bordered form-row-stripped" role="form" id="rta_frm_id"
                              action="{{ url('user/'.$user_id.'/map')}}" method="GET">

                            <div class="form-group">
                                <label for="P_FROM_DATE" class="col-md-1 control-label">التاريخ من</label>
                                <div class="col-md-4">

                                    <div class="input-group input-large date-picker input-daterange"
                                         data-date="10/11/2012"

                                         data-date-format="yyyy-mm-dd">

                                        <input class="form-control " id="P_FROM_DATE"
                                               value="{{isset($P_FROM_DATE)?$P_FROM_DATE:date('Y-m-d')}}" data-date-format="yyyy-mm-dd"

                                               name="P_FROM_DATE" type="text" autocomplete="false">

                                        <span class="input-group-addon">

                                    الى </span>

                                        <input class="form-control " id="P_TO_DATE" value="{{isset($P_TO_DATE)?$P_TO_DATE:date('Y-m-d')}}"
                                               data-date-format="yyyy-mm-dd"

                                               name="P_TO_DATE" type="text" autocomplete="false">

                                    </div>

                                </div>
                                <div class="col-md-3">
                                    <button class="btn red filterMap" type="submit">
                                        <i class="fa fa-search"></i>&nbsp;بحث
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div id="map" style="width:100%;height:810px;"></div>

                    </div>

                </div>


            </div>

        </div>
    </div>
    @push('css')
        <style>
            .datepicker {
                width: 15%;

            }

        </style>
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"/>
        <link href="{{url('')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css"
              rel="stylesheet" type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"
              rel="stylesheet" type="text/css"/>
    @endpush
    @push('js')
       {{-- <script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js'></script>--}}
       <script type='text/javascript' src='https://unpkg.com/leaflet@1.6.0/dist/leaflet.js'></script>
        <script src="{{url('')}}/assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/pages/scripts/components-date-time-pickers.js"
                type="text/javascript"></script>

        <script>

            var marker;
            var markers = [];
            //  var map;
            var red_marker;
            var green_marker;
            var osm;
            var attrib = '';
            //  var tuileUrl = 'http://{s}.tile.osm.org/{z}/{x}/{y}.png';
            //    var myIcon;

            function initmap2() {
                var user_id = $('#user_id').val();
                var osmUrl = 'http://{s}.tile.osm.org/{z}/{x}/{y}.png';
                osmAttrib = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',


                    // create the tile layer with correct attribution
                    osm = L.tileLayer(osmUrl, {
                        minZoom: 4,
                        maxZoom: 22,
                        attribution: osmAttrib
                    });

                var map = L.map('map').setView([31.4171565, 34.3596858], 15).addLayer(osm);

                L.control.scale().addTo(map);

                //  $.getJSON("https://sta.ci.taiwan.gov.tw/STA_Rain/v1.0/Things?$expand=Locations&$select=name,properties&$count=true", function (data) {
                var markerGroup = L.featureGroup();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: '{{url('user/all-location-date')}}',
                    data: {user_id: user_id, from: $('#P_FROM_DATE').val(), to: $('#P_TO_DATE').val()},

                    success: function (data) {
                        //   alert(data.locations);
                        if (data.locations.length > 0) {
                            $.each(data.locations, function (i, v) {
                                /*  myIcon = green_marker;
                                  alert(v);
                                  alert(' latitude : ' + v.latitude + ' longitude: ' + v.longitude)

                                  marker = L.marker([v.latitude, v.longitude], {tooltip: 'Marker 1'}, {icon: myIcon}).addTo(map);
                                  markers.push(marker);*/
                                // }
                                var latLng = L.latLng(v.latitude, v.longitude);
                                var myMarker = L.marker(latLng).addTo(markerGroup);
                                //myMarker.bindPopup('ID: ' + itemData.properties.stationID + '<br />Name: ' + itemData.properties.stationName);

                                var popupContent = "<p>Address  <b>" +
                                    v.address;


                                /*if (itemData.properties && itemData.properties.popupContent) {
                                    popupContent += itemData.properties.popupContent;
                                }*/
                                myMarker.bindPopup(popupContent);
                            })
                            //   map.addPopup(popup);
                            markerGroup.addTo(map);
                            map.fitBounds(markerGroup.getBounds());

                        }
                    },
                    error: function (err) {

                        console.log(err);
                    }

                })


            }


            function reGetAllPoints() {
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
                        $.each(markers, function (i, v) {
                            map.removeLayer(v);
                        })
                        $('.filterMap').find('i').removeClass('fa-spinner fa-spin');
                        $('.filterMap').removeAttr('disabled');

                        markers = [];
                        $.each(data.SRCH_CURS, function (i, v) {
                            myIcon = green_marker;
                            // if(v.LONGITUDE_Y <35) {
                            if (v.INJURES == 1) {
                                myIcon = red_marker;
                            }

                            marker = L.marker([v.LATITUDE_X, v.LONGITUDE_Y], {icon: myIcon}).addTo(map);
                            markers.push(marker);
                            // }
                        })
                        osm.addTo(map);
                    },
                    error: function (err) {

                        console.log(err);
                    }

                })


                return;
            }

            $(document).ready(function () {

                $('.date-picker').datepicker({
                    rtl: App.isRTL(),
                    orientation: "left",
                    autoclose: true
                });
                initmap2();

            });
        </script>
    @endpush
@stop

