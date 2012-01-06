

youSuck.modules.complaints_form = function(id) {

    var utils = youSuck.common.utils;
    var substitute = utils.substitute;
    var template, dataObj;
    var html = '';
    var getCookie = utils.getCookie;
   
    this.render = function() {
        if(!$('#'+id).html()) {
            youSuck.use('templates-complaints_form', function(youSuck) {
                template = youSuck.templates.complaints_form;
                html = substitute(template, dataObj);
                $('#'+id).html(html);

                bindUI();
            }); 
        } else {
            bindUI();
        }
        
        
    };
    
    bindUI = function() {
        $('#'+id).submit(function(e) {
            e.preventDefault();
            // form post
            //console.log('posted');
            
            var input_company = $('input[name="company"]');
            var company = input_company.val();
            var textarea_synopsys = $('#'+id+' textarea');
            var synopsys = textarea_synopsys.val();
            var input_name = $('#'+id+' input[name="name"]');
            var name = input_name.length?input_name.val():'';
            var input_email = $('#'+id+' input[name="email"]');
            var email = input_email.length?input_email.val():'';
            var input_check_anonymous = $('#'+id+' input[name="make_anonymos"]');
            var check_anonymous = input_check_anonymous.length?input_check_anonymous.attr('checked'):undefined;
            check_anonymous = check_anonymous?1:0;
//            console.log('#'+id+' input[name="name"]');
//            console.log('#'+id+' input[name="email"]');
//            console.log('#'+id+' input[name="make_anonymos"]');
//            console.log('name:',name );
//            console.log('email:', email);
//            console.log('check_anonymous', check_anonymous);
            // on the client side, we only submit the form data
            // the server side will check the credential of the user
            // and decide whehter to store it as an anonymous post or not
            // it is not reliable to pass the user id and firstname in the
            // cookie to the server
            var data = {
                'company_name': company, 
                'synopsys': synopsys,
                'name': name,
                'email': email,
                'check_anonymous': check_anonymous
            };
            
            $.post('/post/submit', data, function(response) {
                if(response!=='0') {
                    window.location.href = 'http://'+window.location.host;
                }
                
            });
            
        });
    }
    
    
}



