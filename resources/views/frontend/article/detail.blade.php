@extends('frontend.layouts.two')

@section('content')
    <div id="jtmdsArticle">
        @if(session('toast_message'))
            <input type="hidden" id="success_message"
                   v-model="toast_message"
                   value="{{session('toast_message')}}">
        @endif

        <div class="breadcrumb">
            <span class="section"> 当前位置：</span>
            <a class="section" href="{{url('')}}">首页</a>
            @if(!empty($article->channel))
                <span>#</span>
                <a class="section" href="{{ url('/'.$article->channel->channel_name) }}">{{$article->channel->channel_title}}</a>
            @endif
            <span>#</span>
            <span class="section">文章详情</span>
        </div>
        <div class="divider"></div>

        <div class="row valign-wrapper">
            <div class="col s3">
                <a href="{{ url('/p/'.$article->id) }}">
                    <img src="{{empty($article->cover)? '/img/jtmds.png' : $article->cover}}" alt="{{ $article->title }}" class="responsive-img">
                </a>
            </div>
            <div class="col s9">
                <h5 class="header">
                    {{ $article->title }}<span style="color:#d62222">{{ $article->subtitle }}</span>
                </h5>
                <div class="meta grey-text">
                    <small class="right">{{ $article->created_at }}</small>
                    @if(count($article->tags))
                        <small>
                            <span>标签：</span>
                            @foreach ($article->tags as $tag)
                                <a href="#">{{$tag->tag_name}}</a>
                            @endforeach
                        </small>
                    @endif
                </div>
                <div class="description">
                    <div>{{ $article->excerpt }}</div>
                </div>
                <div class="meta">
                    <!-- JiaThis Button BEGIN -->
                    {{--<div class="jiathis_style">--}}
                        {{--<div style="display:block; margin-top: 10px;">--}}
                            {{--<span class="jiathis_txt">分享到：</span>--}}
                            {{--<a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jiathis_separator jtico jtico_jiathis" target="_blank">分享到：</a>--}}
                            {{--<a class="jiathis_button_qzone">QQ空间</a>--}}
                            {{--<a class="jiathis_button_tsina">微博</a>--}}
                            {{--<a class="jiathis_button_weixin">微信</a>--}}
                            {{--<a class="jiathis_counter_style"></a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <!-- JiaThis Button END -->
                    @if(isset($article->url))
                        <a href="{{$article->url}}" target="_blank" class="btn btn-small red lighten-1 right">直达链接</a>
                        <a class="modal-trigger waves-effect waves-light btn btn-small right" href="#qrcodeModal">扫码购买</a>
                    @endif

                    {{--<small>推荐人： {{ $article->user_name }}</small>--}}
                    <small>
                        @if(isset($article->mall->mall_url))
                            <a href="{{$article->mall->mall_url}}"  class="grey-text">{{$article->mall->mall_name}}</a>
                        @endif
                        <a href="{{url('/p/'.$article->id)}}"  class="grey-text">阅读 {{$article->view_count}}</a>
                        <a href="{{url('/p/'.$article->id.'#comments')}}"  class="grey-text">评论 {{$article->comment_count}}</a>
                    </small>
                </div>
            </div>
        </div>
        {{--<div class="ui items">--}}
            {{--<div class="item">--}}
                {{--<div class="content">--}}
                    {{--<div class="extra">--}}

                        {{--<a class="mini ui red right floated button" href="{{$article->url}}">直达链接 <i class="chevron right icon"></i></a>--}}
                        {{--<button class="mini ui basic right floated button weixinQr" data-position="right center">--}}
                            {{--<i class="qrcode icon"></i>扫码购买</button>--}}
                        {{--<div class="ui flowing popup top left transition hidden">--}}
                            {{--<div class="ui image">--}}
                                {{--<div id="qrcode"></div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

        <!-- qrcode Modal Structure -->
        <div id="qrcodeModal" class="modal modal-fixed-footer">
            <div class="modal-content">
                <div id="qrcode"></div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Agree</a>
            </div>
        </div>

        <div class="divider"></div>

        <div class="row valign-wrapper article-detail">
            <div class="col s12">
                {!! $article->content !!}
            </div>
        </div>

        <div class="divider"></div>
        <div>
            <div class="right">
            @if(!Auth::guest() && $article->user_id == Auth::user()->id)
                <a href="{{url('article/edit/'.$article->id)}}">编辑</a>|
            @endif
                <a>收藏</a>|<a>分享</a>|<a>缺货/变价/错误举报</a>
            </div>
            <p class="grey-text">
                以上图片等引用来自互联网，仅供参考
            </p>
        </div>


            <div class="fixed-action-btn click-to-toggle">
                <a class="btn-floating btn-large red">
                    啥
                </a>
                <ul>
                    <li><a class="btn-floating red">今</a></li>
                    <li><a class="btn-floating yellow darken-1">天</a></li>
                    <li><a class="btn-floating green">买</a></li>
                    <li><a class="btn-floating blue">点</a></li>
                </ul>
            </div>

        {{--@if($article->comment_status == 'open')--}}
        {{--<div id="comments" class="ui comments" v-cloak>--}}
            {{--<h3 class="ui header">评论</h3>--}}

            {{--<div class="comment" v-for="comment in comments">--}}
                {{--<a class="avatar">--}}
                    {{--<img v-bind:src="'/storage/avatar/'+comment.user_id+'.jpg'">--}}
                {{--</a>--}}
                {{--<div class="content">--}}
                    {{--<a class="author" v-text="comment.user_name"></a>--}}
                    {{--<div class="metadata">--}}
                        {{--<span class="date" v-text="comment.created_at"></span>--}}
                    {{--</div>--}}
                    {{--<div class="text">--}}
                        {{--<p><span v-text="comment.content"></span></p>--}}
                    {{--</div>--}}
                    {{--<div class="actions">--}}
                        {{--<a class="reply" v-on:click="doClickReply(comment.id, comment.user_name)">回复</a>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="comments" v-if="comment.replies && comment.replies.length">--}}
                    {{--<div class="comment" v-for="reply in comment.replies">--}}
                        {{--<a class="avatar">--}}
                            {{--<img v-bind:src="'/storage/avatar/'+reply.user_id+'.jpg'">--}}
                        {{--</a>--}}
                        {{--<div class="content">--}}
                            {{--<a class="author" v-text="reply.user_name"></a>--}}
                            {{--<div class="metadata">--}}
                                {{--<span class="date" v-text="reply.created_at"></span>--}}
                            {{--</div>--}}
                            {{--<div class="text">--}}
                                {{--<p><span v-text="reply.content"></span></p>--}}
                            {{--</div>--}}
                            {{--<div class="actions">--}}
                                {{--<a class="reply" v-on:click="doClickReply(reply.parent_id, reply.user_name)">回复</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<ul class="collection">--}}
                {{--<li class="collection-item avatar" v-for="comment in comments">--}}
                    {{--<img v-bind:src="'/storage/avatar/'+comment.user_id+'.jpg'" class="circle">--}}
                    {{--<span class="title"><a class="author" v-text="comment.user_name"></a></span>--}}
                    {{--<p><span v-text="comment.content"></span></p>--}}
                    {{--<small><a class="reply" v-on:click="doClickReply(comment.id, comment.user_name)">回复</a></small>--}}
                    {{--<a href="#!" class="secondary-content"><span class="date" v-text="comment.created_at"></span></a>--}}
                {{--</li>--}}
            {{--</ul>--}}

            {{--<form method="post" action="{{url('/article/save-comment')}}" class="reply">--}}
                {{--{{ csrf_field() }}--}}
                {{--<input type="hidden" name="article_id" value="{{$article->id}}" v-model="article_id">--}}
                {{--<input type="hidden" name="parent_id" value="0" v-model="parent_id"/>--}}
                {{--<div>--}}
                    {{--<div class="input-field">--}}
                        {{--<textarea id="textarea1" name="content" class="materialize-textarea" v-model="content">{{old('content')}}</textarea>--}}
                        {{--<label for="textarea1">发表评论</label>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<button class="btn waves-effect waves-light right" type="submit" name="action">提交</button>--}}
            {{--</form>--}}
        {{--</div>--}}
        {{--@endif--}}
    </div>
@endsection

@section('sidebar')
    <h5 class="header">
        @if(!empty($article->channel))
            更多{{$article->channel->channel_title}}
        @endif
    </h5>
    <div class="hollapsible">
        @foreach ($relatedArticles as $relatedArticle)
            <div class="title">
                {{$relatedArticle->title}}
            </div>
            <div class="items row valign-wrapper">
                <div class="col s3">
                    <a href="{{url('/p/'.$relatedArticle->id)}}">
                        <img src="{{empty($relatedArticle->cover)? '/assets/images/jtmds.png' : $relatedArticle->cover}}" class="responsive-img">
                    </a>
                </div>
                <div class="col s9">
                    <p class="text-ellipsis">
                        <a href="{{url('/p/'.$relatedArticle->id)}}">{{$relatedArticle->title}}</a>
                    </p>
                    {{--<div class="description">--}}
                    {{--<div class="text-ellipsis">{{ $article->excerpt }}</div>--}}
                    {{--</div>--}}
                    <div class="meta grey-text">
                        <small>阅读 {{$relatedArticle->view_count}}</small>
                        <small>评论 {{$relatedArticle->comment_count}}</small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div id="rightAds" class="pushpin-item" data-target="rightAds">
        <p></p>
        <script type="text/javascript">var jd_union_unid="1000010489",jd_ad_ids="514:6",jd_union_pid="CMvk/Mv7KhD55evcAxoAIO6bl+sBKgA=";var jd_width=300;var jd_height=300;var jd_union_euid="";var p="BxoFVRNYFAsVNwpfBkgyTUMIRmtKRk9aZV8ETVxNNwpfBkgyEH1dS0VoY0dnCBgMc3l1XSxiHnwEYgtZK14dABEGVhpYEzISBlQaWhUDFw5dK2tKRk9aZVA1FDJNQwhGaxUHFABWEl8dAxACVxxrFDIiNw%3D%3D";</script><script type="text/javascript" charset="utf-8" src="//u.x.jd.com/static/js/auto.js"></script>
    </div>
@endsection

@section('after-scripts-end')
{{--    <script type="text/javascript" src="{{asset('assets/js/vendor/jquery.qrcode.min.js')}}"></script>--}}
    {!! Html::script('js/vendor/jquery/jquery.qrcode.min.js') !!}
    {!! Html::script('js/frontend/article.js') !!}

    <script>
        $(document).ready(function () {
            $('.modal').modal();
//            $('.weixinQr').popup();
            $('#qrcode').qrcode("{{$article->url}}");
        });
    </script>

{{--<script type="text/javascript" >--}}
    {{--var jiathis_config={--}}
        {{--url:"{{$article->url}}",--}}
        {{--summary:"{{$article->excerpt}}",--}}
        {{--title:"{{$article->title}}#今天买点啥#",--}}
        {{--shortUrl:false,--}}
        {{--hideMore:false--}}
    {{--}--}}
{{--</script>--}}
{{--<script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>--}}


@endsection