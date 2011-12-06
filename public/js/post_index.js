
youSuck.post_index = new function() {
    console.log('how are you');console.log(youSuck.map.complaints_form.path);
    $.getScript(youSuck.map.complaints_form.path, function(data, status) {console.log('after getting how are you');
        var id = 'complaints_form';
        var complaints_form = new youSuck.complaints_form_module(id);
        complaints_form.render();
        
        
    });

};

