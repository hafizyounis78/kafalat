<!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>-->
<?php header('Access-Control-Allow-Origin: *'); ?>
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
                                               value="{{isset($P_FROM_DATE)?$P_FROM_DATE:date('Y-m-d')}}"
                                               data-date-format="yyyy-mm-dd"

                                               name="P_FROM_DATE" type="text" autocomplete="false">

                                        <span class="input-group-addon">

                                    الى </span>

                                        <input class="form-control " id="P_TO_DATE"
                                               value="{{isset($P_TO_DATE)?$P_TO_DATE:date('Y-m-d')}}"
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
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN MARKERS PORTLET-->
                                <div id="map" class="gmaps" style="height: 500px">
                                </div>
                            {{--<div class="portlet solid yellow">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-gift"></i>التوزيع الجغرافي للطلبات
                                    </div>

                                </div>
                                <div id="map" class="portlet-body gmaps" >

                                </div>
                            </div>--}}
                            <!-- END MARKERS PORTLET-->
                            </div>
                        </div>

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
        <script src="//maps.googleapis.com/maps/api/js?key=AIzaSyBPFquydJVMXOYvdF9XeX3_AekcWLlEv8M&callback=initMap"
                async="" defer="defer" type="text/javascript"></script>
        {{--  <script src="https://roads.googleapis.com/v1/snapToRoads?path=-35.27801,149.12958|-35.28032,149.12907|-35.28099,149.12929|-35.28144,149.12984|-35.28194,149.13003|-35.28282,149.12956|-35.28302,149.12881|-35.28473,149.12836 &interpolate=true &key=AIzaSyBPFquydJVMXOYvdF9XeX3_AekcWLlEv8M"
                  async="" defer="defer" type="text/javascript"></script>--}}
        <script type='text/javascript' src='https://unpkg.com/leaflet@1.6.0/dist/leaflet.js'></script>
        <script src="{{url('')}}/assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/pages/scripts/components-date-time-pickers.js"
                type="text/javascript"></script>

        <script>
            // Initialize and add the map
            var maxZoomService;
            var locations = [];
            var marker = [];
            var map;
            var infowindow;
            var maxZoomService;
            function initMap() {
                var user_id = $('#user_id').val();
                var locations = [];
                $.ajax({
                    type: 'POST',
                    url: '{{url('user/all-location-date')}}',
                    data: {user_id: user_id, from: $('#P_FROM_DATE').val(), to: $('#P_TO_DATE').val()},
                    headers:
                        {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    //   },
                    success: function (msg) {

                        if (msg.locations.length > 0)
                            var uluru = {lat: parseFloat(msg.locations[0].latitude), lng: parseFloat(msg.locations[0].longitude)};
                        // The map, centered at Uluru
                        map = new google.maps.Map(
                            document.getElementById('map'), {
                                zoom: 12,
                                center: uluru,
                                mapTypeId: "hybrid",
                                //mapTypeId: google.maps.MapTypeId.satellite
                            });
                         infowindow= new google.maps.InfoWindow();
                        var marker, i;

                      //  maxZoomService = new google.maps.MaxZoomService();
                      //  map.addListener("click", showMaxZoom);


                        $.each(msg.locations, function (key, val) {

                            locations[key] = [val.address, val.latitude, val.longitude]
                            marker = new google.maps.Marker({
                                position: new google.maps.LatLng(val.latitude, val.longitude),
                                map: map
                            })

                            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                                return function () {
                                    infowindow.setContent(locations[i][0]);
                                    infowindow.open(map, marker);
                                }
                            })(marker, key));
                        });


                    }
                });
                const ctaLayer = new google.maps.KmlLayer({
                    url: "https://googlearchive.github.io/js-v2-samples/ggeoxml/cta.kml",
                    map: map
                });

                const transitLayer = new google.maps.TransitLayer();
                transitLayer.setMap(map);


            }
          /*  function showMaxZoom(e) {
                maxZoomService.getMaxZoomAtLatLng(e.latLng, result => {
                    if (result.status !== "OK") {
                        infoWindow.setContent("Error in MaxZoomService");
                    } else {
                        infoWindow.setContent(
                            "The maximum zoom at this location is: " + result.zoom
                        );
                    }
                    infoWindow.setPosition(e.latLng);
                    infoWindow.open(map);
                });
            }*/

            $(document).ready(function () {

                $('.date-picker').datepicker({
                    rtl: App.isRTL(),
                    orientation: "left",
                    autoclose: true
                });

                // initmap2();

            });
        </script>
    @endpush
@stop

