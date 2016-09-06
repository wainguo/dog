<nav class="ui large inverted main menu" id="headerMenu">
    <div class="ui container">
        {{--<a href="{{url('/')}}" class="header item">首页</a>--}}
        {{ link_to_route('frontend.index', trans('navs.general.home'), [], ['class' => 'header item']) }}
        <a href="{{url('/youhui')}}" class="item">国内优惠</a>
        <a href="{{url('/haitao')}}" class="item">海淘专区</a>
        <a href="{{url('/coupon')}}" class="item">优惠券</a>
        <a href="{{url('/news')}}" class="item">资讯</a>
        <a href="{{url('/post')}}" class="item">原创</a>
        <a href="http://bbs.jtmds.cn" class="item" target="_blank">买吧·论坛</a>
        <div class="ui dropdown item" tabindex="0">
            更多 <i class="dropdown icon"></i>
            <div class="menu" tabindex="-1">
                <a href="{{ url('/about') }}" class="item">关于我们</a>
                <a href="{{ url('/contact') }}" class="item">联系我们</a>
            </div>
        </div>
        <div class="right menu">
            {{--@if (Auth::guest())--}}
            @if (access()->guest())
                {{--<div class="item"><a href="{{ url('/login') }}">登录</a></div>--}}
                {{--<div class="item"><a href="{{ url('/register') }}">注册</a></div>--}}
                <div class="item">{{ link_to('login', trans('navs.frontend.login')) }}</div>
                <div class="item">{{ link_to('register', trans('navs.frontend.register')) }}</div>
            @else
                {{--<div class="login item link">登录</div>--}}

                <div class="item link">
                    <a href="{{ url('/article/edit') }}">爆料投稿</a>
                </div>
                <div class="ui dropdown item">
                    {{ access()->user()->name }}
                    <div class="menu">
                        {{ link_to_route('frontend.user.dashboard', trans('navs.frontend.dashboard'), [], ['class' => 'item']) }}

                        @if (access()->user()->canChangePassword())
                            {{ link_to_route('auth.password.change', trans('navs.frontend.user.change_password'), [], ['class' => 'item']) }}
                        @endif

                        @permission('view-backend')
                            {{ link_to_route('admin.dashboard', trans('navs.frontend.user.administration'), [], ['class' => 'item']) }}
                        @endauth

                        {{ link_to_route('auth.logout', trans('navs.general.logout'), [], ['class' => 'item']) }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</nav>