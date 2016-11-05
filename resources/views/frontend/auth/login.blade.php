@extends('frontend.layouts.one')

@section('content')
    <div class="container">
        <div class="ui middle aligned center aligned stackable grid">
            <div class="six wide column">
                <h2 class="ui header" style="margin-top: 50px;">
                    <div class="content">
                        {{ trans('labels.frontend.auth.login_box_title') }}
                    </div>
                </h2>
                {{ Form::open(['route' => 'frontend.auth.login', 'class' => 'ui large form']) }}
                    <div class="ui stacked">
                        <div class="field {{ $errors->has('email') ? 'error' : '' }}">
                            <div class="ui left icon input">
                                <i class="user icon"></i>
                                {{ Form::input('email', 'email', old('email'), ['placeholder' => '登录账号E-mail']) }}
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
                                {{ Form::input('password', 'password', null, ['placeholder' => '登录密码']) }}
                            </div>
                            {{--@if ($errors->has('password'))--}}
                                {{--<div class="ui label">--}}
                                    {{--{{ $errors->first('password') }}--}}
                                {{--</div>--}}
                            {{--@endif--}}
                        </div>
                        <div class="inline fields">
                            <div class="nine wide field">
                                <div class="ui checkbox">
                                    {{ Form::checkbox('remember', 0, null, ['class' => 'hidden']) }}
                                    <label>{{ trans('labels.frontend.auth.remember_me') }}</label>
                                </div>
                            </div>
                            <div class="seven wide field">
                                {{ link_to_route('frontend.auth.password.reset', trans('labels.frontend.passwords.forgot_password')) }}
                            </div>
                        </div>

                        {{ Form::submit(trans('labels.frontend.auth.login_button'), ['class' => 'ui fluid large red submit button', 'style' => '']) }}
                    </div>
                {{ Form::close() }}
                <div class="ui message">
                    还没有账号? <a href="{{ url('/register') }}">立即注册</a>
                </div>
                <div>
                    {!! $socialite_links !!}
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