
youSuck.common.utils = {
    getPageControllerName: function() {
        var path = window.location.pathname;
        var parts = path.split('/');
        var controller = 'index', action = 'index';
        if(parts[1]) controller = parts[1];
        if(parts[2]) action = parts[2];
        var pageControllerName = 'controllers-'+controller+'_'+action;
        return pageControllerName;
    },
    substitute: function(template, dataObj) {
        return Mustache.to_html(template, dataObj);
    }
};

