@extends('frontend.layouts.one')

@section('content')
    <div class="container">

        <div class="ui middle aligned center aligned stackable grid">
            <div class="six wide column">
                <div class="panel panel-default">

                    <h2 class="ui header" style="margin-top: 30px;">
                        <div class="content">
                            {{ trans('labels.frontend.passwords.reset_password_box_title') }}
                        </div>
                    </h2>
                    {{--<div class="panel-heading">{{ trans('labels.frontend.passwords.reset_password_box_title') }}</div>--}}
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="ui success message">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ Form::open(['route' => 'frontend.auth.password.email', 'class' => 'ui large form']) }}

                        <div class="inline field">
                            {{ Form::label('email', trans('validation.attributes.frontend.email'), ['class' => '']) }}
                                {{--{{ Form::input('email', 'email', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.email')]) }}--}}
                            {{ Form::input('email', 'email', old('email'), ['placeholder' => trans('validation.attributes.frontend.email')]) }}
                        </div>

                        <div class="field">
                            {{ Form::submit(trans('labels.frontend.passwords.send_password_reset_link_button'), ['class' => 'ui button']) }}
                        </div>

                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection