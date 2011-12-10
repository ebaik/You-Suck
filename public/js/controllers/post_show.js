

youSuck.controllers.post_show = new function() {
    youSuck.use('jquery.query', function(youSuck) {
        var query = $.query.get('query');
        var complaints_list;
        var complaints_list_id = 'complaints_list';
        var complaints_list;
        
        $.getJSON('/post/search?query='+query, function(data) {
            youSuck.use('modules-complaints_list', function(youSuck) {
                complaints_list = new youSuck.modules.complaints_list(complaints_list_id)
                complaints_list.render(data);
            });
        });
    });
};
