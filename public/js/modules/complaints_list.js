
youSuck.modules.complaints_list = function(id) {
    
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
    };
    
     _this.render = function(dataObj) {
        if(dataObj) {
            youSuck.use('templates-complaints_list', function(youSuck) {
                template = youSuck.templates.complaints_list;

                var html = substitute(template, {'search_results': dataObj});
                $('#'+id).html(html);
                // show the readmore 
                if($('div.recentComplaints')) {
                    $('div.recentComplaints').each(function(id) {

                        if($(this).height()>110) {
                            var readMore = $(this).find('p.read-more');
                            readMore.show();
                            bindUI();
                        }
                    });
                }
                
            });
        } else {
            if($('div.recentComplaints')) {
                $('div.recentComplaints').each(function(id) {

                    if($(this).height()>110) {
                        var readMore = $(this).find('p.read-more');
                        readMore.show();
                    }
                });
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