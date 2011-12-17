

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
            console.log('posted');
            
            var input_company = $('input[name="company"]');
            var company = input_company.val();
            var textarea_synopsys = $('#'+id+' textarea');
            var synopsys = textarea_synopsys.val();
            console.log(company);
            console.log(synopsys);
            
            // on the client side, we only submit the form data
            // the server side will check the credential of the user
            // and decide whehter to store it as an anonymous post or not
            // it is not reliable to pass the user id and firstname in the
            // cookie to the server
            var data = {
                'company_name': company, 
                'synopsys': synopsys
            };
            
            $.post('post/submit', data, function(response) {
                $(location).attr('href','http://'+window.location.host);
            });
            
        });
    }
    
    
}



