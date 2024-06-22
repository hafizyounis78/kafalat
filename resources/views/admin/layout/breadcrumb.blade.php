@if(isset($location_title))
    <ul class="page-breadcrumb">

        <li>
            <i class="icon-home"></i>
            <a href="{{url('home')}}">الرئيسية</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="{{url($location_link)}}">{{$location_title}}</a>
            @if(isset($page_title))
                <i class="fa fa-angle-right"></i>
            @endif
        </li>
        @if(isset($page_title))
            <li>
                <span>{{$page_title}}</span>
            </li>
        @endif
    </ul>
@endif
