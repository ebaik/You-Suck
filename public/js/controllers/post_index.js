
youSuck.controllers.post_index = new function() {
    
    /**
     * redering the search box and complaints list
     */
    youSuck.use('modules-search_box', 'modules-complaints_list', function(youSuck) {
        
        var search_box_id = 'search_box';
        var search_box =  new youSuck.modules.search_box(search_box_id, youSuck.common.utils.getPageControllerObjectName());
        search_box.render();
        
        
    });
    /**
     * end redering the search box and complaints list
     */
    
    youSuck.use('modules-complaints_form', function(youSuck) {
        var id = 'complaints_form';
        var complaints_form = new youSuck.modules.complaints_form(id);
        complaints_form.render();
        
        
    });

};

