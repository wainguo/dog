@extends('frontend.layouts.one')

@section('content')
    <div class="breadcrumb">
        <span class="section"> 当前位置：</span>
        <a class="section" href="{{url('')}}">首页</a>
        <span>#</span>
        <span class="section">关于我们</span>
    </div>
    <div class="divider"></div>

    <div style="padding: 20px;">
        <h3 class="ui dividing header">关于我们</h3>
        <div class="discription">
            {{--<p>--}}
                {{--主要技术为: PHP(后端), MySQL(数据库), HTML/JS/CSS(前端)--}}
            {{--</p>--}}
            {{--<p>--}}
                {{--主要框架和工具库: Laravel(PHP), Semantic-UI(界面结构/样式), VueJS(前端JS),Jquery等等--}}
            {{--</p>--}}
            <p>
                "今天买点啥"由几位网购达人，自发建立的网购优惠推荐网站！以发现好的产品、好的优惠为目的。
                我们不卖产品，只推荐品质、靠谱、实惠的产品网购原创信息！
                打折，优惠，促销尽在“今天买点啥”！这是一个值得你收藏的网站！所推荐的优惠信息均具有一定的时效性，下单前请确认优惠有效。

                "今天买点啥"努力做好一件事情，就是帮助大家买到真正高性价比的商品。希望帮助消费者更多的了解产品信息，更好的判断产品品质以及性价比，通过优质产品改善自己的生活品质。
            </p>

            <p>
                今天买点啥(jtmds.cn)网站开始是由一位全栈，或称"全在"工程师，从零开始一点一滴全新自主研发的定位于购物推荐的服务平台。
            </p>
        </div>
    </div>
@endsection
