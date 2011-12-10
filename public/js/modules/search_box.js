

youSuck.modules.search_box = function(id, searchDoneCallback) {
    var substitute = youSuck.common.utils.substitute;
    var template, dataObj={};
    var html = '';
    var input_box, search_button, search_form;
    
    this.render = function() {
        search_form = $('#'+id);
        if(!search_form.html()) {
            youSuck.use('templates-search_box', function(data, status) {
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
//        input_box.keypress(function(e){
//            if(e.which == 13){
//                getSearchResults(searchDoneCallback);
//            }
//        });
        var redirect_search = function() {
            var query = input_box.val();
            if(query) {
                window.location.href = window.location.href+"post/show?query="+query;
            }
        };
        search_form.submit(function(e) {
            e.preventDefault();
            redirect_search();
        });
        
        search_button.click(function(e) {
            redirect_search();
            //getSearchResults(searchDoneCallback);
        });
        
        // load the autocomplete jquery plugin
        
        
        youSuck.use('jquery.autocomplete', function(youSuck) {
            
            var selectItem = function(li) {
                console.log('***selectItem', li);
            };
    
            var findValue = function(li) {
                console.log('***findValue', li);
            };
    
            var formatItem = function(row) {
                return row;
            };
            
            // load the autocomplete css
            $.getCSS('css/jquery.autocomplete.css', function(data) {
                $("#search_box input").autocomplete("company/suggest", {
                    delay:10,
                    minChars:2,
                    matchSubset:1,
                    matchContains:1,
                    cacheLength:10,
                    onItemSelect:selectItem,
                    onFindValue:findValue,
                    formatItem:formatItem,
                    autoFill:true
                });
            });
            
            
            
            
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
