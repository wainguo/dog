@extends('frontend.layouts.one')

@section('content')
    <div class="container">
        <div class="ui middle aligned center aligned stackable grid">
            <div class="six wide column">
                <h2 class="ui header" style="margin-top: 30px;">
                    <div class="content">
                        {{ trans('labels.frontend.user.passwords.change') }}
                    </div>
                </h2>
                {{ Form::open(['route' => ['auth.password.change'], 'class' => 'ui large form']) }}
                <div class="ui stacked">
                    <div class="field {{ $errors->has('password') ? 'error' : '' }}">
                        <div class="ui left icon input">
                            <i class="lock icon"></i>
                            {{--<input type="password" name="password" placeholder="登录密码">--}}
                            {{ Form::input('password', 'old_password', null, ['placeholder' => trans('validation.attributes.frontend.old_password')]) }}
                        </div>
                        {{--@if ($errors->has('old_password'))--}}
                            {{--<div class="ui label">--}}
                                {{--{{ $errors->first('old_password') }}--}}
                            {{--</div>--}}
                        {{--@endif--}}
                    </div>

                    <div class="field {{ $errors->has('password') ? 'error' : '' }}">
                        <div class="ui left icon input">
                            <i class="lock icon"></i>
                            {{ Form::input('password', 'password', null, ['placeholder' => trans('validation.attributes.frontend.new_password')]) }}
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
                            {{ Form::input('password', 'password_confirmation', null, ['placeholder' => trans('validation.attributes.frontend.new_password_confirmation')]) }}
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

                    {{ Form::submit(trans('labels.general.buttons.update'), ['class' => 'ui fluid large red submit button']) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
