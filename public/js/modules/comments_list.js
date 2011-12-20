


// id: comments_list
youSuck.modules.comments_list = function(id) {
    var comments_list = $('#'+id);
    var items = $('#'+id+' userComment');
    
    this.append = function(firstname, content) {
        youSuck.use('modules-comment_item', 'templates-comment_item', function(youSuck) {
            var newitem = new youSuck.modules.comment_item(firstname, content);
            comments_list.append(newitem.getHTML());
        });
    };
    
    
};
