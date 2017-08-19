app.controller('authCtrl', ['authService', function(authService) {
	var self = this;

    self.is_logined  = authService.isLogined(); 
    self.user_data   = authService.getAuthUser();
    self.login_error = false;
    self.open_form   = false;

    self.authenticate = function(){
        authService.login(self.email, self.password)
        .then(function(data){
            self.is_logined = authService.isLogined();  
            self.user_data  = authService.getAuthUser();
            self.toggle_form();                            
        }).catch(function(data){
            self.login_error = true;
        });
    };

    self.logout = function(){
		authService.logout();
        self.is_logined = authService.isLogined(); 
        self.toggle_form();
    };

    self.toggle_form = function(){
        self.open_form = !self.open_form;
    }

}]);
