@extends('admin.layout.index')
@section('content')
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <meta name="csrf-token" content="{{ csrf_token()}}">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN THEME PANEL -->
    {{--<div class="theme-panel">
        <div class="toggler tooltips" data-container="body" data-placement="left" data-html="true" data-original-title="Click to open advance theme customizer panel">
            <i class="icon-settings"></i>
        </div>
        <div class="toggler-close">
            <i class="icon-close"></i>
        </div>
        <div class="theme-options">
            <div class="theme-option theme-colors clearfix">
                <span> THEME COLOR </span>
                <ul>
                    <li class="color-default current tooltips" data-style="default" data-container="body" data-original-title="Default"> </li>
                    <li class="color-grey tooltips" data-style="grey" data-container="body" data-original-title="Grey"> </li>
                    <li class="color-blue tooltips" data-style="blue" data-container="body" data-original-title="Blue"> </li>
                    <li class="color-dark tooltips" data-style="dark" data-container="body" data-original-title="Dark"> </li>
                    <li class="color-light tooltips" data-style="light" data-container="body" data-original-title="Light"> </li>
                </ul>
            </div>
            <div class="theme-option">
                <span> Layout </span>
                <select class="layout-option form-control input-small">
                    <option value="fluid" selected="selected">Fluid</option>
                    <option value="boxed">Boxed</option>
                </select>
            </div>
            <div class="theme-option">
                <span> Header </span>
                <select class="page-header-option form-control input-small">
                    <option value="fixed" selected="selected">Fixed</option>
                    <option value="default">Default</option>
                </select>
            </div>
            <div class="theme-option">
                <span> Top Dropdown</span>
                <select class="page-header-top-dropdown-style-option form-control input-small">
                    <option value="light" selected="selected">Light</option>
                    <option value="dark">Dark</option>
                </select>
            </div>
            <div class="theme-option">
                <span> Sidebar Mode</span>
                <select class="sidebar-option form-control input-small">
                    <option value="fixed">Fixed</option>
                    <option value="default" selected="selected">Default</option>
                </select>
            </div>
            <div class="theme-option">
                <span> Sidebar Style</span>
                <select class="sidebar-style-option form-control input-small">
                    <option value="default" selected="selected">Default</option>
                    <option value="compact">Compact</option>
                </select>
            </div>
            <div class="theme-option">
                <span> Sidebar Menu </span>
                <select class="sidebar-menu-option form-control input-small">
                    <option value="accordion" selected="selected">Accordion</option>
                    <option value="hover">Hover</option>
                </select>
            </div>
            <div class="theme-option">
                <span> Sidebar Position </span>
                <select class="sidebar-pos-option form-control input-small">
                    <option value="left" selected="selected">Left</option>
                    <option value="right">Right</option>
                </select>
            </div>
            <div class="theme-option">
                <span> Footer </span>
                <select class="page-footer-option form-control input-small">
                    <option value="fixed">Fixed</option>
                    <option value="default" selected="selected">Default</option>
                </select>
            </div>
        </div>
    </div>--}}
    <!-- END THEME PANEL -->
    {{--<h1 class="page-title"> {{''}}
        <small>blank page layout</small>
    </h1>--}}
    <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Dashboard</span>
                </li>
            </ul>
            <div class="page-toolbar">
                <div id="dashboard-report-range" class="pull-right tooltips btn btn-fit-height green"
                     data-placement="top" data-original-title="Change dashboard date range"
                     data-date-format="yyyy/mm/dd">
                    <i class="icon-calendar"></i>&nbsp;
                    <span class="thin uppercase hidden-xs"></span>&nbsp;
                    <i class="fa fa-angle-down"></i>
                </div>
            </div>
        </div>
        <div class="row widget-row">
            <div class="col-md-4">
                <!-- BEGIN WIDGET THUMB -->
                <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                    <h4 class="widget-thumb-heading">بيانات1</h4>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-green icon-bulb"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle"></span>
                            <span class="widget-thumb-body-stat" data-counter="counterup"
                                  data-value="" id="open_files"></span>
                        </div>
                    </div>
                </div>
                <!-- END WIDGET THUMB -->
            </div>
            <div class="col-md-4">
                <!-- BEGIN WIDGET THUMB -->
                <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                    <h4 class="widget-thumb-heading">بيانات2</h4>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-red icon-layers"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle"></span>
                            <span class="widget-thumb-body-stat" data-counter="counterup"
                                  data-value="" id="session_files"></span>
                        </div>
                    </div>
                </div>
                <!-- END WIDGET THUMB -->
            </div>
            <div class="col-md-4">
                <!-- BEGIN WIDGET THUMB -->
                <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                    <h4 class="widget-thumb-heading">بيانات3</h4>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-purple icon-screen-desktop"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle"></span>
                            <span class="widget-thumb-body-stat" data-counter="counterup"
                                  data-value="" id="closed_files"></span>
                        </div>
                    </div>
                </div>
                <!-- END WIDGET THUMB -->
            </div>
            {{-- <div class="col-md-3">
                 <!-- BEGIN WIDGET THUMB -->
                 <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                     <h4 class="widget-thumb-heading">Average Monthly</h4>
                     <div class="widget-thumb-wrap">
                         <i class="widget-thumb-icon bg-blue icon-bar-chart"></i>
                         <div class="widget-thumb-body">
                             <span class="widget-thumb-subtitle">USD</span>
                             <span class="widget-thumb-body-stat" data-counter="counterup" data-value="5,071">0</span>
                         </div>
                     </div>
                 </div>
                 <!-- END WIDGET THUMB -->
             </div>--}}
        </div>
        <!-- END PAGE BAR -->

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                    <div class="visual">
                        <i class="fa fa-comments"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" id="result1"></span>
                        </div>
                        <div class="desc">نشاط1</div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                    <div class="visual">
                        <i class="fa fa-globe"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="" id="result2"></span>
                        </div>
                        <div class="desc"> نشاط2</div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                    <div class="visual">
                        <i class="fa fa-bar-chart-o"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" id="result3"></span></div>
                        <div class="desc">نشاط3</div>
                    </div>
                </a>
            </div>

            {{--  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                      <div class="visual">
                          <i class="fa fa-shopping-cart"></i>
                      </div>
                      <div class="details">
                          <div class="number">
                              <span data-counter="counterup" data-value="549">0</span>
                          </div>
                          <div class="desc"> </div>
                      </div>
                  </a>
              </div>
              <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <a class="dashboard-stat dashboard-stat-v2 purple" href="#">
                      <div class="visual">
                          <i class="fa fa-globe"></i>
                      </div>
                      <div class="details">
                          <div class="number"> +
                              <span data-counter="counterup" data-value="89"></span>% </div>
                          <div class="desc"> Brand Popularity </div>
                      </div>
                  </a>
              </div>--}}
        </div>

        <!-- END PAGE HEADER-->
        <div class="note note-info">
            <div class="row">
                <div class="col-lg-12 col-xs-12 col-sm-12">
                    <!-- BEGIN PORTLET-->
                    <div class="portlet light calendar ">
                        <div class="portlet-title ">
                            <div class="caption">
                                <i class="icon-calendar font-dark hide"></i>
                                {{--  <span class="caption-subject font-dark bold uppercase">Feeds</span>--}}
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                    <!-- END PORTLET-->
                </div>

            </div>

        </div>
    </div>
    <!-- END CONTENT BODY -->
    @push('css')
        <link href="{{url('')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css"
              rel="stylesheet" type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet"
              type="text/css"/>

    @endpush
    @push('js')
        <script src="{{url('')}}/assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/amcharts/amcharts/radar.js" type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/amcharts/amcharts/themes/light.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/amcharts/amcharts/themes/patterns.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/amcharts/amcharts/themes/chalk.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/amcharts/ammap/ammap.js" type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/amcharts/ammap/maps/js/worldLow.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/amcharts/amstockcharts/amstock.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/fullcalendar/fullcalendar.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/pages/scripts/dashboard.js" type="text/javascript"></script>



    @endpush

@stop
