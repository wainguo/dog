/**
 * Created by wainguo on 16/7/23.
 */

var vm = new Vue({
    el: '#articleList',
    data: {
        moreArticleIsLoading: false,
        currentPage: 1,
        lastPage: 9999,
        moreArticles: []
    },
    created: function() {
        var self = this;
        // slide show
        $(".single-item").slick({
            dots: true,
            infinite: true,
            autoplay: true,
            draggable: false,
            pauseOnHover: true,
            autoplaySpeed: 5000,
            speed: 400,
            slidesToShow: 1,
            slidesToScroll: 1
        });

        $(window).scroll(this.loadMoreArticles);
        // $(window).scroll(function() {
        //     // End of the document reached?
        //     if ($(document).height() - $(window).height() == $(window).scrollTop()) {
        //         $('#loading').show();
        //
        //         $.ajax({
        //             url: 'get-post.php',
        //             dataType: 'html',
        //             success: function(html) {
        //                 $('#posts').append(html);
        //                 $('#loading').hide();
        //             }
        //         });
        //     }
        // });

        // var options = [
        //     {
        //         selector: '.end-of-list', offset: 50, callback: function(el) {
        //             Materialize.toast("This is our ScrollFire Demo!", 1500 );
        //             self.loadMoreArticles();
        //         }
        //     }
        // ];
        // Materialize.scrollFire(options);


        $('.hollapsible .title').first().addClass('active');
        $('.hollapsible .items').first().addClass('active');
        $('.hollapsible .title').mouseenter( function(){
            $(this).siblings().filter('.active').removeClass('active');
            $(this).addClass('active');
            $(this).next().addClass('active');
        });

        // $('.browse.item').popup({
        //     popup     : '.admission.popup',
        //     hoverable : true,
        //     position  : 'bottom left',
        //     delay     : {
        //         show: 300,
        //         hide: 800
        //     }
        // });
        //
        // var $dropdownItem = $('.container .menu .dropdown .item'),
        //     $menuItem = $('.menu a.item, .menu .link.item').not($dropdownItem),
        // // alias
        //     handler = {
        //         activate: function() {
        //             if(!$(this).hasClass('dropdown browse')) {
        //                 $(this).addClass('active')
        //                     .closest('.ui.menu')
        //                     .find('.item')
        //                     .not($(this))
        //                     .removeClass('active');
        //             }
        //         }
        //     };
        // $menuItem.on('click', handler.activate);
    },

    methods: {
        loadMoreArticles: function() {
            console.log('load');
            if ($(document).height() - $(window).height() != $(window).scrollTop()) {
                return;
            }
            console.log('load show');
            // $('#loading').show();
            var self = this;
            if(this.currentPage+1 > this.lastPage) {
                console.log('aready at the last page');
                return;
            }
            if(this.moreArticleIsLoading) {
                console.log('loading');
                return;
            }
            this.moreArticleIsLoading = true;
            var toPage = this.currentPage + 1;
            this.$http.get('/api/get/more-articles?page='+toPage).then(
                function(response) {
                    var jtmdsResponse = response.data;
                    if(jtmdsResponse.errorCode == 0) {
                        var pagedArticles = jtmdsResponse.content;
                        self.lastPage = pagedArticles.last_page;
                        self.currentPage = pagedArticles.current_page;
                        if(Array.isArray(pagedArticles.data)){
                            pagedArticles.data.forEach(function(obj){
                                self.moreArticles.push(obj);
                            });

                            console.log(self.moreArticles);
                        }
                    }
                    self.moreArticleIsLoading = false;
                    // $('.ui.sticky').sticky('refresh');
                },
                function(response) {
                    console.log(response);
                    self.moreArticleIsLoading = false;
                }
            )
        }
    }
});