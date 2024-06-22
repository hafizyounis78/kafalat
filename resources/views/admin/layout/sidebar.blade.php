<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <!-- END SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu " data-keep-expanded="false"
            data-auto-scroll="true" data-slide-speed="200">
            <li class="nav-item  @if($sub_menu=='home') active open  @endif">
                <a href="{{url('/home')}}" class="nav-link nav-toggle">
                    <i class="icon-home "></i>
                    <span class="title">الرئيسية</span>
                    <span class="arrow"></span>
                </a>
            </li>
            @foreach(auth()->user()->user_menu as $menu)
                <li class="nav-item {{@$sub_menu == "lawsuit" ?'open active' : ''}} ">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="{{$menu->menu_icon}}"></i>
                        <span class="title">{{$menu->menu_name}}</span>
                        <span class="arrow"></span>
                    </a>

                    <ul class="sub-menu">
                        @foreach($menu->sub_menu as $sub_menu)
                            <li class="nav-item  ">
                                <a href="{{url($sub_menu->screen_link)}}" class="nav-link ">
                                    <span class="title">{{$sub_menu->display_name}}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
          {{--  @if(auth()->user()->user_type==1)
                <li class="nav-item  @if($sub_menu=='user-display') active open  @endif">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-diamond"></i>
                        <span class="title">المستخدمين</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item  ">
                            <a href="{{url('/user')}}" class="nav-link ">
                                <span class="title">عرض المستخدمين</span>
                            </a>
                        </li>

                        <li class="nav-item  ">
                            <a href="{{url('/user/create')}}" class="nav-link ">
                                <span class="title">اضافة مستخدم</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            @if(auth()->user()->user_type==1 || auth()->user()->user_type==2 )
                <li class="nav-item @if($sub_menu=='event-display') active open   @endif ">
                    <a href="{{url('/attendance')}}" class="nav-link nav-toggle">
                        <i class="icon-puzzle"></i>
                        <span class="title">الحضور والإنصراف</span>
                        <span class="arrow"></span>
                    </a>
                    --}}{{--<ul class="sub-menu">--}}{{--
                    --}}{{--<li class="nav-item  ">--}}{{--
                    --}}{{--<a href="{{url('/attendance')}}" class="nav-link ">--}}{{--
                    --}}{{--<span class="title">عرض الحضور والإنصراف</span>--}}{{--
                    --}}{{--</a>--}}{{--
                    --}}{{--</li>--}}{{--

                    --}}{{--</ul>--}}{{--
                </li>
            @endif
            <li class="nav-item @if($sub_menu=='guardian-display') active open   @endif ">
                <a href="{{url('/guardian')}}" class="nav-link nav-toggle">
                    <i class="icon-puzzle"></i>
                    <span class="title"> الأوصياء</span>
                    <span class="arrow"></span>
                </a>
            </li>
            <li class="nav-item @if($sub_menu=='report-display') active open   @endif ">
                <a href="{{url('/report')}}" class="nav-link nav-toggle">
                    <i class="icon-puzzle"></i>
                    <span class="title">تقارير المستفيدين</span>
                    <span class="arrow"></span>
                </a>
                --}}{{--<ul class="sub-menu">--}}{{--
                --}}{{--<li class="nav-item  ">--}}{{--
                --}}{{--<a href="{{url('/report')}}" class="nav-link ">--}}{{--
                --}}{{--<span class="title">عرض التقارير</span>--}}{{--
                --}}{{--</a>--}}{{--
                --}}{{--</li>--}}{{--

                --}}{{--</ul>--}}{{--
            </li>
            @if(auth()->user()->user_type==1)
                <li class="nav-item @if($sub_menu=='systemReport-display') active open   @endif ">
                    <a href="{{url('system-report')}}" class="nav-link nav-toggle">
                        <i class="icon-puzzle"></i>
                        <span class="title">تقارير النظام</span>
                        <span class="arrow"></span>
                    </a>
                    --}}{{--<ul class="sub-menu">--}}{{--
                    --}}{{--<li class="nav-item  ">--}}{{--
                    --}}{{--<a href="{{url('/report')}}" class="nav-link ">--}}{{--
                    --}}{{--<span class="title">عرض التقارير</span>--}}{{--
                    --}}{{--</a>--}}{{--
                    --}}{{--</li>--}}{{--

                    --}}{{--</ul>--}}{{--
                </li>
            @endif
            @if(auth()->user()->user_type==1)
                <li class="nav-item  @if($sub_menu=='setting-display') active open  @endif">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-briefcase"></i>
                        <span class="title">اعدادات النظام</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item  ">
                            <a href="{{url('setting/s2')}}" class="nav-link ">
                                <span class="title"> جدول الثوابت</span>
                            </a>
                        </li>
                        <li class="nav-item  ">
                            <a href="{{url('setting/s4')}}" class="nav-link ">
                                <span class="title">اعدادات التقارير</span>
                            </a>
                        </li>

                    </ul>
                </li>
            @endif--}}

        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
<!-- END SIDEBAR -->
