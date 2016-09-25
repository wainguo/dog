@extends('frontend.layouts.one')

@section('content')
    <div class="container">
        <div class="ui breadcrumb">
            <div class="section"> 当前位置：</div>
            <a class="section" href="{{url('')}}">首页</a>
            <i class="right angle icon divider"></i>
            <div class="section">{{ trans('labels.frontend.user.profile.update_information') }}</div>
        </div>
        <div class="ui divider"></div>
        {{ Form::model($user, ['route' => 'frontend.user.profile.update', 'class' => 'ui form', 'method' => 'PATCH']) }}
        <div class="inline field">
            {{ Form::label('name', trans('validation.attributes.frontend.name'), ['class' => '']) }}
            {{ Form::input('text', 'name', null, ['class' => '', 'placeholder' => trans('validation.attributes.frontend.name')]) }}
        </div>

        @if ($user->canChangeEmail())
            <div class="inline field">
                {{ Form::label('email', trans('validation.attributes.frontend.email'), ['class' => '']) }}
                {{ Form::input('email', 'email', null, ['placeholder' => trans('validation.attributes.frontend.email')]) }}
            </div>
        @endif

        {{ Form::submit(trans('labels.general.buttons.save'), ['class' => 'ui red button']) }}

        {{ Form::close() }}

    </div>
@endsection