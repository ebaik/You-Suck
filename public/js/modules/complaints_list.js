
youSuck.modules.complaints_list = function(id, params) {
    
    var substitute = youSuck.common.utils.substitute;
    var complaints_list = $('#'+id);
    
    var template;
    var _this = this;
    
    bindUI = function() {
//        var read_more = $('p.read-more');
//        read_more.click(function(e) {
//            e.preventDefault();
//            $($(this).parent().children()[0]).css({
//                'max-height': 9999
//            });
//            
//        });
        
        $('.moreposts').click(function(e) {
            var offset = $('div.recentComplaints').size();
            
            if(params && params.query) {
                var query = params.query;
                $.getJSON('/post/search?query='+query+'&offset='+offset, function(data) {
                    _this.render(data);
                });
            } else {
                $.getJSON('/index/moreposts?&offset='+offset, function(data) {
                    _this.render(data);
                });
            }
            
            
        });
    };
    
     _this.render = function(dataObj) {
        if(dataObj) {
            youSuck.use('templates-complaints_list', function(youSuck) {
                template = youSuck.templates.complaints_list;

                var html = substitute(template, {'search_results': dataObj, 'show_view_more': dataObj.length?true:false});
                $('#'+id+' .moreposts').remove();
                $('#'+id).append(html);
                bindUI();
                // show the readmore 
//                if($('div.recentComplaints')) {
//                    $('div.recentComplaints').each(function(id) {
//
//                        if($(this).height()>110) {
//                            var readMore = $(this).find('p.read-more');
//                            readMore.show();
//                            bindUI();
//                        }
//                    });
//                }
                
            });
        } else {
            if($('div.recentComplaints')) {
//                $('div.recentComplaints').each(function(id) {
//
//                    if($(this).height()>110) {
//                        var readMore = $(this).find('p.read-more');
//                        readMore.show();
//                    }
//                });

                bindUI();
            }
        }
        
        
        
    };
    
    init = function() {
        if($('div.recentComplaints')) {
            $('div.recentComplaints').each(function(id) {
            
                if($(this).height()>110) {
                    var readMore = $(this).find('p.read-more');
                    readMore.show();
                }
            });
        }
        
        
        _this.render();
    };
    
    //init();
    
   
    
    
    
};