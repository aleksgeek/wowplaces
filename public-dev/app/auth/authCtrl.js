app.controller('authCtrl', ['authService', function(authService) {
    var self = this;

    self.isLogined  = authService.isLogined(); 
    self.userData   = authService.getAuthUser();
    self.loginError = false;
    self.openForm   = false;

    self.authenticate = function(){
        authService.login(self.email, self.password)
        .then(function(data){
            self.isLogined = authService.isLogined();  
            self.userData  = authService.getAuthUser();
            self.toggleForm();                            
        }).catch(function(data){
            self.loginError = true;
        });
    };

    self.logout = function(){
        authService.logout();
        self.isLogined = authService.isLogined(); 
        self.toggleForm();
    };

    self.toggleForm = function(){
        self.openForm = !self.openForm;
    }

}]);
