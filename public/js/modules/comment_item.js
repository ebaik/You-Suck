

youSuck.modules.comment_item = function(firstname, content, created) {
    var substitute = youSuck.common.utils.substitute;
    var template;
    var html='';
    
    var init = function() {
        template = youSuck.templates.comment_item;
        html = substitute(template, {
            'firstname': firstname,
            'content': content,
            'created': created?created:'0000-00-00 00:00:00'
        });
    };
    
    this.getHTML = function() {
        return html;
    };
    
    init();
};
