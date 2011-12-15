
youSuck.controllers.login_default = new function() {
    window.fbAsyncInit = function() {
        FB.init({
        appId      : '259986717389518',
        status     : true, 
        cookie     : true,
        xfbml      : true
        });
        /* All the events registered */
        FB.Event.subscribe('auth.login', function(response) {
            console.log('auth.login', response);
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
         console.log('auth.logout', response);
         // do something with response
         //logout();
        });

        FB.getLoginStatus(function(response) {
         console.log('getLoginStatus', response);
         if (response.session) {
             // logged in and connected user, someone you know
             //login();
         }
        });
        FB.api('/me', function(user) {
         console.log('/me', user);
        //            if (user) {
        //              var image = document.getElementById('image');
        //              image.src = 'http://graph.facebook.com/' + user.id + '/picture';
        //              var name = document.getElementById('name');
        //              name.innerHTML = user.name
        //            }
        });
    };
    
    (function(d){
       var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
       js = d.createElement('script'); js.id = id; js.async = true;
       js.src = "//connect.facebook.net/en_US/all.js";
       d.getElementsByTagName('head')[0].appendChild(js);
     }(document));
     
     
     // regular login
     
     youSuck.use('modules-login_form', function(youSuck) {console.log('modules-login_form');
        var id = 'formLogin';
        var login_form = new youSuck.modules.login_form(id);

        login_form.render();
    });
     
};