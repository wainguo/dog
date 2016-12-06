@extends ('backend.layouts.master')

@section ('title', trans('labels.backend.article.management') . ' | ' . trans('labels.backend.article.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.article.management') }}
        <small>{{ trans('labels.backend.article.create') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::open(['route' => 'admin.article.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-article']) }}
        <div id="jtmdsArticle" class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.article.create') }}</h3>
            </div>

            <div class="box-body">
                <div class="form-group">
                    {{ Form::label('title', trans('validation.attributes.backend.article.title'), ['class' => 'col-lg-1 control-label']) }}

                    <div class="col-lg-6">
                        {{ Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.article.title')]) }}
                    </div>
                    <div class="col-lg-4">
                        {{ Form::text('subtitle', old('subtitle'), ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.article.subtitle')]) }}
                    </div>
                </div>



                <div class="form-group">
                    {{ Form::label('url', trans('validation.attributes.backend.article.url'), ['class' => 'col-lg-1 control-label']) }}

                    <div class="col-lg-10">
                        {{ Form::text('url', old('url'), ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.article.url')]) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('url', trans('validation.attributes.backend.article.channel'), ['class' => 'col-lg-1 control-label']) }}

                    <div class="col-lg-10">
{{--                        {{ Form::text('channel_id', old('channel_id'), ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.article.url')]) }}--}}
{{--                        {{ Form::select('channel_id', $channels, old('channel_id'), ['class' => 'form-control']) }}--}}
                        <select class="form-control" name="channel_id">
                            <option value="">选择频道</option>
                            @foreach($channels as $channel)
                                <option value="{{$channel->id}}" {{ (old('channel_id'))? 'selected': ''}}>{{$channel->channel_title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('content', trans('validation.attributes.backend.article.content'), ['class' => 'col-lg-1 control-label']) }}
                    <div class="col-lg-10">
                        <textarea name="content" id="editor1" rows="3" cols="80">{{ old("content")}}</textarea>
                    </div>
                </div>
                {{--<div class="form-group">--}}
                    {{--{{ Form::label('category', trans('validation.attributes.backend.article.category'), ['class' => 'col-lg-1 control-label']) }}--}}
                    {{--<div id="checkCategories" class="col-lg-10">--}}
                        {{--根分类--}}
                        {{--<template v-for="category in categories">--}}
                            {{--<div class="ui master checkbox">--}}
                                {{--<input type="checkbox" name="categories[]" v-bind:value="category.id" v-model="article_category_ids">--}}
                                {{--<label v-text="category.category_name"></label>--}}
                            {{--</div>--}}
                            {{--子分类--}}
                            {{--<div class="list" v-if="category.children.length > 0">--}}
                                {{--<div class="item" v-for="child in category.children">--}}
                                    {{--<div class="ui child checkbox">--}}
                                        {{--<input type="checkbox" name="categories[]" v-bind:value="child.id" v-model="article_category_ids">--}}
                                        {{--<label v-text="child.category_name"></label>--}}
                                    {{--</div>--}}
                                    {{--叶子分类--}}
                                    {{--<div class="list" v-if="child.children.length > 0">--}}
                                        {{--<div class="item" v-for="grandson in child.children">--}}
                                            {{--<div class="ui child checkbox">--}}
                                                {{--<input type="checkbox" name="categories[]" v-bind:value="grandson.id" v-model="article_category_ids">--}}
                                                {{--<label v-text="grandson.category_name"></label>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</template>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="form-group">
                    {{ Form::label('tag', trans('validation.attributes.backend.article.tag'), ['class' => 'col-lg-1 control-label']) }}
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <input type="hidden" id="csrfToken" v-model="csrfToken" value="{{csrf_token()}}">
                                    <input type="text" class="form-control" placeholder="输入标签" v-model="tag_names">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button" v-on:click="addTags">添加</button>
                                    </span>
                                </div>
                                <small>多个标签请用英文逗号（,）分开</small>
                            </div>

                            <div class="col-lg-10" style="margin-top: 10px">
                                <span class="label label-warning" style="margin-right: 5px;"
                                      v-for="tag in article_tags">
                                    <input type="hidden" name="tag_ids[]" v-bind:value="tag.id">
                                    <span v-text="tag.tag_name"></span>
                                    <i class="glyphicon glyphicon-remove" v-on:click="deleteArticleTag(tag)"></i>
                                </span>
                            </div>

                            <div class="col-lg-10">
                                <a style="color: #888" data-toggle="collapse"
                                   role="button"
                                   data-target="#collapseTags"
                                   aria-expanded="false"
                                   aria-controls="collapseTags">从常用标签中选择</a>
                                <div class="collapse" id="collapseTags">
                                    @foreach($tags as $tag)
                                        <a href="#;" v-on:click="selectTag({{$tag}})">{{$tag->tag_name}}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--box-->

        <div class="box box-success">
            <div class="box-body">
                <div class="pull-left">
                    {{ link_to_route('admin.article.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-sm']) }}
                </div>

                <div class="pull-right">
                    {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-success btn-sm']) }}
                </div>

                <div class="clearfix"></div>
            </div>
        </div>
    {{ Form::close() }}
@endsection

@section('after-scripts-end')
    {{ Html::script('vendor/ckeditor/ckeditor.js') }}
    {{ Html::script('js/vendor/vue/vue.min.js') }}
    {{ Html::script('js/vendor/vue/vue-resource.min.js') }}
    {{ Html::script('js/backend/article.create.js') }}

    <script>
        CKEDITOR.replace( 'editor1', {
            language: 'zh-cn',
            filebrowserImageUploadUrl: '{{url('admin/upload-ckimage/')}}?_token={{csrf_token()}}',
            toolbarGroups: [
            { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
            { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
            { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
            { name: 'links', groups: [ 'links' ] },
            { name: 'insert', groups: [ 'insert' ] },
            { name: 'forms', groups: [ 'forms' ] },
            { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
            { name: 'others', groups: [ 'others' ] },
            { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
            { name: 'styles', groups: [ 'styles' ] },
            { name: 'tools', groups: [ 'tools' ] },
            { name: 'colors', groups: [ 'colors' ] },
            { name: 'about', groups: [ 'about' ] }
            ],
            removeButtons: 'Subscript,Superscript,About,Source,Cut,Undo,Copy,Redo,Paste,PasteText,PasteFromWord,Scayt,Anchor,SpecialChar,RemoveFormat',
            height: 200,
            extraPlugins: 'autogrow',
            autoGrow_minHeight: 200,
            on: {
//                 instanceReady: function() {
//                     //SHOW TEXT AREA FOR DEV PURPOSES
//                     this.element.show();
//                 },
                change: function() {
                    // Sync textarea.
                     this.updateElement();
//                    self.article.mainBody = this.getData();
                }
            }
        } );

    </script>
@endsection