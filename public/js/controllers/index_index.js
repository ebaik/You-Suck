
// index/index page controller

youSuck.controllers.index_index = new function() {
    
    var complaints_list;
    
    youSuck.use('modules-search_box', 'modules-complaints_list', function(youSuck) {
        
        var searchDoneCallback = function(results) {
            console.log(results);
            complaints_list.render(results);console.log('ajsflasj');
        };
        
        var search_box_id = 'search_box';
        var search_box =  new youSuck.modules.search_box(search_box_id, searchDoneCallback);
        search_box.render();
        
        var complaints_list_id = 'complaints_list';
        var complaints_list = new youSuck.modules.complaints_list(complaints_list_id);
        complaints_list.render();
        // display the search results on the page
        
        
        
        
        
        
        
        
        
    });
};




