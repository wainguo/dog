@extends('frontend.layouts.one')

@section('content')
    <div class="breadcrumb">
        <span class="section"> 当前位置：</span>
        <a class="section" href="{{url('')}}">首页</a>
        <span>#</span>
        <span class="section">{{ trans('labels.frontend.auth.register_box_title') }}</span>
    </div>
    <div class="container">
        {{--<div class="divider"></div>--}}

        @include('includes.partials.messages')
        <div class="row">
            <div class="col s6">
                {{--<h2 style="margin-top: 50px;">--}}
                    {{--<div class="content">--}}
                        {{--{{ trans('labels.frontend.auth.register_box_title') }}--}}
                    {{--</div>--}}
                {{--</h2>--}}
                {{--<form class="ui large form" method="POST" action="{{ url('/register') }}">--}}
                {{ Form::open(['route' => 'frontend.auth.register', 'class' => 'form']) }}
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="name" name="name" type="text" class="validate" value="{{old('name')}}">
                            <label for="email">{{trans('validation.attributes.frontend.name')}}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="email" name="email" type="email" class="validate" value="{{old('email')}}">
                            <label for="email">{{trans('validation.attributes.frontend.email')}}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="password" name="password" type="password" class="validate">
                            {{--<label for="password">登录密码</label>--}}
                            <label for="password">{{trans('validation.attributes.frontend.password')}}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="password_confirmation" name="password_confirmation" type="password" class="validate">
                            {{--<label for="password">登录密码</label>--}}
                            <label for="password_confirmation">{{trans('validation.attributes.frontend.password_confirmation')}}</label>
                        </div>
                    </div>

                    {{--@if (config('access.captcha.registration'))--}}
                        {{--<div class="field">--}}
                            {{--<div class="">--}}
                                {{--{!! Form::captcha() !!}--}}
                                {{--{{ Form::hidden('captcha_status', 'true') }}--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--@endif--}}
                    <div class="row">
                        <div class="col s8">
                            <input type="checkbox" name="remember" tabindex="0" class="filled-in" checked="checked">
                            <label>同意<a href="{{url('/terms')}}" target="_blank">“今天买点啥用户使用协议”</a></label>
                        </div>
                        <div class="col s4">
                            <button class="btn btn-small red waves-effect waves-light" type="submit" name="action">
                                {{trans('labels.frontend.auth.register_button')}}
                            </button>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection

@section('after-scripts-end')
    {{--@if (config('access.captcha.registration'))--}}
        {{--{!! Captcha::script() !!}--}}
    {{--@endif--}}
    <script>
        $(document).ready(function () {
            $('.ui.checkbox').checkbox();
        });
    </script>
@stop