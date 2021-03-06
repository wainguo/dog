@extends('frontend.layouts.two')

@section('after-styles-end')
    {!! Html::style('vendor/slick/slick.css') !!}
    {!! Html::style('vendor/slick/slick-theme.css') !!}
    {{--<link href="{{asset('assets/css/slick.css') }}" rel="stylesheet">--}}
    {{--<link href="{{asset('assets/css/slick-theme.css') }}" rel="stylesheet">--}}
@endsection

@section('content')
    <div class="row" id="mainSlide">
        <div class="col s9">
            <div class="single-item">
                @foreach($homeslideArticles as $homeslideArticle)
                    <div>
                        <a href="{{ $homeslideArticle->url }}" target="_blank">
                            <img src="{{ $homeslideArticle->cover }}" alt="{{ $homeslideArticle->title }}">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col s3" id="showcase">
            @foreach($showcaseArticles as $showcaseArticle)
                <a href="{{ $showcaseArticle->url }}" target="_blank">
                    <img src="{{ url($showcaseArticle->cover) }}" alt="{{ $showcaseArticle->title }}">
                </a>
            @endforeach
        </div>
    </div>

    <div id="articleList" class="row">
        <div class="col s12">
            @foreach ($articles as $article)
                <div class="mediabox lighten-5">
                    @if(isset($article->channel->channel_name))
                        <span class="mark mark-{{$article->channel->channel_name}}">{{$article->channel->channel_title}}</span>
                    @endif
                    <div class="row valign-wrapper">
                        <div class="col s3">
                            <a href="{{ url('/p/'.$article->id) }}">
                                <img src="{{empty($article->cover)? '/img/jtmds.png' : $article->cover}}" alt="{{ $article->title }}" class="responsive-img">
                            </a>
                        </div>
                        <div class="col s9">
                            <h5 class="header">
                                <a href="{{ url('/p/'.$article->id) }}">{{ $article->title }}<span style="color:#d62222">{{ $article->subtitle }}</span></a>
                            </h5>
                            <div class="meta grey-text">
                                <small class="right">{{ $article->created_at }}</small>
                                @if(count($article->tags) > 0)
                                    <small>
                                        <span>标签：</span>
                                        @foreach ($article->tags as $tag)
                                            <span>{{$tag->tag_name}}</span>
                                        @endforeach
                                    </small>
                                @endif
                            </div>
                            <div class="description">
                                <div class="text-ellipsis">{{ $article->excerpt }}</div>
                            </div>
                            <div class="meta">
                                @if(isset($article->url))
                                    <a href="{{$article->url}}" target="_blank" class="btn btn-small red lighten-1 right">直达链接</a>
                                @endif

                                {{--<small>推荐人： {{ $article->user_name }}</small>--}}
                                @if(isset($article->mall->mall_url))
                                    <a href="{{$article->mall->mall_url}}"  class="ui orange label">{{$article->mall->mall_name}}</a>
                                @endif
                                <small>
                                    <a href="{{url('/p/'.$article->id)}}"  class="grey-text">阅读 {{$article->view_count}}</a>
{{--                                    <a href="{{url('/p/'.$article->id.'#comments')}}"  class="grey-text">评论 {{$article->comment_count}}</a>--}}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div style="width:720px;">
                <div style="overflow: hidden;margin-left: -20px;">
                    <script type="text/javascript">var jd_union_unid="1000010489",jd_ad_ids="507:6",jd_union_pid="CPjxgOyFKxD55evcAxoAILHlvP4BKgA=";var jd_width=720;var jd_height=90;var jd_union_euid="";var p="BxoFVRNfFAoUNwpfBkgyTUMIRmtKRk9aZV8ETVxNNwpfBkgyQXcUbzp1R0hnBxwYXnZnehN%2FJEVXYgtZK14dABEGVhpYEzISBlQaWhUDFw5dK2tKRk9aZVA1FDJNQwhGaxUHFA9UGV0QABcHVB5rFDIiNw%3D%3D";</script><script type="text/javascript" charset="utf-8" src="//u.x.jd.com/static/js/auto.js"></script>
                </div>
            </div>
        </div>
        <div class="col s12">
        <div id="moreArticles" v-if="moreArticles.length" v-cloak>
            <div class="mediabox lighten-5" v-for="moreArticle in moreArticles">
                <span class="mark"
                      v-bind:class="'mark-' + moreArticle.channel.channel_name"
                      v-text="moreArticle.channel.channel_title"
                      v-if="moreArticle.channel"></span>
                <div class="row valign-wrapper">
                    <div class="col s3">
                        <a v-bind:href="'p/'+moreArticle.id">
                            <img v-bind:src="moreArticle.cover || '/img/jtmds.png'" v-bind:alt="moreArticle.title" class="responsive-img">
                        </a>
                    </div>
                    <div class="col s9">
                        <h5 class="header">
                            <a v-bind:href="'p/'+moreArticle.id">
                                <span v-text="moreArticle.title"></span>
                                <span style="color:#d62222" v-text="moreArticle.subtitle"></span>
                            </a>
                        </h5>
                        <div class="meta grey-text">
                            <small class="right" v-text="moreArticle.created_at"></small>
                            <small v-if="moreArticle.tags.length > 0">
                                <span>标签：</span>
                                {{--<a v-for="tag in moreArticle.tags" v-bind:href="'/tag/'+tag.id" v-text="tag.tag_name"></a>--}}
                                <span v-for="tag in moreArticle.tags" v-text="tag.tag_name"></span>
                            </small>
                        </div>
                        <div class="description">
                            <div class="text-ellipsis" v-text="moreArticle.excerpt"></div>
                        </div>
                        <div class="meta">
                            <a v-bind:href="moreArticle.url" target="_blank" class="btn btn-small red lighten-1 right">直达链接</a>
                            {{--<small>推荐人： {{ $article->user_name }}</small>--}}
                            <a v-bind:href="moreArticle.mall.mall_url" v-if="moreArticle.mall">
                                <span v-text="moreArticle.mall.mall_name"></span>
                            </a>
                            <small>
                                <a v-bind:href="'p/'+moreArticle.id" class="grey-text">
                                    阅读 <span v-text="moreArticle.view_count"></span>
                                </a>
                                {{--<a v-bind:href="'p/'+moreArticle.id+'#comments'" class="grey-text">--}}
                                    {{--评论 <span v-text="moreArticle.comment_count"></span>--}}
                                {{--</a>--}}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="col s12 m12 center">
            <div class="center preloader-wrapper small" v-bind:class="{'active':moreArticleIsLoading}">
                <div class="spinner-layer spinner-red-only">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                        <div class="circle"></div>
                    </div><div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('sidebar')
    <h5 class="header">
         推荐
    </h5>
    <div class="hollapsible">
        @foreach ($featuredArticles as $featuredArticle)
            <div class="title">
                {{$featuredArticle->title}}
            </div>
            <div class="items row valign-wrapper">
                <div class="col s3">
                    <a href="{{url('/p/'.$featuredArticle->id)}}">
                        <img src="{{empty($featuredArticle->cover)? '/assets/images/jtmds.png' : $featuredArticle->cover}}" class="responsive-img">
                    </a>
                </div>
                <div class="col s9">
                    <p class="text-ellipsis">
                        <a href="{{url('/p/'.$featuredArticle->id)}}">{{$featuredArticle->title}}</a>
                    </p>
                    <div class="meta grey-text">
                        <small>阅读 {{$featuredArticle->view_count}}</small>
{{--                        <small>评论 {{$featuredArticle->comment_count}}</small>--}}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div style="margin-top: 15px; margin-bottom: -50px;">
        <script type="text/javascript">var jd_union_pid="563857683";var jd_union_euid="";</script><script type="text/javascript" src="http://ads.union.jd.com/static/js/union.js"></script>
    </div>

    <div class="pushpin-item" data-target="articleList">
        {{--<p></p>--}}
        <script type="text/javascript">var jd_union_unid="1000010489",jd_ad_ids="512:6",jd_union_pid="CNaprMv7KhD55evcAxoAIOmbl+sBKgA=";var jd_width=336;var jd_height=280;var jd_union_euid="";var p="BxoFVhtbFQIRNwpfBkgyTUMIRmtKRk9aZV8ETVxNNwpfBkgyWlUvYwNCZBBiAxwLd3UUbyJlCVFqRAtZK14dABEGVhpYEzISBlQaWhUDFw5dK2tKRk9aZVA1FDJNQwhGaxUHFABWEl4RCxYHUx5rFDIiNw%3D%3D";</script><script type="text/javascript" charset="utf-8" src="//u.x.jd.com/static/js/auto.js"></script>
    </div>

@endsection

@section('after-scripts-end')
    {!! Html::script('vendor/slick/slick.min.js') !!}
    {!! Html::script('js/frontend/index.js') !!}
@stop