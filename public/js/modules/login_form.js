
// login module

youSuck.modules.login_form = function(id) {
       
    var substitute = youSuck.common.utils.substitute;
    var template, dataObj;
    var login_form=$('#'+id);
    var username=$('#'+id+' input[name="username"]');
    var password=$('#'+id+' input[name="password"]');
    var errorBox=$('#'+id+' .errorBox');
 
    this.render = function() {
        youSuck.use('templates-login_form', function(youSuck) {
            if(!login_form.html()) {
                
            } else {
                bindUI();
            }
        });
    };
    
    bindUI = function() {
        login_form.submit(function(e) {
            e.preventDefault();
            console.log('submit');
            console.log(username.val());
            console.log(password.val());
            if(username.val() && password.val()) {
                $.post('/login/auth', {
                    'username': username.val(),
                    'password': password.val()
                }, function(response) {
                    if(response==="1") {
                        window.location.href = '/';
                    } else {
                        errorBox.html('Authentication Failed!');
                    }

                });
            }
            
            
        });
    }
        
    
    
    
};
