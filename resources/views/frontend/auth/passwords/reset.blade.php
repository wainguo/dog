@extends('frontend.layouts.one')

@section('content')
    <div class="container">
        <div class="ui middle aligned center aligned stackable grid">
            <div class="six wide column">
                <h2 class="ui header" style="margin-top: 50px;">
                    <div class="content">{{ trans('labels.frontend.passwords.reset_password_box_title') }}</div>
                </h2>
                @if (session('status'))
                    <div class="ui warning message">
                        <i class="close icon"></i>
                        {{ session('status') }}
                    </div>
                @endif

                {{ Form::open(['route' => 'auth.password.reset', 'class' => 'ui large form']) }}

                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">

                    <div class="ui stacked">
                        <div class="field {{ $errors->has('email') ? 'error' : '' }}">
                            <div class="ui left icon input">
                                <i class="user icon"></i>
                                <input type="text" name="email" value="{{ $email or old('email') }}" placeholder="登录账号E-mail">
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
                                {{ Form::input('password', 'password_confirmation', null, ['placeholder' => trans('validation.attributes.frontend.password_confirmation')]) }}
                            </div>
                            {{--@if ($errors->has('password_confirmation'))--}}
                                {{--<div class="ui pointing red basic label">--}}
                                    {{--{{ $errors->first('password_confirmation') }}--}}
                                {{--</div>--}}
                            {{--@endif--}}
                        </div>

                        {{ Form::submit(trans('labels.frontend.passwords.reset_password_button'), ['class' => 'ui fluid large red submit button']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
