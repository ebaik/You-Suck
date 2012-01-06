

// if controller is post_show, then
// search_box renders results directly
// on the /post/show page instead of 
// redirecting to the /post/show page
youSuck.modules.search_box = function(id, controller, renderComplaintsList) {
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
        
        var redirect_search = function(query) {
            if(query) {
                window.location.href = 'http://'+window.location.host+"/post/show?query="+query;
            }
        };
        search_form.submit(function(e) {
            var query = input_box.val();
            e.preventDefault();
            if(controller !== 'post_show') {
                redirect_search(query);
            } else {
                renderComplaintsList(query);
            }
            
        });
        
        search_button.click(function(e) {
            var query = input_box.val();
            if(controller !== 'post_show') {
                redirect_search(query);
            } else {
                renderComplaintsList(query);
            }
        });
        
        // load the autocomplete jquery plugin
        
        
        youSuck.use('jquery.autocomplete', function(youSuck) {
            
            var selectItem = function(li) {
                //console.log('***selectItem', li);
            };
    
            var findValue = function(li) {
                //console.log('***findValue', li);
            };
    
            var formatItem = function(row) {
                return row;
            };
            
            // load the autocomplete css
            $.getCSS('css/jquery.autocomplete.css', function(data) {
                $("#search_box input").autocomplete("/company/suggest", {
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
};
