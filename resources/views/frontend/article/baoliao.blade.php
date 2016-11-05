@extends('frontend.layouts.one')

@section('styles')
@endsection

@section('content')
    <div id="jtmdsArticle">
        @include('includes.partials.messages')
        <form action="{{ url('/article/save') }}" method="patch" class="ui mini form">
            {{ csrf_field() }}
            <input type="hidden" name="article_id" v-model="article_id" v-bind:value="{{ $article->id }}">
            <div class="ui stackable two column grid">
                <div class="baoliao eleven wide column" id="centerPanel">
                    <div class="required inline field">
                        <label>优惠链接</label>
                        <div class="ui mini input">
                            <input type="text" name="url" value="{{ $article->url or ''}}" placeholder="优惠链接">
                        </div>
                        <button type="button" id="fetchInfo" class="ui secondary mini submit button"> 获取信息</button>
                    </div>
                    <div class="ui divider"></div>

                    <div class="required inline field">
                        <label>商品名称</label>
                        <div class="ui mini input">
                            <input type="text" name="title" placeholder="输入文章标题" value="{{ $article->title or ''}}">
                        </div>
                    </div>
                    <div class="required inline field">
                        <label>价格描述</label>
                        <div class="ui mini input">
                            <input type="text" name="description" placeholder="输入价格描述" value="{{ $article->description or ''}}">
                        </div>
                    </div>

                    {{--<div class="required inline field">--}}
                        {{--<label>商品分类</label>--}}
                        {{--<div class="ui mini input">--}}

                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="inline two fields">--}}
                        {{--<div class="six wide inline field">--}}
                            {{--<label>价格描述</label>--}}
                            {{--<input type="text" name="description" placeholder="价格描述" value="{{ $article->description or ''}}">--}}
                        {{--</div>--}}
                        {{--<div class="ten wide inline field">--}}
                            {{--<label>直达链接</label>--}}
                            {{--<input type="text" name="url" placeholder="直达链接" value="{{ $article->url or ''}}">--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    <div class="required field">
                        <label>推荐理由</label>
                        <textarea name="content" id="editor1" rows="30" cols="80">
                         {{ $article->content or ''}}
                        </textarea>
                    </div>

                    {{--<div class="required inline field">--}}
                        {{--<div class="ui checkbox">--}}
                            {{--<input type="checkbox" tabindex="0" class="hidden">--}}
                            {{--<label>I agree to the terms and conditions</label>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>

                <div class="five wide column ui rail" id="rightPanel">
                    <div class="field">
                        <button type="submit" class="fluid ui submit orange button">发布</button>
                    </div>
                    <div class="ui segments">
                        <div class="ui yellow segment">
                            <div class="inline fields">
                                <label for="fruit">形式:</label>
                                <div class="field">
                                    <div class="ui radio checkbox">
                                        <input type="radio" name="type" tabindex="0" class="hidden" value="product" {{("product" == $article->type)?'checked':''}}>
                                        <label>商品</label>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="ui radio checkbox">
                                        <input type="radio" name="type" tabindex="0" class="hidden" value="article" {{("article" == $article->type)?'checked':''}}>
                                        <label>文章</label>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="ui radio checkbox">
                                        <input type="radio" name="type" tabindex="0" class="hidden" value="activity" {{("activity" == $article->type)?'checked':''}}>
                                        <label>活动</label>
                                    </div>
                                </div>
                            </div>
                            <div class="two fields">
                                <div class="eight wide inline field">
                                    <label>频道:</label>
                                    <select class="ui search dropdown" name="channel_id">
                                        <option value="">选择频道</option>
                                        @foreach($channels as $channel)
                                            <option value="{{$channel->id}}" {{ ($channel->id == $article->channel_id)? 'selected': ''}}>{{$channel->channel_title}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="eight wide inline field">
                                    <label>商城:</label>
                                    <select class="ui search dropdown" name="mall_id" value="{{$article->mall_id}}">
                                        <option value="">选择商城</option>
                                        @foreach($malls as $mall)
                                            <option value="{{$mall->id}}" {{ ($mall->id == $article->mall_id)? 'selected': ''}}>{{$mall->mall_name}}</option>
                                        @endforeach$
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="ui yellow segment">
                            <div class="field">
                                <label>分类目录</label>
                                <div id="checkCategories" class="ui list">
                                    <div class="item">
                                        {{--根分类--}}
                                        <template v-for="category in categories">
                                            <div class="ui master checkbox">
                                                <input type="checkbox" name="categories[]" v-bind:value="category.id" v-model="article_category_ids">
                                                <label v-text="category.category_name"></label>
                                            </div>
                                            {{--子分类--}}
                                            <div class="list" v-if="category.children.length > 0">
                                                <div class="item" v-for="child in category.children">
                                                    <div class="ui child checkbox">
                                                        <input type="checkbox" name="categories[]" v-bind:value="child.id" v-model="article_category_ids">
                                                        <label v-text="child.category_name"></label>
                                                    </div>
                                                    {{--叶子分类--}}
                                                    <div class="list" v-if="child.children.length > 0">
                                                        <div class="item" v-for="grandson in child.children">
                                                            <div class="ui child checkbox">
                                                                <input type="checkbox" name="categories[]" v-bind:value="grandson.id" v-model="article_category_ids">
                                                                <label v-text="grandson.category_name"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div class="field">
                                <a v-on:click="showAddCategoryModal">添加新分类目录</a>
                            </div>
                        </div>

                        <div class="ui yellow segment">
                            <div class="field">
                                <label>标签</label>
                                <div class="ui mini action input">
                                    <input type="text" placeholder="输入标签" v-model="tag_names">
                                    <button type="button" class="ui orange right button" v-on:click="addTags">
                                        添加
                                    </button>
                                </div>
                                <small>多个标签请用英文逗号（,）分开</small>
                            </div>

                            <div class="ui labels">
                                <div class="ui label" v-for="tag in article_tags">
                                    <input type="hidden" name="tag_ids[]" v-bind:value="tag.id">
                                    <span v-text="tag.tag_name"></span>
                                    <i class="delete icon" v-on:click="deleteArticleTag(tag)"></i>
                                </div>
                            </div>

                            <div class="ui accordion field">
                                <a class="title">从常用标签中选择</a>
                                <div class="content field">
                                    <div class="ui horizontal list">
                                        @foreach($tags as $tag)
                                            <a class="item" v-on:click="selectTag({{$tag}})">{{$tag->tag_name}}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        {{--添加新的分类目录--}}
        <div id="addCategoryModal" class="ui small modal">
            {{--<i class="close icon"></i>--}}
            <div class="header">
                添加新分类目录
            </div>
            <div class="content">
                <div class="ui form">
                    <div class="field">
                        <input type="hidden" class="ui mini input" placeholder="分类目录名" v-model="csrfToken" value="{{csrf_token()}}">
                        <input type="text" class="ui mini input" placeholder="分类目录名" v-model="category_name">
                    </div>
                    <div class="field">
                        <select class="ui dropdown" v-model="category_parent">
                            <option value="0">— 父级分类目录 —</option>
                            <template v-for="category in categories">
                                <option v-bind:value="category.id" v-bind:value="category.id" v-text="category.category_name"></option>
                                <option v-for="child in category.children" v-bind:value="child.id" v-text="'&nbsp;&nbsp;&nbsp;'+child.category_name"></option>
                            </template>
                        </select>
                    </div>
                    <button type="button" class="mini ui orange button" v-on:click="addCategory">添加新分类目录</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after-scripts-end')
    {!! Html::script('vendor/ckeditor/ckeditor.js') !!}
    {!! Html::script('js/frontend/edit-article.js') !!}
@endsection