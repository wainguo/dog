<nav id="jtmdsNavbar" data-target="jtmdsContent">
    <div class="container nav-wrapper">
        {{--<a class="navbar-brand" href="/">今天买点啥</a>--}}
        <ul class="left hide-on-med-and-down">
            <li><a href="/">{{trans('navs.general.home')}}</a></li>
            <li><a href="{{url('/youhui')}}">国内优惠</a></li>
            <li><a href="{{url('/haitao')}}">海淘专区</a></li>
            <li><a href="{{url('/news')}}">资讯</a></li>
            <li><a href="{{url('/post')}}">原创</a></li>
            <li>
                {{--<a href="http://astore.amazon.com/jtmdscn-20" class="item">亚马逊</a>--}}
                <a href="{{url('/astore')}}">美亚海淘</a>
            </li>
            <li><a href="http://bbs.jtmds.cn">买吧·论坛</a></li>
            {{--<li class="nav-item dropdown">--}}
                {{--<a class="nav-link dropdown-toggle" href="http://example.com" id="supportedContentDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">更多</a>--}}
                {{--<div class="dropdown-menu" aria-labelledby="supportedContentDropdown">--}}
                    {{--<a class="dropdown-item" href="{{ url('/about') }}">关于我们</a>--}}
                    {{--<a class="dropdown-item" href="{{ url('/contact') }}">联系我们</a>--}}
                {{--</div>--}}
            {{--</li>--}}
        </ul>
        <ul class="right">
            @if (! $logged_in_user)
                <li>
                    {{ link_to_route('frontend.auth.login', trans('navs.frontend.login'), [], ['class' => 'nav-link']) }}
                </li>
                <li>
                    {{ link_to_route('frontend.auth.register', trans('navs.frontend.register'), [], ['class' => 'nav-link']) }}
                </li>
            @else
                <li>
                    <a href="{{ url('/article/baoliao') }}">爆料投稿</a>
                </li>
                <li>
                    <a class="dropdown-button" href="#!" data-activates="dropdown1">
                        {{ access()->user()->name }}
                        {{--<i class="material-icons right">arrow_drop_down</i>--}}
                    </a>
                </li>
                <ul id="dropdown1" class="dropdown-content">
                    <li>{{ link_to_route('frontend.user.dashboard', trans('navs.frontend.dashboard'), [], ['class' => 'dropdown-item']) }}</li>
                    @permission('view-backend')
                    <li>{{ link_to_route('admin.dashboard', trans('navs.frontend.user.administration'), [], ['class' => 'dropdown-item']) }}</li>
                    @endauth
                    <li>{{ link_to_route('frontend.user.account', trans('navs.frontend.user.account'), [], ['class' => 'dropdown-item']) }}</li>
                    <li>{{ link_to_route('frontend.auth.logout', trans('navs.general.logout'), [], ['class' => 'dropdown-item']) }}</li>
                </ul>
            @endif
        </ul>
    </div>
</nav>