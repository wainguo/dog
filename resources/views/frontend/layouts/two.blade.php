@include('frontend.includes.header')

<div id="jtmdsContent">
    @include('frontend.includes.navbar')
    <div class="container">
        {{--@include('includes.partials.messages')--}}
        <div class="row">
            <div class="col s8" id="centerPanel">
                @yield('content')
            </div>

            <div class="col s4" id="rightPanel">
                @yield('sidebar')
            </div>
        </div>
    </div><!-- container -->
</div>

<!-- Scripts -->
{{ HTML::script('http://libs.baidu.com/jquery/2.1.4/jquery.min.js') }}
<script>window.jQuery || document.write('<script src="{{asset('js/vendor/jquery/jquery-2.1.4.min.js')}}"><\/script>')</script>
{!! Html::script('vendor/materialize/js/materialize.min.js') !!}
{!! Html::script('js/vendor/vue/vue.min.js') !!}
{!! Html::script('js/vendor/vue/vue-resource.min.js') !!}

@yield('before-scripts-end')
{{--{!! Html::script(elixir('js/frontend.js')) !!}--}}
<script>
    $(document).ready(function () {
        $('#jtmdsNavbar').pushpin({
            top: $('#jtmdsContent').offset().top,
            bottom: Infinity
        });

        $('.pushpin-item').each(function () {
            var $this = $(this);
            var $target = $('#' + $(this).attr('data-target'));
            $this.pushpin({
                top: $target.offset().top,
//                top: $this.offset().top,
                bottom: Infinity
//                bottom: $target.offset().top + $target.outerHeight() - $this.height()
            });
        });
    });
</script>

@yield('after-scripts-end')

@include('frontend.includes.tongji')
@include('frontend.includes.footer')