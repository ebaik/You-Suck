

youSuck.modules.register_form = function(id) {
    var register_form = $('#'+id);
    var error_box = $('#'+id+' .errorBox');
    var input_first_name = $('#'+id+' input[name="first_name"]');
    var input_email = $('#'+id+' input[name="email"]');
    var input_password = $('#'+id+' input[name="password"]');
    var input_submit = $('#'+id+' input[type="submit"]');
    var first_name, email, password, data;
    
    this.render = function() {
        bindUI();
    };
    bindUI = function() {
        register_form.submit(function(e) {
            e.preventDefault();
            first_name = $.trim(input_first_name.val());
            email = $.trim(input_email.val());
            password = $.trim(input_password.val());
            
            // validate fields
            if(first_name==='' || email === '' || password === '') {
                error_box.html('Info incomplete');
            } else {
                data = {
                    'email': email
                };
                $.post('/user/emailregistered', data, function(response) {
                    if(response ===  '1') {
                        error_box.html('Email has been registered');
                    } else {
                        // start registration
                        data = {
                            'first_name': first_name,
                            'email': email,
                            'password': password
                        };
                        $.post('/user/create', data, function(response) {
                            window.location.href = 'http://'+window.location.host;
                        });
                    }
                });
            }
            
            
        });
    };
    
    
};

