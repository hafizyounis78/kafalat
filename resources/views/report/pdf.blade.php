<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>تقرير</title>

    <link rel="stylesheet" media="screen" href="{{url('assets/xb-riyaz.css')}}" type="text/css"/>
    {{--<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />--}}
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
          type="text/css"/>
    <style>
        body, th, td {
            font-family: 'xbriyaz', sans-serif;

        }

        th, td {
            font-size: 13px;

        }

        td {
            font-size: 12px;

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

        .column {
            float: left;
            width: 50%;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        @page {
            header: page-header;
            footer: page-footer;

        }

        @page {
            margin-top: 200px;
            margin-bottom: 100px;
        }

        #r1_tbl {
            margin-top: 0px;
            margin-bottom: 0px;
        }

        /*   #page-header {top: -50px; position: fixed;}
         #page-footer {bottom: -50px; position: fixed;}*/
        /*  .page-content {margin-top: 100px; margin-bottom: 100px;}*/
    </style>
</head>
<body>


<div class="page-content">

    <meta name="csrf-token" content="{{ csrf_token()}}">

    <htmlpageheader name="page-header" id="page-header">

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
                <td width="100%" style="text-align: center;border-width: 0 !important;"><h1> تقرير حالة
                        - {{  $rep_type_desc }}</h1></td>
            </tr>
        </table>
        <br/>
        <br/>
    </htmlpageheader>
    <htmlpagefooter name="page-footer" id="page-footer">
        <div class="row">

            <div class="column">
                صفحة رقم {nb}/{PAGENO}
            </div>
            <div class="column">
                تاريخ الطباعة : {{ date('d-m-Y') }}
            </div>

        </div>

    </htmlpagefooter>

    <br/>
    <table class="table " width="100%" id="r1_tbl" cellpadding="5">
        <tr>
            <th width="15%">نوع التقرير</th>
            <td width="30%">{{isset($one_profile['account_type_desc'])?$one_profile['account_type_desc']:''}}</td>
            <th width="15%">@if(in_array(1, $rep_header))رقم الحالة@endif</th>
            <td width="10%">@if(in_array(1, $rep_header)){{isset($one_profile['beneficiary_id'])?$one_profile['beneficiary_id']:''}}@endif</td>
            <th width="15%">@if(in_array(2, $rep_header))رقم الكفالة@endif</th>
            <td width="15%">@if(in_array(2, $rep_header)){{isset($one_profile['sponser_id'])?$one_profile['sponser_id']:''}}@endif</td>
        </tr>
    </table>
    <br/>
    <table class="table " width="100%" id="r1_tbl" cellpadding="5">
        <tr>
            <th width="15%">حالة التقرير</th>
            <td width="30%">{{isset($one_report_status['status'])?$one_report_status['status']:''}}</td>
            <th width="15%">@if(in_array(75, $rep_header))تاريخ الحالة@endif</th>
            <td width="10%">@if(in_array(75, $rep_header)){{isset($one_report_status['created_at'])?$one_report_status['created_at']:''}}@endif</td>
            <th width="15%">@if(in_array(76, $rep_header))سبب الرفض@endif</th>
            <td width="15%">@if(in_array(76, $rep_header)){{isset($one_report_status['reject_reason'])?$one_report_status['reject_reason']:''}}@endif</td>
        </tr>
    </table>
    <h3 class="form-section">البيانات الشخصية</h3>
    <table class="table " width="100%" id="report_tbl" cellpadding="5">
        <tr>
            <th width="15%">الاسم</th>
            <td width="30%">{{isset($one_profile['full_name'])?$one_profile['full_name']:''}}</td>
            @if(in_array(3, $rep_header))
                <th width="10%">@if(in_array(3, $rep_header)) رقم الهوية@endif</th>
                <td width="15%">@if(in_array(3, $rep_header)) {{isset($one_profile['beneficiary_identity'])?$one_profile['beneficiary_identity']:''}}@endif</td>
            @endif
            @if(in_array(5, $rep_header))
                <th width="15%">@if(in_array(5, $rep_header))تاريخ الميلاد@endif</th>
                <td width="15%">@if(in_array(5, $rep_header)){{isset($one_profile['birth_date'])?$one_profile['birth_date']:''}}@endif</td>
            @endif
        </tr>
        <tr>
            @if(in_array(6, $rep_header))
                <th width="15%">@if(in_array(6, $rep_header))الحالة الإجتماعية@endif</th>
                <td width="30%">@if(in_array(6, $rep_header)){{isset($one_profile['marital_status'])?$one_profile['marital_status']:''}}@endif</td>
            @endif
            @if(in_array(4, $rep_header))
                <th width="10%">@if(in_array(4, $rep_header))الجنس@endif</th>
                <td width="15%">@if(in_array(4, $rep_header)){{isset($one_profile['gender'])?$one_profile['gender']:''}}@endif</td>
            @endif
            @if(in_array(7, $rep_header))
                <th width="15%">@if(in_array(7, $rep_header))الجنسية@endif</th>
                <td width="15%">@if(in_array(7, $rep_header)){{isset($one_profile['nationality'])?$one_profile['nationality']:''}}@endif</td>
            @endif
        </tr>
    </table>
    <h3 class="form-section">العنوان</h3>
    <table class="table " width="100%" id="report_tbl" cellpadding="10">
        <tr>
            @if(in_array(8, $rep_header))
                <th width="15%">@if(in_array(8, $rep_header))المحافظة@endif</th>
                <td width="20%">@if(in_array(8, $rep_header)){{isset($one_profile['governorate'])?$one_profile['governorate']:''}}@endif</td>
            @endif
            @if(in_array(9, $rep_header))
                <th width="10%">@if(in_array(9, $rep_header))المدينة@endif</th>
                <td width="10%">@if(in_array(9, $rep_header)){{isset($one_profile['city'])?$one_profile['city']:''}}@endif</td>
                <th width="10%">@if(in_array(9, $rep_header))الحي@endif</th>
                <td width="10%">@if(in_array(9, $rep_header)){{isset($one_profile['neighborhood'])?$one_profile['neighborhood']:''}}@endif</td>
            @endif
            @if(in_array(10, $rep_header))
                <th width="15%">@if(in_array(10, $rep_header))تفصيل العنوان@endif</th>
                <td width="30%">@if(in_array(10, $rep_header)){{isset($one_profile['full_address'])?$one_profile['full_address']:''}}@endif</td>
            @endif
        </tr>
    </table>
    @if($one_profile['account_type']==1)
        @if(in_array(33, $rep_header) || (in_array(34, $rep_header)) ||(in_array(35, $rep_header)))
            <h3 class="form-section">مكان الإقامة</h3>
            <table class="table " width="100%" id="report_tbl" cellpadding="10">
                <tr>
                    @if(in_array(33, $rep_header))
                        <th width="15%">@if(in_array(33, $rep_header))الاقامة الحالية@endif</th>
                        <td width="20%">@if(in_array(33, $rep_header)){{isset($one_profile['home_location'])?$one_profile['home_location']:''}}@endif</td>
                    @endif
                    @if(in_array(34, $rep_header))
                        <th width="18%">@if(in_array(34, $rep_header))اقرب مركز تحفيظ@endif</th>
                        <td width="15%">@if(in_array(34, $rep_header)){{isset($one_profile['nearist_quran'])?$one_profile['nearist_quran']:''}}@endif</td>
                    @endif
                    @if(in_array(35, $rep_header))
                        <th width="15%">@if(in_array(35, $rep_header))اقرب جمعية@endif</th>
                        <td width="17%">@if(in_array(35, $rep_header)){{isset($one_profile['nearist_institute'])?$one_profile['nearist_institute']:''}}@endif</td>
                    @endif


                </tr>
            </table>
        @endif
    @endif
    @if($one_profile['account_type']==1)
        @if(in_array(36, $rep_header) || (in_array(37, $rep_header)) ||(in_array(38, $rep_header)))
            <h3 class="form-section">بيانات الوصي</h3>
            <table class="table " width="100%" id="report_tbl" cellpadding="10">
                <tr>
                    @if(in_array(36, $rep_header))
                        <th width="15%">@if(in_array(36, $rep_header))الوصي@endif</th>
                        <td width="20%">@if(in_array(36, $rep_header)){{isset($one_profile['guardian'])?$one_profile['guardian']:''}}@endif</td>
                    @endif
                    @if(in_array(37, $rep_header))
                        <th width="15%">@if(in_array(37, $rep_header))رقم الهوية@endif</th>
                        <td width="15%">@if(in_array(37, $rep_header)){{isset($one_profile['guardian_identity'])?$one_profile['guardian_identity']:''}}@endif</td>
                    @endif
                    @if(in_array(38, $rep_header))
                        <th width="15%">@if(in_array(38, $rep_header))نوع العلاقة@endif</th>
                        <td width="20%">@if(in_array(38, $rep_header)){{isset($one_profile['guardian_relation'])?$one_profile['guardian_relation']:''}}@endif</td>
                    @endif
                </tr>
                <tr>
                    @if(in_array(62, $rep_header))
                        <th width="15%">@if(in_array(62, $rep_header))المحافظة@endif</th>
                        <td width="20%">@if(in_array(62, $rep_header)){{isset($one_guardian['district_name'])?$one_guardian['district_name']:''}}@endif</td>
                    @endif
                    @if(in_array(63, $rep_header))
                        <th width="15%">@if(in_array(63, $rep_header))المدينة@endif</th>
                        <td width="15%">@if(in_array(62, $rep_header)){{isset($one_guardian['city_name'])?$one_guardian['city_name']:''}}@endif</td>
                    @endif
                    @if(in_array(64, $rep_header))
                        <th width="15%">@if(in_array(64, $rep_header))الحي@endif</th>
                        <td width="20%">@if(in_array(64, $rep_header)){{isset($one_guardian['neighborhood'])?$one_guardian['neighborhood']:''}}@endif</td>
                    @endif
                </tr>
                <tr>
                    @if(in_array(65, $rep_header))
                        <th width="15%">@if(in_array(65, $rep_header))العنوان@endif</th>
                        <td width="20%">@if(in_array(65, $rep_header)){{isset($one_guardian['full_address'])?$one_guardian['full_address']:''}}@endif</td>
                    @endif
                    @if(in_array(60, $rep_header))
                        <th width="15%">@if(in_array(60, $rep_header))جوال@endif</th>
                        <td width="15%">@if(in_array(60, $rep_header)){{isset($one_guardian['mobile1'])?$one_guardian['mobile1']:''}}@endif</td>
                    @endif
                    @if(in_array(61, $rep_header))
                        <th width="15%">@if(in_array(61, $rep_header))جوال طوارئ@endif</th>
                        <td width="20%">@if(in_array(61, $rep_header)){{isset($one_guardian['mobile2'])?$one_guardian['mobile2']:''}}@endif</td>
                    @endif
                </tr>
                <tr>
                    @if(in_array(66, $rep_header))
                        <th width="15%">@if(in_array(66, $rep_header))المعيل@endif</th>
                        <td width="20%">@if(in_array(66, $rep_header)){{isset($one_guardian['supporter_name'])?$one_guardian['supporter_name']:''}}@endif</td>
                    @endif
                    @if(in_array(77, $rep_header))
                        <th width="15%">@if(in_array(77, $rep_header))رقم الهوية@endif</th>
                        <td width="15%">@if(in_array(77, $rep_header)){{isset($one_guardian['supporter_identity'])?$one_guardian['supporter_identity']:''}}@endif</td>
                    @endif
                    @if(in_array(38, $rep_header))
                        <th width="15%">@if(in_array(38, $rep_header))نوع العلاقة@endif</th>
                        <td width="20%">@if(in_array(38, $rep_header)){{isset($one_guardian['supporter_relationship_name'])?$one_guardian['supporter_relationship_name']:''}}@endif</td>
                    @endif
                </tr>
                <tr>
                    @if(in_array(67, $rep_header))
                        <th width="15%">@if(in_array(67, $rep_header))تاريخ انتهاء البطاقة@endif</th>
                        <td width="20%">@if(in_array(67, $rep_header)){{isset($one_guardian['card_date_expired'])?$one_guardian['card_date_expired']:''}}@endif</td>
                    @endif
                    @if(in_array(77, $rep_header))
                        <th width="15%">@if(in_array(77, $rep_header))تاريخ انتهاء الوصاية@endif</th>
                        <td width="15%">@if(in_array(77, $rep_header)){{isset($one_guardian['guardianship_date_expired'])?$one_guardian['guardianship_date_expired']:''}}@endif</td>
                    @endif
                    {{-- @if(in_array(77, $rep_header))
                         <th width="15%">@if(in_array(77, $rep_header))@endif</th>
                         <td width="20%">@if(in_array(77, $rep_header))@endif</td>
                     @endif--}}
                </tr>
            </table>
        @endif
    @endif
    @if(in_array(11, $rep_header) || (in_array(12, $rep_header)) ||(in_array(13, $rep_header)))
        <h3 class="form-section">بيانات الإتصال</h3>
        <table class="table " width="100%" id="report_tbl" cellpadding="10">
            <tr>
                @if(in_array(11, $rep_header))
                    <th width="15%">@if(in_array(11, $rep_header))جوال@endif</th>
                    <td width="20%">@if(in_array(11, $rep_header)){{isset($one_profile['mobile_no'])?$one_profile['mobile_no']:''}}@endif</td>
                @endif
                @if(in_array(12, $rep_header))
                    <th width="15%">@if(in_array(12, $rep_header))جوال اخر@endif</th>
                    <td width="20%">@if(in_array(12, $rep_header)){{isset($one_profile['mobile_no1'])?$one_profile['mobile_no1']:''}}@endif</td>
                @endif
                @if(in_array(13, $rep_header))
                    <th width="10%">@if(in_array(13, $rep_header))هاتف@endif</th>
                    <td width="20%">@if(in_array(13, $rep_header)){{isset($one_profile['phone'])?$one_profile['phone']:''}}@endif</td>
                @endif
            </tr>
        </table>
    @endif


    @if($one_profile['account_type']==1)
        @if(in_array(39, $rep_header)||(in_array(40, $rep_header))||(in_array(41, $rep_header))||(in_array(42, $rep_header))||(in_array(43, $rep_header)))
            <h3 class="form-section">الحالة التعليمية</h3>
            <table class="table " width="100%" id="report_tbl" cellpadding="10">
                <tr>
                    <th width="15%">@if(in_array(39, $rep_header))اسم المدرسة@endif</th>
                    <td width="20%">@if(in_array(39, $rep_header)){{isset($one_school['school_name'])?$one_school['school_name']:''}}@endif</td>
                    <th width="18%">@if(in_array(40, $rep_header)) المرحلة الدراسية@endif</th>
                    <td width="20%">@if(in_array(40, $rep_header)){{isset($one_school['study_level'])?$one_school['study_level']:''}}@endif</td>
                    <th width="10%">@if(in_array(41, $rep_header))الصف@endif</th>
                    <td width="17%">@if(in_array(41, $rep_header)){{isset($one_school['study_class'])?$one_school['study_class']:''}}@endif</td>
                </tr>
                <tr>
                    <th width="15%">@if(in_array(42, $rep_header))نتيجة العام %@endif</th>
                    <td width="20%">@if(in_array(42, $rep_header)){{isset($one_school['current_avg'])?$one_school['current_avg']:''}}@endif</td>
                    <th width="18%">@if(in_array(43, $rep_header))المستوى الحالي@endif</th>
                    <td width="20%"
                        colspan="3">@if(in_array(43, $rep_header)){{isset($one_school['currentlevel'])?$one_school['currentlevel']:''}}@endif</td>
                </tr>
            </table>
        @endif
    @endif
    @if($one_profile['account_type']==4)
        @if(in_array(53, $rep_header)||(in_array(54, $rep_header))||(in_array(55, $rep_header))||(in_array(56, $rep_header))||(in_array(57, $rep_header)))
            <h3 class="form-section">بيانات الدراسة</h3>
            <table class="table " width="100%" id="report_tbl" cellpadding="10">
                <tr>
                    @if(in_array(53, $rep_header))
                        <th width="20%">@if(in_array(53, $rep_header))الجامعة/الكلية@endif</th>
                        <td width="30%"
                            colspan="2">@if(in_array(53, $rep_header)){{isset($one_university['university_name'])?$one_university['university_name']:''}}@endif</td>
                    @endif
                    @if(in_array(54, $rep_header))
                        <th width="20%">@if(in_array(54, $rep_header))التخصص الرئيسي@endif</th>
                        <td width="30%"
                            colspan="2">@if(in_array(54, $rep_header)){{isset($one_university['university_major'])?$one_university['university_major']:''}}@endif</td>
                    @endif

                </tr>
                <tr>
                    @if(in_array(55, $rep_header))
                        <th width="20%">@if(in_array(55, $rep_header)) المستوى الدراسي@endif</th>
                        <td width="15%">@if(in_array(55, $rep_header)){{isset($one_university['university_level'])?$one_university['university_level']:''}}@endif</td>
                    @endif
                    @if(in_array(56, $rep_header))
                        <th width="20%">@if(in_array(56, $rep_header))التقدير الحالي %@endif</th>
                        <td width="10%">@if(in_array(56, $rep_header)){{isset($one_university['current_avg'])?$one_university['current_avg']:''}}@endif</td>
                    @endif
                    @if(in_array(57, $rep_header))
                        <th width="20%">@if(in_array(57, $rep_header))المستوى الحالي@endif</th>
                        <td width="15%">@if(in_array(57, $rep_header)){{isset($one_university['current_level'])?$one_university['current_level']:''}}@endif</td>
                    @endif

                </tr>
            </table>
        @endif
    @endif

    @if($one_profile['account_type']==1)
        @if(in_array(44, $rep_header)||(in_array(45, $rep_header))||(in_array(46, $rep_header))||(in_array(47, $rep_header))||(in_array(48, $rep_header)))
            <h3 class="form-section">الحالة التربوية</h3>
            <table class="table " width="100%" id="report_tbl" cellpadding="10">
                <tr>
                    <th width="15%">@if(in_array(44, $rep_header))المداومة على الصلاة@endif</th>
                    <td width="20%">@if(in_array(44, $rep_header)){{isset($one_religion['praying'])?$one_religion['praying']:''}}@endif</td>
                    <th width="18%">@if(in_array(45, $rep_header))حفظ القران@endif</th>
                    <td width="20%">@if(in_array(45, $rep_header)){{isset($one_religion['memorizes_quran'])?$one_religion['memorizes_quran']:''}}@endif</td>
                    <th width="20%">@if(in_array(46, $rep_header))عدد الأجزاء@endif</th>
                    <td width="10%">@if(in_array(46, $rep_header)){{isset($one_religion['parts_no'])?$one_religion['parts_no']:''}}@endif</td>
                </tr>
                <tr>
                    <th width="15%">@if(in_array(47, $rep_header))عدد السور@endif</th>
                    <td width="10%">@if(in_array(47, $rep_header)){{isset($one_religion['sura_no'])?$one_religion['sura_no']:''}}@endif</td>
                    <th width="25%">@if(in_array(48, $rep_header))مهارات ومواهب@endif</th>
                    <td width="10%"
                        colspan="3">@if(in_array(48, $rep_header)){{isset($one_religion['skills'])?$one_religion['skills']:''}}@endif</td>
                </tr>
            </table>
        @endif
        @if(in_array(49, $rep_header)||(in_array(50, $rep_header))||(in_array(51, $rep_header))||(in_array(52, $rep_header)))
            <h3 class="form-section">الحالة الصحية</h3>
            <table class="table " width="100%" id="report_tbl" cellpadding="10">
                <tr>
                    <th width="23%">@if(in_array(49, $rep_header))الحالة الصحية@endif</th>
                    <td width="77%">@if(in_array(49, $rep_header)){{isset($one_health['health_status'])?$one_health['health_status']:''}}@endif</td>
                </tr>
                <tr>
                    <th width="23%">@if(in_array(50, $rep_header))تفاصيل الحالة الصحية@endif</th>
                    <td width="77%">@if(in_array(50, $rep_header)){{isset($one_health['health_status_details'])?$one_health['health_status_details']:''}}@endif</td>
                </tr>
                <tr>
                    <th width="23%">@if(in_array(51, $rep_header))تفاصيل الوضع الغذائي@endif</th>
                    <td width="77%">@if(in_array(51, $rep_header)){{isset($one_health['food_details'])?$one_health['food_details']:''}}@endif</td>
                </tr>
                <tr>
                    <th width="23%">@if(in_array(52, $rep_header))تفاصيل الأنشطة الحالية@endif</th>
                    <td width="77%">@if(in_array(52, $rep_header)){{isset($one_health['workout_details'])?$one_health['workout_details']:''}}@endif</td>
                </tr>
            </table>
        @endif
    @endif
    @if($one_profile['account_type']==3)
        @if(in_array(58, $rep_header) || (in_array(59, $rep_header)) )
            <h3 class="form-section">تقرير الإعاقة</h3>
            <table class="table " width="100%" id="report_tbl" cellpadding="10">
                @if(in_array(58, $rep_header))
                    <tr>

                        <th width="20%">@if(in_array(58, $rep_header))نوع الاعاقة@endif</th>
                        <td width="80%">@if(in_array(58, $rep_header)){{isset($one_obstruction['obstruction_type'])?$one_obstruction['obstruction_type']:''}}@endif</td>
                    </tr>
                @endif
                @if(in_array(59, $rep_header))
                    <tr>
                        <th width="20%">@if(in_array(59, $rep_header)) تفصيل الاعاقة@endif</th>
                        <td width="80%">@if(in_array(59, $rep_header)){{isset($one_obstruction['obstruction_details'])?$one_obstruction['obstruction_details']:''}}@endif</td>
                    </tr>
                @endif
            </table>
        @endif
    @endif

    <h3 class="form-section">بيانات السكن</h3>
    <table class="table " width="100%" id="report_tbl" cellpadding="10">
        @if(in_array(14, $rep_header))
            <tr>
                <th width="20%">@if(in_array(14, $rep_header))تفاصيل السكن الحالي@endif</th>
                <td width="80%"
                    colspan="3">@if(in_array(14, $rep_header)){{isset($one_live['live_details'])?$one_live['live_details']:''}}@endif</td>
            </tr>
        @endif
        @if(in_array(15, $rep_header)||  (in_array(16, $rep_header)))
            <tr>
                @if(in_array(15, $rep_header))
                    <th width="20%">@if(in_array(15, $rep_header))مساحة السكن@endif</th>
                    <td width="30%">@if(in_array(15, $rep_header)){{isset($one_live['live_area'])?$one_live['live_area']:''}}@endif</td>
                @endif
                @if(in_array(15, $rep_header))
                    <th width="20%">@if(in_array(16, $rep_header))ملكية السكن@endif</th>
                    <td width="30%">@if(in_array(16, $rep_header)){{isset($one_live['live_type'])?$one_live['live_type']:''}}@endif</td>
                @endif
            </tr>
        @endif
        @if(in_array(17, $rep_header))
            <tr>
                <th width="20%">@if(in_array(17, $rep_header))احتياجات السكن @endif</th>
                <td width="80%"
                    colspan="3">@if(in_array(17, $rep_header)){{isset($one_live['live_needs'])?$one_live['live_needs']:''}}@endif</td>
            </tr>
        @endif
        @if(in_array(18, $rep_header))
            <tr>
                <th width="20%">@if(in_array(18, $rep_header))احتياجات التطوير@endif</th>
                <td width="80%"
                    colspan="3">@if(in_array(18, $rep_header)){{isset($one_live['development_needs'])?$one_live['development_needs']:''}}@endif</td>

            </tr>
        @endif
    </table>
    @if(in_array(19, $rep_header)||(in_array(20, $rep_header)) ||(in_array(21, $rep_header))||(in_array(22, $rep_header)))
        <h3 class="form-section">الإحتياجات</h3>

        <table class="table " width="100%" id="report_tbl" cellpadding="10">
            <thead>
            <tr>
                <th>#</th>
                <th>الاحتياج الحالي</th>
                <th>تكلفة الاحتياج</th>
                <th>العملة</th>
                <th>تفاصيل الاحتياج</th>
            </tr>
            </thead>
            <tbody>
            {!! $one_orphan !!}
            </tbody>
        </table>
        {{--<table class="table " width="100%" id="report_tbl" cellpadding="10">
            @if(in_array(19, $rep_header))
                <tr>
                    <th width="20%">@if(in_array(19, $rep_header))الاحتياج الحالي@endif</th>
                    <td width="80%"
                        colspan="3">@if(in_array(19, $rep_header)){{isset($one_orphan['what_needed'])?$one_orphan['what_needed']:''}}@endif</td>
                </tr>
            @endif
            @if(in_array(22, $rep_header))
                <tr>
                    <th width="20%">@if(in_array(22, $rep_header))تفاصيل الاحتياج@endif</th>
                    <td width="80%"
                        colspan="3">@if(in_array(22, $rep_header)){{isset($one_orphan['needed_details'])?$one_orphan['needed_details']:''}}@endif</td>

                </tr>
            @endif
            @if(in_array(20, $rep_header)||in_array(21, $rep_header))
                <tr>
                    @if(in_array(20, $rep_header))
                        <th width="20%">@if(in_array(20, $rep_header))تكلفة الاحتياج@endif</th>
                        <td width="30%">@if(in_array(20, $rep_header)){{isset($one_orphan['needed_price'])?$one_orphan['needed_price']:''}}@endif</td>
                    @endif
                    @if(in_array(21, $rep_header))
                        <th width="20%">@if(in_array(21, $rep_header))العملة@endif</th>
                        <td width="30%">@if(in_array(21, $rep_header)){{isset($one_orphan['currency'])?$one_orphan['currency']:''}}@endif</td>
                    @endif
                </tr>
            @endif
        </table>--}}
    @endif
    @if(in_array(71, $rep_header)||(in_array(72, $rep_header)) ||(in_array(73, $rep_header))||(in_array(74, $rep_header)))
        <h3 class="form-section">البطاقة الإحصائية</h3>

        <table class="table " width="100%" id="report_tbl" cellpadding="10">
            <thead>
            <tr>
                <th>#</th>
                <th>تصنيف الاحتياج</th>
                <th>نوع الاحتياج</th>
                <th>مخرج الاحتياج</th>

            </tr>
            </thead>
            <tbody>
            {!! $one_statisticard !!}
            </tbody>
        </table>
        <h3 class="form-section">احتياجات اخرى</h3>
        <table class="table " width="100%" id="report_tbl" cellpadding="10">
            <tr>
                <td width="100%"
                    colspan="3">@if(in_array(74, $rep_header)){{isset($one_otherNeed['need_details'])?$one_otherNeed['need_details']:''}}@endif</td>
            </tr>
        </table>
        <h3 class="form-section">قصة نجاح</h3>
        <table class="table " width="100%" id="report_tbl" cellpadding="10">
            <tr>
                <td width="100%"
                    colspan="3">@if(in_array(74, $rep_header)){{isset($one_story['story_details'])?$one_story['story_details']:''}}@endif</td>
            </tr>
        </table>
    @endif
    @if(in_array(23, $rep_header)||(in_array(24, $rep_header)) ||(in_array(25, $rep_header)))
        <h3 class="form-section">مشروع مقترح</h3>
        <table class="table " width="100%" id="report_tbl" cellpadding="10">
            @if(in_array(23, $rep_header))
                <tr>
                    <th width="20%">@if(in_array(23, $rep_header))نوع المشروع@endif</th>
                    <td width="80%">@if(in_array(23, $rep_header)){{isset($one_family['project_name'])?$one_family['project_name']:''}}@endif</td>
                </tr>
            @endif
            @if(in_array(24, $rep_header))
                <tr>
                    <th width="20%">@if(in_array(24, $rep_header))وصف المشروع@endif</th>
                    <td width="80%">@if(in_array(24, $rep_header)){{isset($one_family['project_details'])?$one_family['project_details']:''}}@endif</td>
                </tr>
            @endif
            @if(in_array(25, $rep_header))
                <tr>
                    <th width="20%">@if(in_array(25, $rep_header))عوامل نجاح المشروع@endif</th>
                    <td width="80%">@if(in_array(25, $rep_header)){{isset($one_family['success_indecation'])?$one_family['success_indecation']:''}}@endif</td>
                </tr>
            @endif
        </table>
    @endif
    @if($rep_type==2)
        <h3 class="form-section">تقرير الزيارة</h3>
        <table class="table " width="100%" id="report_tbl" cellpadding="10">
            <tr>
                <th width="20%">@if(in_array(26, $rep_header))اهداف الزيارة@endif</th>
                <td width="80%">@if(in_array(26, $rep_header)){{isset($one_visit_report['visitor_goals'])?$one_visit_report['visitor_goals']:''}}@endif</td>
            </tr>
            <tr>
                <th width="20%">@if(in_array(27, $rep_header))تطورات صحية@endif</th>
                <td width="80%">@if(in_array(27, $rep_header)){{isset($one_visit_report['health_updates'])?$one_visit_report['health_updates']:''}}@endif</td>
            </tr>
            <tr>
                <th width="20%">@if(in_array(28, $rep_header))تطورات تعليمية@endif</th>
                <td width="80%">@if(in_array(28, $rep_header)){{isset($one_visit_report['educational_updates'])?$one_visit_report['educational_updates']:''}}@endif</td>
            </tr>
            <tr>
                <th width="20%">@if(in_array(29, $rep_header))تطورات اقتصادية@endif</th>
                <td width="80%">@if(in_array(29, $rep_header)){{isset($one_visit_report['economical_updates'])?$one_visit_report['economical_updates']:''}}@endif</td>
            </tr>
            <tr>
                <th width="20%">@if(in_array(30, $rep_header))تطورات اجتماعية@endif</th>
                <td width="80%">@if(in_array(30, $rep_header)){{isset($one_visit_report['social_updates'])?$one_visit_report['social_updates']:''}}@endif</td>
            </tr>
            <tr>
                <th width="20%">@if(in_array(69, $rep_header))تطورات المسكن@endif</th>
                <td width="80%">@if(in_array(69, $rep_header)){{isset($one_visit_report['living_updates'])?$one_visit_report['living_updates']:''}}@endif</td>
            </tr>
            <tr>
                <th width="20%">@if(in_array(70, $rep_header)) ملاحظات عامة@endif</th>
                <td width="80%">@if(in_array(70, $rep_header)){{isset($one_visit_report['general_note'])?$one_visit_report['general_note']:''}}@endif</td>
            </tr>
            <tr>
                <th width="20%">@if(in_array(31, $rep_header))توصيات الباحث@endif</th>
                <td width="80%">@if(in_array(31, $rep_header)){{isset($one_visit_report['visitor_recommend'])?$one_visit_report['visitor_recommend']:''}}@endif</td>
            </tr>
            <tr>
                <th width="20%">@if(in_array(32, $rep_header))سبب الإلغاء / الإيقاف@endif</th>
                <td width="80%">@if(in_array(32, $rep_header)){{isset($one_visit_report['visitor_stop_resone'])?$one_visit_report['visitor_stop_resone']:''}}@endif</td>

            </tr>
        </table>
    @endif
</div>

</body>
</html>
