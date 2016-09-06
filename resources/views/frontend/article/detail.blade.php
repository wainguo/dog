@extends('frontend.layouts.two')

@section('content')
    <div id="jtmdsArticle" class="container">
        @if(session('toast_message'))
            <input type="hidden" id="success_message"
                   v-model="toast_message"
                   value="{{session('toast_message')}}">
        @endif

        <div class="ui breadcrumb">
            <div class="section"> 当前位置：</div>
            <a class="section" href="{{url('')}}">首页</a>
            @if(!empty($article->channel))
                <i class="right angle icon divider"></i>
                <a class="section" href="{{ url('/'.$article->channel->channel_name) }}">{{$article->channel->channel_title}}</a>
            @endif
            <i class="right angle icon divider"></i>
            <div class="section">文章详情</div>
        </div>

        <div class="ui items">
            <div class="item">
                <div class="image">
                    <img src="{{ empty($article->cover)? '/assets/images/jtmds.png' : $article->cover }}">
                </div>
                <div class="content">
                    <span class="header" href="{{ url('/article/'.$article->id) }}">
                        {{ $article->title }}<span style="color:#d62222;margin-left: 10px;">{{ $article->description }}</span>
                    </span>
                    <div class="meta">
                        <p>
                            <small>推荐人： {{ $article->user_name }}</small>
                            <small class="cinema">{{ $article->created_at }}</small>
                        </p>
                        @if(count($article->tags))
                        <p>
                            <small>
                                <span>标签：</span>
                                @foreach ($article->tags as $tag)
                                    <a href="#">{{$tag->tag_name}}</a>
                                @endforeach
                            </small>
                        </p>
                        @endif
                    </div>
                    <div class="description">
                        <p>{{ $article->excerpt }}</p>
                    </div>
                    <div class="extra">
                        @if(!Auth::guest() && $article->user_id == Auth::user()->id)
                            <a class="mini ui blue button" href="{{url('article/edit/'.$article->id)}}">编辑</a>
                        @endif
                        <button class="mini ui red right floated button">直达链接 <i class="chevron right icon"></i></button>
                        <button class="mini ui basic right floated button weixinQr" data-position="right center">
                            <i class="qrcode icon"></i>扫码购买</button>
                        <div class="ui flowing popup top left transition hidden">
                            <div class="ui image">
                                <div id="qrcode"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ui divider"></div>
        <div class="article content">
            {!! $article->content !!}
        </div>

        <div>
            <div class="ui horizontal right floated celled link list">
                <a class="item">
                    收藏
                </a>
                <a class="item">
                    分享
                </a>
                <a class="item">
                    缺货/变价/错误举报
                </a>
            </div>
            <small class="right aligned text">
                以上图片等引用来自互联网，仅供参考
            </small>
        </div>
        <div class="ui divider"></div>

        {{--<h4>你可能还喜欢</h4>--}}
        {{--<p>lskdjflkajdlkjsdlk</p>--}}

        @if($article->comment_status == 'open')
        <div id="comments" class="ui comments" v-cloak>
            <h3 class="ui header">评论</h3>

            <div class="comment" v-for="comment in comments">
                <a class="avatar">
                    <img v-bind:src="'/storage/avatar/'+comment.user_id+'.jpg'">
                </a>
                <div class="content">
                    <a class="author" v-text="comment.user_name"></a>
                    <div class="metadata">
                        <span class="date" v-text="comment.created_at"></span>
                    </div>
                    <div class="text">
                        <p><span v-text="comment.content"></span></p>
                    </div>
                    <div class="actions">
                        <a class="reply" v-on:click="doClickReply(comment.id, comment.user_name)">回复</a>
                    </div>
                </div>
                <div class="comments" v-if="comment.replies && comment.replies.length">
                    <div class="comment" v-for="reply in comment.replies">
                        <a class="avatar">
                            <img v-bind:src="'/storage/avatar/'+reply.user_id+'.jpg'">
                        </a>
                        <div class="content">
                            <a class="author" v-text="reply.user_name"></a>
                            <div class="metadata">
                                <span class="date" v-text="reply.created_at"></span>
                            </div>
                            <div class="text">
                                <p><span v-text="reply.content"></span></p>
                            </div>
                            <div class="actions">
                                <a class="reply" v-on:click="doClickReply(reply.parent_id, reply.user_name)">回复</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form method="post" action="{{url('/article/save-comment')}}" class="ui reply form">
                {{ csrf_field() }}
                <input type="hidden" name="article_id" value="{{$article->id}}" v-model="article_id">
                <input type="hidden" name="parent_id" value="0" v-model="parent_id"/>
                <div class="field">
                    <textarea name="content" rows="5" v-model="content">{{old('content')}}</textarea>
                </div>

                <button type="submit" class="ui red labeled submit icon mini button right floated">
                    <i class="icon edit"></i> 提交评论
                </button>
            </form>
        </div>
        @endif
    </div>
@endsection

@section('sidebar')
    <h3 class="ui dividing header">
        @if(!empty($article->channel))
            更多{{$article->channel->channel_title}}
        @endif
    </h3>
    <div class="ui collapse">
        @foreach ($relatedArticles as $relatedArticle)
            <div class="title">
                {{$relatedArticle->title}}
            </div>
            <div class="ui items content">
                <div class="item">
                    <a class="ui tiny bordered image" href="{{url('/p/'.$relatedArticle->id)}}">
                        <img src="{{empty($relatedArticle->cover)? '/assets/images/jtmds.png' : $relatedArticle->cover}}">
                    </a>
                    <div class="content">
                        <div class="description">
                            <a href="{{url('/p/'.$relatedArticle->id)}}">{{$relatedArticle->title}}</a>
                        </div>
                        <div class="extra">
                            <small class="ui right floated text">阅读 {{$relatedArticle->view_count}}</small>
                            <small class="ui right floated text">评论 {{$relatedArticle->comment_count}}</small>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('after-scripts-end')
{{--    <script type="text/javascript" src="{{asset('assets/js/vendor/jquery.qrcode.min.js')}}"></script>--}}
    {!! Html::script('js/vendor/jquery/jquery.qrcode.min.js') !!}
    {!! Html::script('js/frontend/article.js') !!}
    <script>
        $(document).ready(function () {
            $('.weixinQr').popup();
            $('#qrcode').qrcode("{{$article->url}}");
        });
    </script>
@endsection