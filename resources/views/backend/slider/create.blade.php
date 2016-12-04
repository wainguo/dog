@extends ('backend.layouts.master')

@section ('title', trans('labels.backend.slider.management') . ' | ' . trans('labels.backend.slider.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.slider.management') }}
        <small>{{ trans('labels.backend.slider.create') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::open(['route' => 'admin.slider.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-slider']) }}

        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.slider.create') }}</h3>
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="form-group">
                    {{ Form::label('title', trans('validation.attributes.backend.slider.title'), ['class' => 'col-lg-2 control-label']) }}

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
                    {{ Form::label('position', trans('validation.attributes.backend.slider.slideshow'), ['class' => 'col-lg-2 control-label']) }}
                    <div class="col-lg-10">
                        {{ Form::radio("position", "slideshow", true) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->
                <div class="form-group">
                    {{ Form::label('position', trans('validation.attributes.backend.slider.showcase'), ['class' => 'col-lg-2 control-label']) }}
                    <div class="col-lg-10">
                        {{ Form::radio("position", "showcase", false) }}
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
                        {{ Form::text('sort', ($slider_count+1), ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.slider.sort')]) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->
            </div><!-- /.box-body -->
        </div><!--box-->

        <div class="box box-success">
            <div class="box-body">
                <div class="pull-left">
                    {{ link_to_route('admin.slider.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-sm']) }}
                </div><!--pull-left-->

                <div class="pull-right">
                    {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-success btn-sm']) }}
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
