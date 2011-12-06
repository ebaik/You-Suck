

youSuck.complaints_form_module = function(id) {

    var substitute = youSuck.utils.substitute;
    var template, dataObj;
    var html = '';
   
    this.render = function() {
        if(!$('#'+id).html()) {
            $.getScript(youSuck.map.complaints_form_template.path, function(data, status) {
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
            
            var data = {
                'company_name': company, 
                'synopsys': synopsys
            };
            
            $.post('post/submit', data, function(response) {
                console.log('hellohello');
                $(location).attr('href',window.location.origin);
            });
            
        });
    }
    
    
}



