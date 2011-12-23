

youSuck.controllers.post_show = new function() {
    
    youSuck.use('jquery.query', function(youSuck) {
        var query = $.query.get('query');
        var complaints_list;
        var complaints_list_id = 'complaints_list';
        var complaints_list;
        var search_box_id = 'search_box';
        var renderComplaintsList = function(query) {console.log('renderComplaintsList', query);
            $.getJSON('/post/search?query='+query, function(data) {
                    complaints_list = new youSuck.modules.complaints_list(complaints_list_id);
                    complaints_list.render(data);
            });
        };
        
        
        youSuck.use('modules-complaints_list', 'modules-search_box', function(youSuck) {
            var search_box =  new youSuck.modules.search_box(search_box_id, youSuck.common.utils.getPageControllerObjectName(), renderComplaintsList);
            renderComplaintsList(query);
            search_box.render();
        });
        
        
        
        
        
        /**
     * redering the search box and complaints list
     */
//    youSuck.use('modules-search_box', 'modules-complaints_list', function(youSuck) {
//        
//        var search_box_id = 'search_box';
//        var search_box =  new youSuck.modules.search_box(search_box_id);
//        search_box.render();
//        
//        var complaints_list_id = 'complaints_list';
//        var complaints_list = new youSuck.modules.complaints_list(complaints_list_id);
//        complaints_list.render();
//        
//    });
    /**
     * end redering the search box and complaints list
     */
        
        
    });
};
