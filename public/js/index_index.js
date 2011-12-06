
// index/index page controller

youSuck.index_index = new function() {
    $.getScript(youSuck.map.search_box.path, function(data, status) {
        var search_box_id = 'search_box';
        // display the search results on the page
        var searchDoneCallback = function(results) {
            console.log(results);
            
            $.getScript(youSuck.map.complaints_list.path, function(data, status) {
                var complaints_list = new youSuck.complaints_list_module('complaints_list');
                complaints_list.render(results);console.log('ajsflasj');
            });
            
        };
        
        var search_box_module =  new youSuck.search_box_module(search_box_id, searchDoneCallback);
        
        search_box_module.render();
        
        // the complaints list should have been rendered since the document is ready now
        // we can now check the height of the post text to decide whether or not 
        // we should show the read more link
        
        $('div.recentComplaints').each(function(id) {
            
            if($(this).height()>120) {
                var readMore = $(this).find('p.read-more');
                readMore.show();
            }
        }); 
        
        
    });
};




