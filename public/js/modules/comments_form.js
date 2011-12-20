

// id: commentsForm
youSuck.modules.comments_form = function(id, post_id) {
    var comments_form = $('#'+id);
    var textarea, content, firstname, comments_list;
    
    bindUI = function() {
        comments_form.submit(function(e) {
            e.preventDefault();
            // post the content and post_id to the server
            // after getting the response from server
            // render the post item on the page
            
            textarea = $('#'+id+' textarea');
            content = $.trim(textarea.val());
            
            if(content!=='') {
                $.post('/post/postcomment', {
                    'content': content,
                    'post_id': post_id
                }, function(response) {
                    // render the post item
                    firstname = $.parseJSON(response).firstname;
                    youSuck.use('modules-comments_list', function(youSuck) {
                        comments_list = new youSuck.modules.comments_list('comments_list');
                        comments_list.append(firstname, content);
                    });
                });
            }
            
            
        });
    };
    
    this.render = function() {
        bindUI();
    };
    
};

