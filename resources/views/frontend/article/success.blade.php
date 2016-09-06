@extends('frontend.layouts.one')

@section('content')
    <div class="ui icon message">
        <i class="checkmark box green icon"></i>
        <div class="content">
            <div class="header">
                文章发布成功了，您可以选择
                <a href="{{url('/article/edit/'.$article_id)}}">继续编辑</a>
                或
                <a href="{{url('/p/'.$article_id)}}">查看文章</a>
            </div>
        </div>
    </div>
@endsection