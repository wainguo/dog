@include('frontend.includes.header')

<div class="ui container">
    <div class="ui grid">
        <div class="sixteen wide column" id="centerPanel">
            @yield('content')
        </div>
    </div>
</div>

<!-- Scripts -->
{{--{{ HTML::script('https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js') }}--}}
{{--<script>window.jQuery || document.write('<script src="{{asset('js/vendor/jquery/jquery-2.1.4.min.js')}}"><\/script>')</script>--}}
{!! Html::script('js/vendor/jquery/jquery-2.1.4.min.js') !!}
{!! Html::script('js/vendor/vue/vue.min.js') !!}
{!! Html::script('js/vendor/vue/vue-resource.min.js') !!}

@yield('before-scripts-end')
{!! Html::script(elixir('js/frontend.js')) !!}
<script>
    $(document).ready(function () {
        // fix main menu to page
        $('#headerMenu.menu').visibility({
            type: 'fixed',
            zIndex: '1000'
        });
        // lazy load images
        $('.image').visibility({
            type: 'image',
            transition: 'fade in',
            duration: 500
        });
        // show dropdown on hover
        $('.menu .ui.dropdown').dropdown({
            on: 'hover'
        });

// login modal
//        $('.ui.login.modal').modal({
//            blurring: true
//        }).modal('attach events', '.login.item', 'show');
    });
</script>

@yield('after-scripts-end')

        {{--@include('includes.partials.ga')--}}
@include('frontend.includes.footer')