
youSuck.controllers.post_item = new function() {
    
    var comments_form;
    var post_id;
    
    youSuck.use('jquery.query', function() {
        post_id = $.query.get('id');
        
        // render the comments form
        youSuck.use('modules-comments_form', function(youSuck) {
            comments_form = new youSuck.modules.comments_form('commentsForm', post_id);
            comments_form.render();
        });
    });
};

