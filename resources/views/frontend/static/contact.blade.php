@extends('frontend.layouts.one')

@section('content')
    <div class="breadcrumb">
        <span class="section"> 当前位置：</span>
        <a class="section" href="{{url('')}}">首页</a>
        <span>#</span>
        <span class="section">联系我们</span>
    </div>
    <div class="divider"></div>

    <h4>若有任何问题，请通过以下途径联系我们：</h4>
    <div class="ui piled segments">
        <div class="ui segment">
            <p>商务合作：44862914#qq.com</p>
        </div>
        <div class="ui segment">
            <p>改进建议：44862914#qq.com</p>
        </div>
        <div class="ui segment">
            <p>友情链接：44862914#qq.com</p>
            {{--<p>友情链接：http://www.jtmds.cn/links</p>--}}
        </div>

        <div class="ui segment">
            <p>客服热线：44862914#qq.com</p>
        </div>
        <div class="ui segment">
            <p>投稿相关：44862914#qq.com</p>
        </div>
    </div>
    <small>请将以上"#" 替换成 "@"</small>
@endsection
