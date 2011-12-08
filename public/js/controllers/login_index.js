
youSuck.controllers.login_index = new function() {
    
    youSuck.use('modules-login-form', function(youSuck) {
        var id = 'formLogin';
        var login_form = new youSuck.modules.login_form(id);

        login_form.render();
    });
    
    
}
