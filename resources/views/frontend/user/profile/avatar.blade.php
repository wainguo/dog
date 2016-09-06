@extends('frontend.layouts.one')

@section('styles')
    <link href="{{asset('assets/css/jquery.Jcrop.css') }}" rel="stylesheet">
@endsection

@section('content')
    <style>
        #preview-pane {
            padding: 10px;
            border: 1px rgba(0,0,0,.4) solid;
            width: 220px;
            margin-bottom: 20px;
            background-color: white;
            border-radius: 6px;
            -webkit-border-radius: 6px;
            -moz-border-radius: 6px;
            box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
            -webkit-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
            -moz-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
        }

        /* The Javascript code will set the aspect ratio of the crop
           area based on the size of the thumbnail preview,
           specified here */
        #preview-pane .preview-container {
            width: 200px;
            height: 200px;
            overflow: hidden;
        }
    </style>
<div class="container">
    <div class="ui breadcrumb">
        <div class="section"> 当前位置：</div>
        <a class="section" href="{{url('')}}">首页</a>
        <i class="right angle icon divider"></i>
        <div class="section">更新头像</div>
    </div>

    <div class="ui two column grid">
        <div class="eight wide column">
            <form id="uploadAvatarForm" class="ui form" method="POST">
                {!! csrf_field() !!}
                <div style="text-align: center;margin-top: 10px;">
                    <label for="inputAvatar" class="ui red icon button">
                        <i class="file icon"></i>选择图片
                    </label>
                    <input type="file" id="inputAvatar" name="file" style="display:none">
                </div>
            </form>
        </div>
        <div class="eight wide column">

        </div>
    </div>
    <div class="ui two column grid">
        <div class="eight wide column" style="text-align: center;">
            <img v-bind:src="avatarUrl || '/assets/images/image.png'" id="cropbox"
                 style="width: 100%;height: 100%;max-width: 500px;max-height: 500px;"/>
        </div>
        <div class="eight wide column">
            <form class="ui large form" method="POST" action="{{ url('/user/update-avatar') }}">
                {!! csrf_field() !!}
                <input type="hidden" id="container_width" name="container_width" />
                <input type="hidden" id="x" name="x" />
                <input type="hidden" id="y" name="y" />
                <input type="hidden" id="w" name="w" />
                <input type="hidden" id="h" name="h" />
                <input type="hidden" id="source_image" name="source_image" v-model="avatarUrl" />
                <div v-if="avatarUrl">
                    <div id="preview-pane">
                        <div class="preview-container">
                            <img v-bind:src="avatarUrl" class="bordered image jcrop-preview" alt="Preview" />
                        </div>
                    </div>
                    <button type="submit" class="ui large red submit button">保存</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{asset('assets/js/vendor/jquery.form.js') }}"></script>
    <script src="{{asset('assets/js/vendor/jquery.Jcrop.min.js') }}"></script>
<script>
    var vm = new Vue({
        el: '#jtmdsBody',
        data: {
            avatarUrl: null,
            boundx: null,
            boundy: null,
            jcrop: null,
            $preview: null,
            $previewContainer: null,
            $previewImage: null
        },
        ready: function() {
            var self = this;

            var uploadAvatarOptions = {
                url: "{{url('api/upload/image')}}",
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
                        if(self.jcrop){
                            self.jcrop.release();
                            self.jcrop.destroy();
                            self.jcrop = null;
                        }
                        self.avatarUrl = response.content.imageUrl;

                        Vue.nextTick(function () {
                            // Grab some information about the preview pane
                            self.$preview = $('#preview-pane');
                            self.$previewContainer = $('#preview-pane .preview-container');
                            self.$previewImage = $('#preview-pane .preview-container img');

                            $('#cropbox').Jcrop({
                                aspectRatio: 1,
                                onChange: self.updatePreview,
                                onSelect: self.updatePreview
                            },function(){
                                // Use the API to get the real image size
                                self.jcrop = this;
                                var bounds = this.getBounds();
                                self.boundx = bounds[0];
                                self.boundy = bounds[1];
                                console.log(bounds);
                                console.log(this.getWidgetSize());
                                $('#container_width').val(self.boundx);

                                var scaleFactor = this.getScaleFactor();
                                self.xscale = scaleFactor[0];
                                self.yscale = scaleFactor[1];
                                console.log(scaleFactor);
                                // Store the API in the jcrop_api variable
                                jcrop_api = this;
                                jcrop_api.setSelect([130,65,130+200,65+200]);
                                jcrop_api.setOptions({ bgFade: true });
                                jcrop_api.ui.selection.addClass('jcrop-selection');
                                // Move the preview into the jcrop container for css positioning
//                        self.$preview.appendTo(jcrop_api.ui.holder);
                            });
                        })

                    }
                }
            };

            $("#inputAvatar").on('change', function(){
                console.log($("#inputAvatar").val());
                if ($("#inputAvatar").val() == "") {
                    return;
                }
                $('#uploadAvatarForm').ajaxSubmit(uploadAvatarOptions);
            });
        },

        methods: {
            updatePreview: function (c)
            {
                var self = this;
                if (parseInt(c.w) > 0)
                {
                    var rx = 200 / c.w;
                    var ry = 200 / c.h;

                    self.$previewImage.css({
                        width: Math.round(rx * self.boundx) + 'px',
                        height: Math.round(ry * self.boundy) + 'px',
                        marginLeft: '-' + Math.round(rx * c.x) + 'px',
                        marginTop: '-' + Math.round(ry * c.y) + 'px'
                    });
                    var w = c.w * self.xscale;
                    var h = c.h * self.xscale;
                    var x = c.x * self.xscale;
                    var y = c.y * self.xscale;
                    $('#x').val(x);
                    $('#y').val(y);
                    $('#w').val(w);
                    $('#h').val(h);
                }
            },

            checkCoords: function () {
                if (parseInt($('#w').val())) return true;
                alert('请先选择剪切区域再提交更新');
                return false;
            }
        }
    });
</script>
@endsection