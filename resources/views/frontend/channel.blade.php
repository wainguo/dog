@extends('frontend.layouts.two')

@section('after-styles-end')
    {!! Html::style('vendor/slick/slick.css') !!}
    {!! Html::style('vendor/slick/slick-theme.css') !!}
@endsection

@section('content')
    <div class="ui breadcrumb">
        <div class="section"> 当前位置：</div>
        <a class="section" href="{{url('')}}">首页</a>
        <i class="right angle icon divider"></i>
        <div class="section">{{$channel->channel_title or ''}}</div>
        <input type="hidden" id="channelId" value="{{$channel->id or 0}}">
    </div>

    <div class="ui divider"></div>

    <div id="jtmdsChannel" class="container">
        <div class="ui divided items">
            @foreach ($articles as $article)
                <div class="item">
                    <a class="image" href="{{ url('/p/'.$article->id) }}">
                        @if(isset($article->channel->channel_name))
                            <span class="mark mark-{{$article->channel->channel_name}}">{{$article->channel->channel_title}}</span>
                        @endif
                        <img src="{{empty($article->cover)? 'img/jtmds.png' : $article->cover}}" alt="{{ $article->title }}" style="vertical-align: middle">
                    </a>
                    <div class="content">
                        <a class="header" href="{{ url('/p/'.$article->id) }}">
                            {{ $article->title }}<span style="color:#d62222">{{ $article->description }}</span>
                        </a>
                        <div class="meta">
                            <small class="right floated">{{ $article->created_at }}</small>
                            <small>
                                推荐人： {{ $article->user_name }}
                            </small>
                            @if(count($article->tags) > 0)
                                <small>
                                    <span>标签：</span>
                                    @foreach ($article->tags as $tag)
                                        <a href="{{url('/tag/'.$tag->id)}}">{{$tag->tag_name}}</a>
                                    @endforeach
                                </small>
                            @endif
                        </div>
                        <div class="description text-ellipsis" style="min-height: 44px;">
                            <p>{{ $article->excerpt }}</p>
                        </div>
                        <div class="extra">
                            @if(isset($article->url))
                                <a href="{{$article->url}}" target="_blank" class="mini ui right floated red button">直达链接</a>
                            @endif
                            @if(isset($article->mall->mall_url))
                                <a href="{{$article->mall->mall_url}}"  class="ui orange label">{{$article->mall->mall_name}}</a>
                            @endif

                            <a href="{{url('/p/'.$article->id)}}"  class="ui label">阅读 {{$article->view_count}}</a>
                            <a href="{{url('/p/'.$article->id.'#comments')}}"  class="ui label">评论 {{$article->comment_count}}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{--广告位--}}
        <script type="text/javascript">var jd_union_unid="1000010489",jd_ad_ids="506:6",jd_union_pid="CNrE9Mv7KhD55evcAxoAINqelusBKgA=";var jd_width=760;var jd_height=90;var jd_union_euid="";var p="BxoFVRNfFAoUNwpfBkgyTUMIRmtKRk9aZV8ETVxNNwpfBkgyWQYLRxBqaUViAmUnTmdvdw1HGFFcYgtZK14dABEGVhpYEzISBlQaWhUDFw5dK2tKRk9aZVA1FDJNQwhGaxUHFABWEl8TBRsEXBlrFDIiNw%3D%3D";</script><script type="text/javascript" charset="utf-8" src="//u.x.jd.com/static/js/auto.js"></script>

        <div id="moreArticles" class="ui divided items" v-if="moreArticles.length" v-cloak>
            <div class="item" v-for="moreArticle in moreArticles">
                <a class="image" v-bind:href="'p/'+moreArticle.id">
                    <span class="mark"
                          v-bind:class="'mark-' + moreArticle.channel.channel_name"
                          v-text="moreArticle.channel.channel_title"
                          v-if="moreArticle.channel"></span>
                    <img v-bind:src="moreArticle.cover || '/assets/images/jtmds.png'" v-bind:alt="moreArticle.title">
                </a>
                <div class="content">
                    <a class="header" v-bind:href="'p/'+moreArticle.id">
                        <span v-text="moreArticle.title"></span>
                        <span style="color:#d62222" v-text="moreArticle.description"></span>
                    </a>
                    <div class="meta">
                        <small class="right floated" v-text="moreArticle.created_at"></small>
                        <small>
                            推荐人：<span v-text="moreArticle.user_name"></span>
                        </small>
                        <small v-if="moreArticle.tags.length > 0">
                            <span>标签：</span>
                            <a v-for="tag in moreArticle.tags" v-bind:href="'/tag/'+tag.id" v-text="tag.tag_name"></a>
                        </small>
                    </div>
                    <div class="description text-ellipsis" style="min-height: 44px;">
                        <p v-text="moreArticle.excerpt"></p>
                    </div>
                    <div class="extra">
                        <a v-bind:href="moreArticle.url" target="_blank" class="mini ui right floated red button">直达链接</a>
                        <a v-bind:href="moreArticle.mall.mall_url"  class="ui orange label" v-if="moreArticle.mall">
                            <span v-text="moreArticle.mall.mall_name"></span>
                        </a>

                        <a v-bind:href="'p/'+moreArticle.id" class="ui label">
                            阅读 <span v-text="moreArticle.view_count"></span>
                        </a>
                        <a v-bind:href="'p/'+moreArticle.id+'#comments'" class="ui label">
                            评论 <span v-text="moreArticle.comment_count"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('sidebar')
    {{--主题--}}
    <h3 class="ui header">
        今天快报
    </h3>

    <div class="ui divider"></div>
    <div class="ui collapse">
        @foreach ($popularArticles as $popularArticle)
            <div class="title">
                {{$popularArticle->title}}
            </div>
            <div class="ui items">
                <div class="item">
                    <a class="ui tiny bordered image" href="{{url('/p/'.$popularArticle->id)}}">
                        <img src="{{empty($popularArticle->cover)? '/assets/images/jtmds.png' : $popularArticle->cover}}">
                    </a>
                    <div class="content">
                        <p class="text-ellipsis">
                            <a href="{{url('/p/'.$popularArticle->id)}}">{{$popularArticle->title}}</a>
                        </p>
                        <div class="extra">
                            <small class="ui text">阅读 {{$popularArticle->view_count}}</small>
                            <small class="ui text">评论 {{$popularArticle->comment_count}}</small>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="ui fix top sticky">
        <div class="ui fix top sticky">
            {{--苏宁橱窗--}}
            <p></p>
            <div style="position: relative; display: inline; border: none; padding: 0px; margin: 0px; visibility: visible; overflow: hidden;">
                <script type="text/javascript">
                    var allyes_siteid='7569', allyes_output=1, allyes_channedid='8281',allyes_ad_width='330',allyes_ad_height='280',allyes_adspaceid='347-dXNlcklkPTE2MDE3Njk1JndlYlNpdGVJZD01MDM2OTkmYWRJbmZvSWQ9MCZhZEJvb2tJZD0xMDE4NTEmY2hhbm5lbD05OCZyPTE0NzcxMjA4ODAyNDg=', allyes_host_addr='mmae.qtmojo.com';
                </script>
                <script id="allyes_mm_ad_7569_8281_347-dXNlcklkPTE2MDE3Njk1JndlYlNpdGVJZD01MDM2OTkmYWRJbmZvSWQ9MCZhZEJvb2tJZD0xMDE4NTEmY2hhbm5lbD05OCZyPTE0NzcxMjA4ODAyNDg=" type="text/javascript" src="http://1.qtmojo.com/mediamax/MediaMax.js"></script>
            </div>
        </div>
    </div>
@endsection

@section('after-scripts-end')
    {!! Html::script('vendor/slick/slick.min.js') !!}
    {!! Html::script('js/frontend/channel.js') !!}
{{--    <script src="{{asset('assets/js/vendor/slick.min.js') }}"></script>--}}
{{--    <script src="{{asset('assets/js/home.js') }}"></script>--}}
    <script>
        //Being injected from FrontendController
//        console.log(test);
    </script>
@endsection