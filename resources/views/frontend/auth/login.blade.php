@extends('frontend.layouts.one')

@section('content')
    <div class="breadcrumb">
        <span class="section"> 当前位置：</span>
        <a class="section" href="{{url('')}}">首页</a>
        <span>#</span>
        <span class="section">{{ trans('labels.frontend.auth.login_box_title') }}</span>
    </div>
    <div class="container">
        @include('includes.partials.messages')
        <div class="row">
            <div class="col s6">
                {{--<h2 style="margin-top: 50px;">--}}
                    {{--<div class="content">--}}
                        {{--{{ trans('labels.frontend.auth.login_box_title') }}--}}
                    {{--</div>--}}
                {{--</h2>--}}
                {{ Form::open(['route' => 'frontend.auth.login', 'class' => 'form']) }}
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="email" name="email" type="email" class="validate" value="{{old('email')}}">
                            <label for="email">Email</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="password" name="password" type="password" class="validate">
                            {{--<label for="password">登录密码</label>--}}
                            <label for="password">登录密码</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s6">
                            <input type="checkbox" name="remember" class="filled-in" id="remember" checked="checked" />
                            <label for="filled-in-box">{{ trans('labels.frontend.auth.remember_me') }}</label>
                        </div>

                        <div class="col s6">
                            <button class="btn btn-small red waves-effect waves-light" type="submit" name="action">
                                {{trans('labels.frontend.auth.login_button')}}
                            </button>
                        </div>

                    </div>
                {{ Form::close() }}
            </div>
            <div class="col offset-s1 s5">
                <div class="row" style="margin-top: 70px;">
                    <div class="col s12">
                        {!! $socialite_links !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        {{ link_to_route('frontend.auth.password.reset', trans('labels.frontend.passwords.forgot_password')) }}
                        还没有账号? <a href="{{ url('/register') }}">立即注册</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after-scripts-end')
    {{--@if (isset($captcha) && $captcha)--}}
        {{--{!! Captcha::script() !!}--}}
    {{--@endif--}}
    <script>
        $(document).ready(function () {
            $('.ui.checkbox').checkbox();
        });
    </script>
@endsection