/**
 * Created by wainguo on 16/7/23.
 */

var vm = new Vue({
    el: '#jtmdsChannel',

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

        $(window).scroll(this.loadMoreArticles);

        $('.hollapsible .title').first().addClass('active');
        $('.hollapsible .items').first().addClass('active');
        $('.hollapsible .title').mouseenter( function(){
            $(this).siblings().filter('.active').removeClass('active');
            $(this).addClass('active');
            $(this).next().addClass('active');
        });
    },

    methods: {
        loadMoreArticles: function() {
            var self = this;
            if ($(document).height() - $(window).height() != $(window).scrollTop()) {
                return;
            }

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
                },
                function(response) {
                    console.log(response);
                    self.moreArticleIsLoading = false;
                }
            )
        }
    }
});