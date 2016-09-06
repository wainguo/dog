@extends('layouts.app')

@section('content')
    @parent

    <div class="container">
        <div class="ui divided items">
            @foreach ($articles as $article)
                <div class="item">
                    <div class="image">
                        <img src="{{ url($article->cover) }}" alt="{{ $article->title }}">
                    </div>
                    <div class="content">
                        <a class="header" href="{{ url('/p/'.$article->id) }}">
                            {{ $article->title }}<span style="color:#d62222">{{ $article->description }}</span>
                        </a>
                        <div class="meta">
                            <span class="right floated">{{ $article->created_at }}</span>
                            <small>
                                推荐人： {{ $article->author }}
                                <span>标签：</span>
                                <a href="http://www.smzdm.com/fenlei/nankuanguangdongnengwanbiao/">男款光动能腕表</a>
                                <a href="http://www.smzdm.com/tag/%E9%80%81%E7%A4%BC%E5%93%81/haitao/">送礼品</a>
                            </small>
                        </div>
                        <div class="description">
                            <p>{{ $article->content }}</p>
                        </div>
                        <div class="extra">
                            <button class="mini ui button"><i class="heart icon"></i> 值 </button>
                            <button class="mini ui button"><i class="fork icon"></i> 不值 </button>

                            <button class="mini ui right floated red button">直达链接</button>
                            <a href="http://www.smzdm.com/mall/amazon/haitao/" class="right floated">美国亚马逊</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div>
            <p>{{ $category->cat_name }}</p>
            @foreach ($category->articles as $article)
                <p>{{ $article->title }}</p>
            @endforeach
        </div>

        <div>
            <p>{{ $user->name }}</p>
            @foreach ($user->articles as $article)
                <p>{{ $article->title }}</p>
            @endforeach
        </div>
    </div>

    {{--{{ $articles->links() }}--}}
    @include('common.pagination', ['paginator' => $articles])

@endsection
