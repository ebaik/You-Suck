
youSuck.controllers.post_index = new function() {
    console.log('how are you');
    youSuck.use('modules-complaints_form', function(youSuck) {console.log('after getting how are you');
        var id = 'complaints_form';
        var complaints_form = new youSuck.modules.complaints_form(id);
        complaints_form.render();
        
        
    });

};

