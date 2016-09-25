@extends('frontend.layouts.two')

@section('content')
    <div class="container">
        <div class="ui breadcrumb">
            <div class="section"> 当前位置：</div>
            <a class="section" href="{{url('')}}">首页</a>
            <i class="right angle icon divider"></i>
            <div class="section">{{ trans('navs.frontend.dashboard') }}</div>
        </div>

        {{--<div class="ui red segment">--}}
        <div class="ui basic segment">
            <div class="ui two column grid">
                <div class="four wide column center aligned">
                    <div class="blurring dimmable image">
                        <div class="ui inverted dimmer">
                            <div class="content">
                                <div class="center">
                                    <a href="{{url('/profile/avatar')}}" class="ui mini orange button">更换头像</a>
                                </div>
                            </div>
                        </div>
                        <img class="ui small image" src="{{ $user->picture }}">
                    </div>
                </div>
                <div class="twelve wide column">
                    <div class="ui items">
                        <div class="item">
                            <div class="content">
                                <a href="{{route('frontend.user.profile.edit')}}" class="ui red right corner label">
                                    <i class="edit icon"></i>
                                </a>
                                <div class="header">{{$user->name}}</div>
                                <div class="description">
                                    <div class="ui tiny four statistics">
                                        <div class="red statistic">
                                            <div class="value">
                                                {{$user->profile->coin_count or 0}}
                                            </div>
                                            <div class="label">
                                                <i class="ticket icon"></i>积分
                                            </div>
                                        </div>
                                        <div class="red statistic">
                                            <div class="value">
                                                {{$user->profile->article_count or 0}}
                                            </div>
                                            <div class="label">
                                                <i class="newspaper icon"></i>文章
                                            </div>
                                        </div>
                                        <div class="red statistic">
                                            <div class="value">
                                                {{$user->profile->favor_count or 0}}
                                            </div>
                                            <div class="label">
                                                <i class="star icon"></i>收藏
                                            </div>
                                        </div>
                                        <div class="red statistic">
                                            <div class="value">
                                                {{$user->profile->comment_count or 0}}
                                            </div>
                                            <div class="label">
                                                <i class="comment outline icon"></i>评论
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ui divider"></div>
                                <div class="meta">
                                    <small class="right floated">
                                        {{ trans('labels.frontend.user.profile.created_at') }}
                                        {{ $user->created_at }} ({{ $user->created_at->diffForHumans() }})
                                    </small>
                                    {{ trans('labels.frontend.user.profile.email') }}: {{ $user->email }}
                                </div>
                                <div class="ui divider"></div>
                                <div class="extra">
                                    <p>
                                        {{empty($user->profile->profile_introduction) ? '您还没有设置个人简介，去设置吧。': $user->profile->profile_introduction}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <p>
            {{ trans('labels.frontend.user.profile.last_updated') }}
            {{ $user->updated_at }} ({{ $user->updated_at->diffForHumans() }})
            </p>
        </div>

        <h3 class="ui dividing header">
            文章列表
        </h3>
        {{--article list--}}
        <div class="ui feed" v-cloak>
            <div class="event" v-for="article in articles">
                <div class="label">
                    <img src="{{ $user->picture }}">
                </div>
                <div class="content">
                    <div class="summary">
                        <a class="header" v-bind:href="'/p/'+article.id">
                            <span v-text="article.title"></span>
                        </a>
                        <div class="date">
                            <span v-text="moreArticle.created_at"></span>
                        </div>
                    </div>
                    <div class="extra images">
                        {{--<a><img v-bind:src="article.cover || '/assets/images/jtmds.png'" v-bind:alt="article.title"></a>--}}
                        <a><img v-bind:src="article.cover || '/assets/images/jtmds.png'" v-bind:alt="article.title"></a>
                        {{--<a><img src="../images/wireframe/image.png"></a>--}}
                        <div class="extra text" style="display: inline-block; margin-left:.25em;">
                            <span v-text="article.excerpt"></span>
                        </div>
                    </div>
                    <div class="meta">
                        <a class="like">
                            <i class="like icon"></i> <span v-text="article.view_count"></span> 人次阅读
                        </a>
                        <a class="like">
                            <i class="comment icon"></i> <span v-text="article.comment_count"></span> 条评论
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <pagination :pagination="pagination" :callback="loadArticles" :offset="3"></pagination>
    </div>
@endsection

{{--@section('sidebar')--}}
{{--@endsection--}}

@section('after-scripts-end')
    <script src="{{asset('assets/js/libs/vue-pagination.js') }}"></script>
    <script>
        var vm = new Vue({
            el: '#jtmdsBody',
            data: {
                articles: [],
                pagination: {
                    total: 0,
                    per_page: 10,    // required
                    current_page: 1, // required
                    last_page: 0,    // required
                    from: 1,
                    to: 10           // required
                }
            },
            ready: function() {
                var self = this;

                $('.dimmable.image').dimmer({
                    on: 'hover'
                });
                this.loadArticles();
            },

            methods: {
                loadArticles: function() {
                    var self = this;
                    var params = {
                        params: {
                            paginate: this.pagination.per_page,
                            page: this.pagination.current_page,
                            /* additional parameters */
                            user_id: this.user_id
                        }
                    };
                    this.$http.get('/api/get/more-articles', params).then(
                            function(response) {
                                var jtmdsResponse = response.data;
                                if(jtmdsResponse.errorCode == 0) {
                                    var pagedArticles = jtmdsResponse.content;
//                            this.$set('lastPage', pagedArticles.last_page);
//                            this.$set('currentPage', pagedArticles.current_page);
                                    this.pagination.current_page = pagedArticles.current_page;
                                    this.pagination.last_page = pagedArticles.last_page;
                                    this.pagination.from = pagedArticles.from;
                                    this.pagination.to = pagedArticles.to;
                                    this.pagination.total = pagedArticles.total;
                                    if(Array.isArray(pagedArticles.data)){
                                        this.$set('articles', pagedArticles.data);
//                                    pagedArticles.data.forEach(function(obj){
//                                        self.moreArticles.push(obj);
//                                    });
                                    }
                                }
                            },
                            function(response) {
                                console.log(response);
                            }
                    )
                }
            },
//        components: {
//            pagination: require('vue-pagination')
//        }
        });
    </script>
@endsection