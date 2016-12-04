@extends('frontend.layouts.one')

@section('content')
    <div class="breadcrumb">
        <span class="section"> 当前位置：</span>
        <a class="section" href="{{url('')}}">首页</a>
        <span>#</span>
        <span class="section">{{ trans('labels.frontend.passwords.reset_password_box_title') }}</span>
    </div>
    <div class="container">
        <div class="row">
            <div class="col s12">
                @if (session('status'))
                    <div class="ui warning message">
                        <i class="close icon"></i>
                        {{ session('status') }}
                    </div>
                @endif

                    @include('includes.partials.messages')

                {{ Form::open(['route' => 'frontend.auth.password.reset', 'class' => 'ui large form']) }}

                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">

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
                        {{--@if ($errors->has('password'))--}}
                        {{--<div class="ui label">--}}
                        {{--{{ $errors->first('password') }}--}}
                        {{--</div>--}}
                        {{--@endif--}}
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="password_confirmation" name="password_confirmation" type="password" class="validate">
                            {{--<label for="password">登录密码</label>--}}
                            <label for="password_confirmation">{{trans('validation.attributes.frontend.password_confirmation')}}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12">
                            <button class="btn btn-small red waves-effect waves-light" type="submit" name="action">
                                {{trans('labels.frontend.auth.reset_password_button')}}
                            </button>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
