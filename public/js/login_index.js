
youSuck.login_index = new function() {
    
    $.getScript(youSuck.map.login_form.path, function(data, status) {
        var id = 'formLogin';
        var login_form_module = new youSuck.login_form_module(id);

        login_form_module.render();
    });
    
    
}
