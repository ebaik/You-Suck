

youSuck.search_box_module = function(id, searchDoneCallback) {
    var substitute = youSuck.utils.substitute;
    var template, dataObj={};
    var html = '';
    var input_box, search_button;
    
    this.render = function() {
        if(!$('#'+id).html()) {
            $.getScript(youSuck.map.search_box_template.path, function(data, status) {
                template = youSuck.templates.search_box;
                html = substitute(template, dataObj);
                $('#'+id).html(html);
                input_box = $('#'+id+' input');
                search_button = $('#'+id+' a');
                bindUI();
            });
        } else {
            input_box = $('#'+id+' input');
            search_button = $('#'+id+' a');
            bindUI();
        }
        
    };
    
    bindUI = function() {
        input_box.keypress(function(e){
            if(e.which == 13){
                e.preventDefault();
                getSearchResults(searchDoneCallback);
            }
        });
        
        search_button.click(function(e) {
            e.preventDefault();
            getSearchResults(searchDoneCallback);
        });
    };
    
    getSearchResults = function(searchDoneCallback) {
        var query = input_box.val();   
        /*
         * $complaints = array(
                array('fullname'=>'liang huang', 'text'=>'delta really really sucks', 'post_time'=>'2011-11-16'),
                array('fullname'=>'jason qing', 'text'=>'delta really really sucks', 'post_time'=>'2011-11-29')
            );
         * 
         * [{"fullname":"liang huang","text":"delta really really sucks","post_time":"2011-11-16"},{"fullname":"jason qing","text":"delta really really sucks","post_time":"2011-11-29"}]
         */
        //var mockResponse = '[{"fullname":"liang huang","text":"delta really really sucks","post_time":"2011-11-16"},{"fullname":"jason qing","text":"delta really really sucks","post_time":"2011-11-29"}]';
        
        //var mockResults = $.parseJSON(mockResponse);
        
        $.getJSON('post/search?query='+query, function(data) {
            searchDoneCallback(data);
        });
    }
    
    
    
    
};
