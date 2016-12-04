@extends('frontend.layouts.one')

@section('content')
    <div class="breadcrumb">
        <span class="section"> 当前位置：</span>
        <a class="section" href="{{url('')}}">首页</a>
        <span>#</span>
        <span class="section">{{ trans('labels.frontend.passwords.reset_password_box_title') }}</span>
    </div>
    <div class="container">
        @include('includes.partials.messages')
        <div class="row">
            <div class="col s12">
                @if (session('status'))
                    <div class="success message">
                        {{ session('status') }}
                    </div>
                @endif

                {{ Form::open(['route' => 'frontend.auth.password.email', 'class' => 'ui large form']) }}
                    <div class="row">
                        <div class="input-field col s8">
                            <input id="email" name="email" type="email" class="validate" value="{{old('email')}}">
                            <label for="email">{{trans('validation.attributes.frontend.email')}}</label>
                        </div>
                        <div class="input-field col s4">
                            <button class="btn btn-small red waves-effect waves-light" type="submit" name="action">
                                {{trans('labels.frontend.passwords.send_password_reset_link_button')}}
                            </button>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection