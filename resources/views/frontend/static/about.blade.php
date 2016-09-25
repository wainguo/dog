@extends('frontend.layouts.two')

@section('content')
    <div class="container">
        <div class="ui breadcrumb">
            <div class="section"> 当前位置：</div>
            <a class="section" href="{{url('')}}">首页</a>
            <i class="right angle icon divider"></i>
            <div class="section">关于我们</div>
        </div>
    </div>

    <div style="padding: 20px;">
        <h3 class="ui dividing header">关于"我们"</h3>
        <div class="discription">
            <p>
                今天买点啥(jtmds.cn)是由一个全栈,或称全在工程师,利用业余时间从零开始开发的一套定位于购物推荐的服务平台.
            </p>
            <p>
                主要技术为: PHP(后端), MySQL(数据库), HTML/JS/CSS(前端)
            </p>
            <p>
                主要框架和工具库: Laravel(PHP), Semantic-UI(界面结构/样式), VueJS(前端JS),Jquery等等
            </p>
            <p>
                "今天买点啥"努力做好一件事情，就是帮助大家买到真正高性价比的商品。希望帮助消费者更多的了解产品信息，更好的判断产品品质以及性价比，通过优质产品改善自己的生活品质。
            </p>
        </div>

        <div class="ui divider"></div>
         <p>
            © copyright 2016 今天买点啥. 京ICP备11011542号
         </p>
    </div>
@endsection
