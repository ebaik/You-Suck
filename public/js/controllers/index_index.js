
// index/index page controller

youSuck.controllers.index_index = new function() {
    /**
     * redering the search box and complaints list
     */
    youSuck.use('modules-search_box', 'modules-complaints_list', function(youSuck) {
        
        var search_box_id = 'search_box';
        var search_box =  new youSuck.modules.search_box(search_box_id, youSuck.common.utils.getPageControllerObjectName());
        search_box.render();
        
        var complaints_list_id = 'complaints_list';
        var complaints_list = new youSuck.modules.complaints_list(complaints_list_id);

        complaints_list.render();
<<<<<<< HEAD
=======

        // display the search results on the page
        
        
        
        
        
        
        
        
>>>>>>> ab7470b7797882bb0f6515f1541e62ec68d3a2d8
        
    });
    /**
     * end redering the search box and complaints list
     */
    
    
    
};




