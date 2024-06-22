{{--<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />--}}
<link href="{{url('/')}}/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="{{url('/')}}/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
<link href="{{url('/')}}/assets/global/plugins/bootstrap/css/bootstrap-rtl.min.css" rel="stylesheet" type="text/css" />
<link href="{{url('/')}}/assets/global/plugins/bootstrap-switch/css/bootstrap-switch-rtl.min.css" rel="stylesheet" type="text/css" />
<link href="{{url('/')}}/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
<link href="{{url('/')}}/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css" rel="stylesheet" type="text/css" />
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN THEME GLOBAL STYLES -->
<link href="{{url('/')}}/assets/global/css/components-md-rtl.min.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="{{url('/')}}/assets/global/css/plugins-md-rtl.min.css" rel="stylesheet" type="text/css" />
<!-- END THEME GLOBAL STYLES -->
<!-- BEGIN THEME LAYOUT STYLES -->
<link href="{{url('/')}}/assets/layouts/layout2/css/layout-rtl.min.css" rel="stylesheet" type="text/css" />
<link href="{{url('/')}}/assets/layouts/layout2/css/themes/light-rtl.min.css" rel="stylesheet" type="text/css" id="style_color" />
<link href="{{url('/')}}/assets/layouts/layout2/css/custom-rtl.min.css" rel="stylesheet" type="text/css" />
<!-- END THEME LAYOUT STYLES -->
<link rel="shortcut icon" href="favicon.ico" />
<style>
    @font-face {
        font-family: "helveticaneuelt";
        src: url("{{url('')}}/public/font/helveticaneueltarabic-roman-42.ttf") ;
    }

    body,h1,h2,h3,h4,h5,h6,tr,td,th {
        font-family: "helveticaneuelt" !important;
        direction: rtl;
    }
    select.input-sm {

        height: 32px;
    }
    .statusFilter3,.statusFilter1,.statusFilter2{

        font-size: 10px; !important;
    }
</style>
@stack('css')
