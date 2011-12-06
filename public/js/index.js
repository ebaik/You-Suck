

// create the map to the modules
var youSuck = {
    'map': {
        // utils
        'utils': {
            'path': 'js/utils.js'
        },
        // page controllers
        // index/index
        'index_index': {
            'path': 'js/index_index.js'
        },
        // UI modules
        'search_box': {
            'path': 'js/search_box_module.js'
        },
        'search_box_template': {
            'path': 'js/search_box_template.js'
        },
        'complaints_list': {
            'path': 'js/complaints_list_module.js'
        },
        'complaints_list_template': {
            'path': 'js/complaints_list_template.js'
        },
        'post_index': {
            'path': 'js/post_index.js' 
        },
        'complaints_form': {
            'path': 'js/complaints_form_module.js'
        },
        'complaints_form_template': {
            'path': 'js/complaints_form_template.js'
        },
        'login_index': {
            'path': 'js/login_index.js'
        },
        'login_form': {
            'path': 'js/login_form_module.js'
        },
        'login_form_template': {
            'path': 'js/login_form_template.js'
        },
        'user_register': {
            'path': 'js/user_register.js'
        },
        'register_form': {
            'path': 'js/register_form_module.js'
        },
        'register_form_template': {
            'path': 'js/register_form_template.js'
        }
    },
    'templates': {
    }
};

$(document).ready(function() {
    $.getScript(youSuck.map.utils.path, function(data, status) {
        var pageControllerName = youSuck.utils.getPageControllerName();
console.log(pageControllerName);
        $.getScript(youSuck.map[pageControllerName].path, function(data, status) {

        });

    });
});
