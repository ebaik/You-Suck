
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
    getPageControllerObjectName: function() {
        var path = window.location.pathname;
        var parts = path.split('/');
        var controller = 'index', action = 'index';
        if(parts[1]) controller = parts[1];
        if(parts[2]) action = parts[2];
        var pageControllerObjectName = controller+'_'+action;
        return pageControllerObjectName;
    },
    substitute: function(template, dataObj) {
        return Mustache.to_html(template, dataObj);
    },
    setCookie: function(name,value,days) {
        if (days) {
            var date = new Date();
            date.setTime(date.getTime()+(days*24*60*60*1000));
            var expires = "; expires="+date.toGMTString();
        }
        else var expires = "";
        document.cookie = name+"="+value+expires+"; path=/";
    },
    getCookie: function (name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    },
    deleteCookie: function (name) {
        setCookie(name,"",-1);
    }
};

