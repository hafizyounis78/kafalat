<!doctype html>
<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Document</title>

    <link rel="stylesheet" media="screen" href="{{url('assets/xb-riyaz.css')}}" type="text/css"/>
    {{--<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />--}}
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
          type="text/css"/>
    <style>
        body, th, td {
            font-family: 'xbriyaz', sans-serif;

        }

        th, td {
            font-size: 13;

        }

        td {
            font-size: 12;

        }

        .table-title {
            border: 0;
        }

        .table, th, td {

            border: 1px solid grey;

        }

        .table {

            border-collapse: collapse;

        }

        th {
            text-align: right !important;
            /*   width: 20% !important;*/
        }

        hr {
            display: block;
            height: 1px;
            border: 0;
            border-top: 1px solid #ccc;
            margin: 1em 0;
            padding: 0;
        }
    </style>
</head>
<body>

<div class="page-content">
    <meta name="csrf-token" content="{{ csrf_token()}}">
    <table class="table " width="100%" id="report_tbl" cellpadding="10">
        <tr>

            <td width="45%"><h2>قطر الخيرية</h2></td>
            <td width="10%" style="alignment: center"><img src="{{url('')}}/assets/pages/img/logo3.jpg" alt="logo"
                                                           width="12%"/></td>
            <td width="45%" style="text-align: left"><h2>Qatar Charity</h2></td>
        </tr>
    </table>

    <table border="0" width="100%" id="report_tbl">
        <tr>
            <td width="100%" style="text-align: center;border-width: 0 !important;">
                <h1>تـقــرير بأنــواع التـقــارير</h1>
                <br/>
                <h2>&nbsp; من تاريخ&nbsp;{{(isset($fromdate))?$fromdate:''}}&nbsp;الى&nbsp;{{(isset($todate))?$todate:''}}&nbsp;</h2>
            </td>
        </tr>
    </table>
    <br/>


    <table class="table " width="100%" id="report_tbl" cellpadding="10">
        <thead>
        <tr>
            <th width="10%">#</th>
            <th width="40%">النوع</th>
            <th width="50%">المجموع</th>
        </tr>
        </thead>
        <tbody>
        {!! $model; !!}

        </tbody>

    </table>

</div>
</body>
</html>
