
youSuck.controllers.user_register = new function() {
    window.fbAsyncInit = function() {
        FB.init({
        appId      : '259986717389518',
        status     : true, 
        cookie     : true,
        xfbml      : true
        });
        /* All the events registered */
        FB.Event.subscribe('auth.login', function(response) {
            //console.log('auth.login', response);
            // pass the access token to the server
            var access_token = response.authResponse.accessToken;
            if(access_token) {
                $.post('/login/auth', {
                    'access_token': access_token
                }, function(auth) {
                    if(auth==="1") {
                        window.location.href = '/';
                    }

                });
            }
            
        });
        FB.Event.subscribe('auth.logout', function(response) {
         //console.log('auth.logout', response);
         // do something with response
         //logout();
        });

        FB.getLoginStatus(function(response) {
         //console.log('getLoginStatus', response);
         if (response.session) {
             // logged in and connected user, someone you know
             //login();
         }
        });
        FB.api('/me', function(user) {
         //console.log('/me', user);
        //            if (user) {
        //              var image = document.getElementById('image');
        //              image.src = 'http://graph.facebook.com/' + user.id + '/picture';
        //              var name = document.getElementById('name');
        //              name.innerHTML = user.name
        //            }
        });
    };
    
    (function(d){
       var js, id = 'facebook-jssdk';if (d.getElementById(id)) {return;}
       js = d.createElement('script');js.id = id;js.async = true;
       js.src = "//connect.facebook.net/en_US/all.js";
       d.getElementsByTagName('head')[0].appendChild(js);
     }(document));

     // render the register form
     
     youSuck.use('modules-register_form', function(youSuck) {
         //console.log('register form loaded');
         
         var register_form = new youSuck.modules.register_form('formLogin');
         
         register_form.render();
         
     });
     
     /**
     * redering the search box and complaints list
     */
    youSuck.use('modules-search_box', 'modules-complaints_list', function(youSuck) {
        
        var search_box_id = 'search_box';
        var search_box =  new youSuck.modules.search_box(search_box_id, youSuck.common.utils.getPageControllerObjectName());
        search_box.render();
        
        var complaints_list_id = 'complaints_list';
        var complaints_list = new youSuck.modules.complaints_list(complaints_list_id);
        complaints_list.render();
        
    });
    /**
     * end redering the search box and complaints list
     */
     
};

