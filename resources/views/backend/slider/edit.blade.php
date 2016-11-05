@extends ('backend.layouts.master')

@section ('title', trans('labels.backend.slider.management') . ' | ' . trans('labels.backend.slider.edit'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.slider.management') }}
        <small>{{ trans('labels.backend.slider.edit') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::model($slider, ['route' => ['admin.slider.update', $slider], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'id' => 'edit-slider']) }}

        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.slider.edit') }}</h3>
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="form-group">
                    {{ Form::label('name', trans('validation.attributes.backend.slider.title'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.slider.title')]) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('url', trans('validation.attributes.backend.slider.url'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        {{ Form::text('url', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.slider.url')]) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->
                <div class="form-group">
                    {{ Form::label('url', trans('validation.attributes.backend.slider.slideshow'), ['class' => 'col-lg-2 control-label']) }}
                    <div class="col-lg-10">
                        {{ Form::radio("position", "slideshow", $slider->position=="slideshow") }}
                    </div><!--col-lg-10-->
                </div><!--form control-->
                <div class="form-group">
                    {{ Form::label('url', trans('validation.attributes.backend.slider.showcase'), ['class' => 'col-lg-2 control-label']) }}
                    <div class="col-lg-10">
                        {{ Form::radio("position", "showcase", $slider->position=="showcase") }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    {{--<label for="cover">封面图片</label>--}}
                    {{ Form::label('cover', trans('validation.attributes.backend.slider.cover'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        {{ Form::file('file', ['id' => 'selectFile']) }}

                        <input type="hidden" name="cover" id="cover" value="{{$slider->cover or ''}}">
                        <img id="sliderImg" src="{{$slider->cover}}" style="width: 320px; height: 180px;">
                    </div><!--col-lg-10-->
                </div>

                <div class="form-group">
                    {{ Form::label('sort', trans('validation.attributes.backend.slider.sort'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        {{ Form::text('sort', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.slider.sort')]) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->
            </div><!-- /.box-body -->
        </div><!--box-->

        <div class="box box-success">
            <div class="box-body">
                <div class="pull-left">
                    {{ link_to_route('admin.slider.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-xs']) }}
                </div><!--pull-left-->

                <div class="pull-right">
                    {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-success btn-xs']) }}
                </div><!--pull-right-->

                <div class="clearfix"></div>
            </div><!-- /.box-body -->
        </div><!--box-->

    {{ Form::close() }}
@stop

@section('after-scripts-end')
    {{ Html::script('js/vendor/jquery/jquery.form.js') }}
    <script>
        $(document).ready(function(){
            var uploadCoverOptions = {
                url: "/api/upload/slider",
                type: "post",
                dataType:'json',
                beforeSend: function() {
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    var percentVal = percentComplete + '%';
                    console.log(percentVal);
                },
                error:function(response){
                    alert("上传失败了");
                },
                success: function(response) {
                    if(response.errorCode == 0) {
                        $('#cover').val(response.content.imageUrl);
                        $('#sliderImg').attr('src', response.content.imageUrl);
                    }
                }
            };

            $("#selectFile").on('change', function(){
                var fileValue = $("#selectFile").val();
                console.log(fileValue);
                if (fileValue == "") {
                    return;
                }
                form = $("<form></form>");
                var fileInput = $("#selectFile").clone();
                form.append(fileInput);
                form.ajaxSubmit(uploadCoverOptions);
            });
        });
    </script>
@stop