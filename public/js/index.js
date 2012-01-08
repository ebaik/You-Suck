

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
        }
        if(path) {
            loadingURL = 'http://'+window.location.host+'/'+'combo'+'?f='+path;
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
        'controllers-login_default': {
            'path': 'js/controllers/login_default.js',
            'loaded': 0
        },
        'controllers-post_item': {
            'path': 'js/controllers/post_item.js',
            'loaded': 0
        },
        'controllers-index_about': {
            'path': 'js/controllers/index_about.js',
            'loaded': 0
        },
        'controllers-index_help': {
            'path': 'js/controllers/index_help.js',
            'loaded': 0
        },
        'controllers-index_terms': {
            'path': 'js/controllers/index_terms.js',
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
            'path': 'js/modules/login_form.js',
            'loaded': 0
        },
        'modules-register_form': {
            'path': 'js/modules/register_form.js',
            'loaded': 0
        },
        'modules-comment_item': {
            'path': 'js/modules/comment_item.js',
            'loaded': 0
        },
        'modules-comments_list': {
            'path': 'js/modules/comments_list.js',
            'loaded': 0
        },
        'modules-comments_form': {
            'path': 'js/modules/comments_form.js',
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
        },
        'templates-comment_item': {
            'path': 'js/templates/comment_item.js',
            'loaded': 0
        },
        'templates-comments_list': {
            'path': 'js/templates/comments_list.js',
            'loaded': 0
        }
    },
    'combo': 'http://'+window.location.host+'/'+'combo',
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
        var modules = [];
        
        for(;i<size;i++) {
            if((typeof arguments[i])!=='function') {
                if(!_this.map[arguments[i]].loaded) {
                    if(i == 0) {
                        path += _this.map[arguments[i]].path;
                    } else {
                        path += ';' + _this.map[arguments[i]].path;
                    }
                    modules.push(_this.map[arguments[i]]);
                }
                    
            } else {
                callback = arguments[i];
            }

        }
        if(path) {
            loadingURL = _this.combo+'?f='+path;
            $.getScript(loadingURL, function(data, status) {
                //console.log('finish loading '+loadingURL);
                var j=0, size2=modules.length;
                for(;j<size2;j++) {
                    modules[j].loaded=1;
                }
                callback(_this);
            });
        } else {
            //console.log('no need to download but directly make the callback');
            callback(_this);
        }
        
    }
};

$(document).ready(function() {
    youSuck.use('common-utils', function(youSuck) {
       
        var pageControllerName = youSuck.common.utils.getPageControllerName();
        if(pageControllerName !== 'controllers-analytics_show') {
            youSuck.use(pageControllerName, function(youSuck) {

            });
        }
    });
});




