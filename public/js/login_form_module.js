
// login module

youSuck.login_form_module = function(id) {
    
    var substitute = youSuck.utils.substitute;
    var template, dataObj;
    var login_form=$('#'+id);
    
    this.render = function() {
        $.getScript(youSuck.map.login_form_template.path, function(data, status) {
            if(!login_form.html()) {
                
            } else {
                bindUI();
            }
        });
    };
    
    bindUI = function() {
        login_form.submit(function(e) {
            //e.preventDefault();
            console.log('submit');
            
//            $.post('login', {
//                'username': 'testuser',
//                'password': '123456'
//            }, function(response) {
//                console.log(response);
//                
//            });
            
        });
    }
        
    
    
    
};
