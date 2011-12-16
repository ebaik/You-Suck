

// combo css loader
$.getCSS = function() {
    var i=0, size=arguments.length;
    var callback;
    var path = '';
    
    for(;i<size;i++) {
        if((typeof arguments[i])!=='function') {
            if(i==0) {
                path += arguments[i];
            } else {
                path += ';'+ arguments[i];
            }
        } else {
            callback = arguments[i];
        }console.log(path);
        if(path) {
            loadingURL = window.location.origin+'/'+'combo'+'?f='+path;
            $.get(loadingURL, function(data) {
                $("<style type=\"text/css\">" + data + "</style>").appendTo(document.head);
                callback(data, status);
            });
        }
    }
};

// create the map to the modules
var youSuck = {
    'map': {

        //lib
        'jquery.autocomplete': {
            'path': 'js/lib/jquery.autocomplete.js',
            'loaded': 0
        },
        'jquery.query': {
            'path': 'js/lib/jquery.query-2.1.7.js',
            'loaded': 0
        },
        'google.jsapi': {
            'path': 'js/lib/jsapi.js',
            'loaded': 0
        }, 
        // common
        'common-utils': {
            'path': 'js/common/utils.js',
            'loaded': 0
        },
        // controllers
        'controllers-index_index': {
            'path': 'js/controllers/index_index.js',
            'loaded': 0
        },
        'controllers-login_index': {
            'path': 'js/controllers/login_index.js',
            'loaded': 0
        },
        'controllers-post_index': {
            'path': 'js/controllers/post_index.js',
            'loaded': 0
        },
        'controllers-user_register': {
            'path': 'js/controllers/user_register.js',
            'loaded': 0
        },
        'controllers-post_show': {
            'path': 'js/controllers/post_show.js',
            'loaded': 0
        },
        'controllers-analytics_show': {
            'path': 'js/controllers/analytics_show.js',
            'loaded': 0
        },
        // UI modules
        'modules-search_box': {
            'path': 'js/modules/search_box.js',
            'loaded': 0
        },
        'modules-complaints_list': {
            'path': 'js/modules/complaints_list.js',
            'loaded': 0
        },
        'modules-complaints_form': {
            'path': 'js/modules/complaints_form.js',
            'loaded': 0
        },
        'modules-login_form': {
            'path': 'js/modules/login_form_module.js',
            'loaded': 0
        },
        'modules-register_form': {
            'path': 'js/modules/register_form_module.js',
            'loaded': 0
        },
        // templates
        'templates-search_box': {
            'path': 'js/templates/search_box.js',
            'loaded': 0
        },
        'templates-complaints_list': {
            'path': 'js/templates/complaints_list.js',
            'loaded': 0
        },
        'templates-complaints_form': {
            'path': 'js/templates/complaints_form.js',
            'loaded': 0
        },
        'templates-login_form': {
            'path': 'js/templates/login_form.js',
            'loaded': 0
        },
        'templates-register_form': {
            'path': 'js/templates/register_form.js',
            'loaded': 0
        }
    },
    'combo': window.location.origin+'/'+'combo',
    'common': {
        
    },
    'controllers': {
        
    },
    'modules': {
        
    },
    'templates': {
    },
    'use': function() {
        
        var i=0, size=arguments.length;
        var path = '';
        var callback = '';
        var loadingURL = '';
        var _this = this;

        var callback;
        

        for(;i<size;i++) {
            if((typeof arguments[i])!=='function') {
                if(!_this.map[arguments[i]].loaded) {
                    if(i == 0) {
                        path += _this.map[arguments[i]].path;
                    } else {
                        path += ';' + _this.map[arguments[i]].path;
                    }
                    _this.map[arguments[i]].loaded = 1;
                }
                    
            } else {
                callback = arguments[i];
            }
            
        }    
        console.log(path);
        if(path) {
            loadingURL = _this.combo+'?f='+path;
            $.getScript(loadingURL, function(data, status) {
                callback(_this);
            });
        }
        
    }
};

/*
 var stylesheet = "foo.css";
var callback = function(){
  alert("CSS is now included");
};

$.get(stylesheet, function(contents){
  $("<style type=\"text/css\">" + contents + "</style>").appendTo(document.head);
  callback();
});
 
 
 */

$(document).ready(function() {
    youSuck.use('common-utils', function(youSuck) {

        
        var pageControllerName = youSuck.common.utils.getPageControllerName();
console.log(pageControllerName);
        if(pageControllerName !== 'controllers-analytics_show') {
            youSuck.use(pageControllerName, function(youSuck) {


            });
        }
    });
});




