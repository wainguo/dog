<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{{ csrf_token() }}" />

    <title>@yield('title', app_name())</title>

    <meta property="og:type" content="webpage"><meta property="og:url" content="http://www.jtmds.cn/">
    <meta property="og:title" content="今天买点啥 | 消费推荐新贵_网购决策中立门户">
    <meta property="og:description" content="今天买点啥是一个中立的、致力于帮助广大网友买到更有性价比网购产品的最热门推荐网站，值得您每天都来看看。我们每天为您提供经过甄选的、优质的、超值的国内、海外购物优惠信息，涵盖数码、个护、食品、家居、图书、服饰、母婴、首饰、运动等类别，数十万网友踊跃参与产品点评。如果您发现了好的优惠打折信息，也可通过我们与更多网友分享。">
    <meta name="mobile-agent" content="format=html5;url=http://m.jtmds.cn/">
    <!-- Meta -->
    <meta name="keywords" content="今天买点啥,买点啥,优惠精选,优惠券,优惠活动,海淘,购物经验,购物资讯">
    <meta name="description" content="@yield('meta_description', '今天买点啥（JTMDS.CN）是一家集导购、社区属性为一体的消费领域门户型网站，因其中立、专业而在众多网友中树立了良好口碑。今天买点啥网站力求成为消费者心目中的“品质消费第一站”，围绕品质消费理念，对所有消费场景下的消费者，以一站式入口提供更高效的消费决策 。')">
    <meta name="author" content="@yield('meta_author', 'wainguo')">
    {{--<meta name="apple-itunes-app" content="app-id=616615003">--}}
    <meta name="application-name" content="今天买点啥 | 消费推荐新贵_网购推荐中立门户">
    @yield('meta')

<!-- Styles -->
    @yield('before-styles-end')

    {{ Html::style(elixir('css/frontend.css')) }}
{{--    <link href="{{asset('assets/css/style.css') }}" rel="stylesheet">--}}
    @yield('after-styles-end')
    {!! Html::style('css/style.css') !!}

    <script>
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "//hm.baidu.com/hm.js?0870e6b89fb25207492ed2b7a523a90d";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
</head>
<body id="jtmdsBody">
<div class="ui borderless menu" id="headerTopArea">
    <div class="ui container">
        <div class="header">
            <img class="logo" src="{{asset('img/logo.png')}}" width="180" height="58">
        </div>
        <div class="ui right floated item" style="margin-right: -20px;width: 720px;">
            {{--<div class="ui small action left icon input">--}}
            {{--<i class="search icon"></i>--}}
            {{--<input type="text" placeholder="手机...">--}}
            {{--<button class="ui button">搜索</button>--}}
            {{--</div>--}}
            <span>{{ Session::get('wisdom') }}</span>
        </div>
        <div class="ui right floated item">
            <div class="right floated">
                <a class="ui circular twitter icon basic button">
                    <i class="weibo red icon"></i>
                </a>
                <button class="ui circular google plus icon button">
                    <i class="wechat icon"></i>
                </button>
            </div>
        </div>
    </div>
</div>

@include('frontend.includes.nav')