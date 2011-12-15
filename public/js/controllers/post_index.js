
youSuck.controllers.post_index = new function() {
    
    /**
     * redering the search box and complaints list
     */
    youSuck.use('modules-search_box', 'modules-complaints_list', function(youSuck) {
        
        var search_box_id = 'search_box';
        var search_box =  new youSuck.modules.search_box(search_box_id);
        search_box.render();
        
        var complaints_list_id = 'complaints_list';
        var complaints_list = new youSuck.modules.complaints_list(complaints_list_id);
        complaints_list.render();
        
    });
    /**
     * end redering the search box and complaints list
     */
    
    youSuck.use('modules-complaints_form', function(youSuck) {console.log('after getting how are you');
        var id = 'complaints_form';
        var complaints_form = new youSuck.modules.complaints_form(id);
        complaints_form.render();
        
        
    });

};

