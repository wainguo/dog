/**
 * Created by wainguo on 16/7/23.
 */

var vm = new Vue({
    el: '#jtmdsBody',

    data: {
        csrfToken: '',
        article_id: '',
        category_name: '',
        category_parent: 0,
        article_categories: [],     //文章关联的分类目录
        article_category_ids: [],     //文章关联的分类目录IDs
        categories: [],     //分类目录
        tag_names: '',      //新添加的标签
        article_tags: [],           //文章关联的标签
        tags: []  //常用标签
    },
    created: function() {
        var self = this;

        //获取所有的分类目录
        this.getCategories();

        //获取文章的标签
        this.getArticleProperties();

        $('.ui.checkbox').checkbox();
        $('.ui.accordion').accordion();

        CKEDITOR.replace( 'editor1', {
                language: 'zh-cn',
                filebrowserImageUploadUrl: "/article/upload-image?_token="+self.csrfToken,
            toolbarGroups: [
                { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
                { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                { name: 'links', groups: [ 'links' ] },
                { name: 'insert', groups: [ 'insert' ] },
                { name: 'forms', groups: [ 'forms' ] },
                { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
                { name: 'others', groups: [ 'others' ] },
                { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
                { name: 'styles', groups: [ 'styles' ] },
                { name: 'tools', groups: [ 'tools' ] },
                { name: 'colors', groups: [ 'colors' ] },
                { name: 'about', groups: [ 'about' ] }
            ],
            removeButtons: 'Subscript,Superscript,About,Source,Cut,Undo,Copy,Redo,Paste,PasteText,PasteFromWord,Scayt,Anchor,SpecialChar,RemoveFormat',
            height: 200,
            extraPlugins: 'autogrow',
            autoGrow_minHeight: 200
        });
    },

    methods: {
        addCategory: function() {
            var self = this;
            console.log(self.category_name);
            var data = {
                _token: self.csrfToken,
                category_parent: self.category_parent,
                category_name: self.category_name
            };
            console.log(data);
            this.$http.post('/api/post/add-category',data).then(
                function(response) {
                    var jtmdsResponse = response.data;
                    if(jtmdsResponse.errorCode == 0) {
                        var categories = jtmdsResponse.content;
                        if(Array.isArray(categories)){
                            this.$set('categories', categories);
                        }
                    }
                    else {
                        console.log(jtmdsResponse.errorMessage);
                    }
                },
                function(response) {
                    console.log(response);
                }
            )
        },
        getCategories: function () {
            var self = this;
            this.$http.get('/api/get/categories').then(
                function(response) {
                    var jtmdsResponse = response.data;
                    if(jtmdsResponse.errorCode == 0) {
                        var categories = jtmdsResponse.content;
                        if(Array.isArray(categories)){
                            this.$set('categories', categories);
                        }
                    }
                    else {
                        console.log(jtmdsResponse.errorMessage);
                    }
                },
                function(response) {
                }
            )
        },

        showAddCategoryModal: function () {
            $('#addCategoryModal.small.modal').modal({
                closable  : true,
                inverted: true
            }).modal('show');
        },

        getArticleProperties: function () {
            if(!this.article_id) {
                return;
            }
            var self = this;
            this.$http.get('/api/get/properties?article_id='+self.article_id).then(
                function(response) {
                    var jtmdsResponse = response.data;
                    if(jtmdsResponse.errorCode == 0) {
                        var properties = jtmdsResponse.content;
                        console.log(properties);
                        if(Array.isArray(properties.tags)){
                            this.$set('article_tags', properties.tags);
                        }
                        if(Array.isArray(properties.categories)){
                            this.$set('article_categories', properties.categories);

                            var checked_categories = [];
                            properties.categories.forEach(function (category) {
                                checked_categories.push(category.id);
                            });
                            this.$set('article_category_ids', checked_categories);
                        }
                    }
                    else {
                        console.log(jtmdsResponse.errorMessage);
                    }
                },
                function(response) {
                }
            )
        },

        selectTag: function (tag) {
            if(!tag || !tag.id){
                return;
            }
            for(var i=0; i<this.article_tags.length; i++){
                if(tag.id == this.article_tags[i].id){
                    return;
                }
            }
            this.article_tags.push(tag);
        },
        addTags: function() {
            var self = this;
            var data = {
                _token: self.csrfToken,
                tag_names: self.tag_names
            };
            this.$http.post('/api/post/add-tags',data).then(
                function(response) {
                    var jtmdsResponse = response.data;
                    if(jtmdsResponse.errorCode == 0) {
                        var addedTags = jtmdsResponse.content;
                        if(Array.isArray(addedTags)){
                            //this.$set('categories', categories);
                            addedTags.forEach(function(addedTag){
                                for(var i=0; i<self.article_tags.length; i++){
                                    if(addedTag.id == self.article_tags[i].id){
                                        return;
                                    }
                                }
                                self.article_tags.push(addedTag);
                            })
                        }
                    }
                    else {
                        console.log(jtmdsResponse.errorMessage);
                    }
                },
                function(response) {
                    console.log(response);
                }
            )
        },

        deleteArticleTag: function (tag) {
            var self = this;
            for(var i=0; i<self.article_tags.length; i++){
                if(tag.id == self.article_tags[i].id){
                    self.article_tags.splice(i, 1);
                    return;
                }
            }
        }
    }
});