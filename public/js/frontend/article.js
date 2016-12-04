/**
 * Created by wainguo on 16/7/23.
 */

var vm = new Vue({
    el: '#jtmdsArticle',

    data: {
        toast_message: '',
        moreCommentIsLoading: false,
        currentPage: 0,
        lastPage: 999,
        comments: [],
        article_id: 4,
        parent_id: 0,
        content:""
    },

    created: function() {
        var self = this;

        // self.articleId = $('#articleId').val();

        if($('#comments')){
            self.loadMoreComments();

            $(window).scroll(this.loadMoreComments);
        }

        $('.hollapsible .title').first().addClass('active');
        $('.hollapsible .items').first().addClass('active');
        $('.hollapsible .title').mouseenter( function(){
            $(this).siblings().filter('.active').removeClass('active');
            $(this).addClass('active');
            $(this).next().addClass('active');
        });

        if(this.toast_message){
            console.log(this.toast_message);
            this.showToastMessage(this.toast_message);
        }
    },

    methods: {
        loadMoreComments: function() {
            if ($(document).height() - $(window).height() != $(window).scrollTop()) {
                return;
            }

            var self = this;
            if(self.currentPage+1 > self.lastPage) {
                console.log('aready at the last page');
                return;
            }
            if(self.moreCommentIsLoading) {
                console.log('loading');
                return;
            }
            self.moreCommentIsLoading = true;
            var toPage = this.currentPage + 1;
            self.$http.get('/api/get/comments?article_id='+this.article_id+'&page='+toPage).then(
                function(response) {
                    var jtmdsResponse = response.data;
                    if(jtmdsResponse.errorCode == 0) {

                        var pagedComments = jtmdsResponse.content;
                        self.lastPage = pagedComments.last_page;
                        self.currentPage = pagedComments.current_page;
                        if(Array.isArray(pagedComments.data)){
                            pagedComments.data.forEach(function(obj){
                                console.log(self.comments);
                                self.comments.push(obj);
                            });
                        }
                        console.log(self.comments);
                    }
                    self.moreCommentIsLoading = false;
                },
                function(response) {
                    self.moreCommentIsLoading = false;
                }
            )
        },
        
        doClickReply: function (parentId, replyTo) {
            this.parent_id = parentId;
            this.content = '回复' + replyTo + ':';
        },

        showToastMessage: function (message) {
            if(!message){
                return;
            }
            this.toast_message = message;
            $('#jtmdsToaster').css("display", "block");
            setTimeout(this.hideToastMessage,3000);
        },

        hideToastMessage: function () {
            $('#jtmdsToaster').css("display", "none");
        }
    }
});