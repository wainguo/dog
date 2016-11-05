/**
 * Created by wainguo on 16/7/23.
 */

var vm = new Vue({
    el: '#jtmdsBody',

    data: {
        toast_message: '',
        moreCommentIsLoading: false,
        currentPage: 0,
        lastPage: 999,
        comments: [],
        article_id: 0,
        parent_id: 0,
        content:""
    },

    created: function() {
        var self = this;

        //self.articleId = $('#articleId').val();
        if($('#comments')){
            self.loadMoreComments();

            $('#jtmdsArticle').visibility({
                once: false,
                // update size when new content loads
                observeChanges: true,

                // load content on bottom edge visible
                onBottomVisible: function() {
                    // loads more articles
                    self.loadMoreComments();
                }
            });
        }

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

        if(this.toast_message){
            console.log(this.toast_message);
            this.showToastMessage(this.toast_message);
        }
    },

    methods: {
        loadMoreComments: function() {
            var self = this;
            if(this.currentPage+1 > this.lastPage) {
                console.log('aready at the last page');
                return;
            }
            if(this.moreCommentIsLoading) {
                console.log('loading');
                return;
            }
            self.moreCommentIsLoading = true;
            var toPage = this.currentPage + 1;
            this.$http.get('/api/get/comments?article_id='+this.article_id+'&page='+toPage).then(
                function(response) {
                    var jtmdsResponse = response.data;
                    if(jtmdsResponse.errorCode == 0) {

                        var pagedComments = jtmdsResponse.content;
                        //self.lastPage = pagedComments.last_page;
                        //self.currentPage = pagedComments.current_page;
                        this.$set('lastPage', pagedComments.last_page);
                        this.$set('currentPage', pagedComments.current_page);
                        if(Array.isArray(pagedComments.data)){
                            pagedComments.data.forEach(function(obj){
                                console.log(self.comments);
                                self.comments.push(obj);
                            });
                        }
                        console.log(self.comments);
                    }
                    //self.moreCommentIsLoading = false;
                    this.$set('moreCommentIsLoading', false);
                    $('.ui.sticky').sticky('refresh');
                },
                function(response) {
                    //self.moreCommentIsLoading = false;
                    this.$set('moreCommentIsLoading', false);
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