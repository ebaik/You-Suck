
youSuck.complaints_list_module = function(id) {
    
    var substitute = youSuck.utils.substitute;
    var complaints_list = $('#'+id);
    
    var template;
    
    
    this.render = function(dataObj) {
        $.getScript(youSuck.map.complaints_list_template.path, function(data, status) {
            template = youSuck.templates.complaints_list;

            html = substitute(template, {'search_results': dataObj});
            $('#'+id).html(html);
            $('div.grid_12').slideUp();
        });
    };
};