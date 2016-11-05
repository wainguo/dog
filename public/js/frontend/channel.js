/**
 * Created by wainguo on 16/7/23.
 */

var vm = new Vue({
    el: '#jtmdsBody',

    data: {
        moreArticleIsLoading: false,
        currentPage: 1,
        lastPage: 9999,
        channelId: 0,
        moreArticles: []
    },

    created: function() {
        var self = this;
        this.channelId = $('#channelId').val();

        $('#jtmdsChannel').visibility({
            once: false,
            // update size when new content loads
            observeChanges: true,

            // load content on bottom edge visible
            onBottomVisible: function() {
                // loads more articles
                self.loadMoreArticles();
            }
        });

        // sticky content to centerPanel
        $('.ui.sticky').sticky({
            offset : 50,
            // pushing: false,
            context: '#centerPanel'
        });

        $('.ui.collapse .title').first().addClass('active');
        $('.ui.collapse .items').first().addClass('active');
        $('.ui.collapse .title').mouseenter( function(){
            $(this).siblings().filter('.active').removeClass('active');
            $(this).addClass('active');
            $(this).next().addClass('active');
        });

        $('.browse.item').popup({
            popup     : '.admission.popup',
            hoverable : true,
            position  : 'bottom left',
            delay     : {
                show: 300,
                hide: 800
            }
        });

        var $dropdownItem = $('.container .menu .dropdown .item'),
            $menuItem = $('.menu a.item, .menu .link.item').not($dropdownItem),
            // alias
            handler = {
                activate: function() {
                    if(!$(this).hasClass('dropdown browse')) {
                        $(this).addClass('active')
                            .closest('.ui.menu')
                            .find('.item')
                            .not($(this))
                            .removeClass('active');
                    }
                }
            };
        $menuItem.on('click', handler.activate);
    },

    methods: {
        loadMoreArticles: function() {
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
            this.$http.get('/api/get/more-articles?channel='+self.channelId+'&page='+toPage).then(
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
                        }
                    }
                    self.moreArticleIsLoading = false;
                    $('.ui.sticky').sticky('refresh');
                },
                function(response) {
                    console.log(response);
                    self.moreArticleIsLoading = false;
                }
            )
        }
    }
});