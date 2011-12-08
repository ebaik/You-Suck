
// login module

youSuck.modules.login_form = function(id) {
    
    var substitute = youSuck.common.utils.substitute;
    var template, dataObj;
    var login_form=$('#'+id);
    
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
