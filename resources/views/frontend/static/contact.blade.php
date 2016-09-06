@extends('frontend.layouts.two')

@section('content')
    <div class="container">
        <div class="ui breadcrumb">
            <div class="section"> 当前位置：</div>
            <a class="section" href="{{url('')}}">首页</a>
            <i class="right angle icon divider"></i>
            <div class="section">联系我们</div>
        </div>

        <h4>若有任何问题，请通过以下途径联系我们：</h4>
        <div class="ui piled segments">
            <div class="ui segment">
                <p>商务合作：hezuo@jtmds.cn</p>
            </div>
            <div class="ui segment">
                <p>改进建议：http://www.jtmds.cn/feedback</p>
            </div>
            <div class="ui segment">
                <p>友情链接：http://www.jtmds.cn/links</p>
            </div>

            <div class="ui segment">
                <p>客服热线：service@jtmds.cn</p>
            </div>
            <div class="ui segment">
                <p>投稿相关：service@jtmds.cn</p>
            </div>
            <div class="ui segment">
                <p>友情链接：http://www.smzdm.com/links</p>
            </div>
        </div>
    </div>
@endsection
