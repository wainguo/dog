@extends('frontend.layouts.one')

@section('content')
    <div class="container">
        <div class="ui middle aligned center aligned stackable grid">
            <div class="six wide column">
                <h2 class="ui header" style="margin-top: 50px;">
                    <div class="content">
                        {{ trans('labels.frontend.auth.register_box_title') }}
                    </div>
                </h2>
                {{--<form class="ui large form" method="POST" action="{{ url('/register') }}">--}}
                {{ Form::open(['route' => 'auth.register', 'class' => 'ui large form']) }}
                    {{--{!! csrf_field() !!}--}}
                    <div class="ui stacked">
                        <div class="field {{ $errors->has('name') ? 'error' : '' }}">
                            <div class="ui left icon input">
                                <i class="user icon"></i>
                                {{--<input type="text" name="name" value="{{ old('name') }}" placeholder="昵称">--}}
                                {{ Form::input('name', 'name', old('name'), ['placeholder' => trans('validation.attributes.frontend.name')]) }}
                            </div>
                            {{--@if ($errors->has('name'))--}}
                                {{--<div class="ui label">--}}
                                    {{--{{ $errors->first('name') }}--}}
                                {{--</div>--}}
                            {{--@endif--}}
                        </div>
                        <div class="field {{ $errors->has('email') ? 'error' : '' }}">
                            <div class="ui left icon input">
                                <i class="user icon"></i>
                                {{--<input type="text" name="email" value="{{ old('email') }}" placeholder="登录账号E-mail">--}}
                                {{ Form::input('email', 'email', old('email'), ['placeholder' => trans('validation.attributes.frontend.email')]) }}
                            </div>
                            {{--@if ($errors->has('email'))--}}
                                {{--<div class="ui label">--}}
                                    {{--{{ $errors->first('email') }}--}}
                                {{--</div>--}}
                            {{--@endif--}}
                        </div>
                        <div class="field {{ $errors->has('password') ? 'error' : '' }}">
                            <div class="ui left icon input">
                                <i class="lock icon"></i>
                                {{--<input type="password" name="password" placeholder="登录密码">--}}
                                {{ Form::input('password', 'password', null, ['placeholder' => trans('validation.attributes.frontend.password')]) }}
                            </div>
                            {{--@if ($errors->has('password'))--}}
                                {{--<div class="ui label">--}}
                                    {{--{{ $errors->first('password') }}--}}
                                {{--</div>--}}
                            {{--@endif--}}
                        </div>

                        <div class="field {{ $errors->has('password_confirmation') ? 'error' : '' }}">
                            <div class="ui left icon input">
                                <i class="lock icon"></i>
                                {{--<input type="password" name="password_confirmation" placeholder="确认密码">--}}
                                {{ Form::input('password', 'password_confirmation', null, ['placeholder' => trans('validation.attributes.frontend.password_confirmation')]) }}
                            </div>
                            {{--@if ($errors->has('password_confirmation'))--}}
                                {{--<div class="ui pointing red basic label">--}}
                                    {{--{{ $errors->first('password_confirmation') }}--}}
                                {{--</div>--}}
                            {{--@endif--}}
                        </div>
                        {{--@if (config('access.captcha.registration'))--}}
                            {{--<div class="field">--}}
                                {{--<div class="">--}}
                                    {{--{!! Form::captcha() !!}--}}
                                    {{--{{ Form::hidden('captcha_status', 'true') }}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--@endif--}}
                        <div class="field">
                            <div class="ui checkbox">
                                <input type="checkbox" name="remember" tabindex="0" class="hidden">
                                <label>同意<a href="{{url('/terms')}}" target="_blank">“今天买点啥用户使用协议”</a></label>
                            </div>
                        </div>

                        {{ Form::submit(trans('labels.frontend.auth.register_button'), ['class' => 'ui fluid large red submit button']) }}
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