app.controller('registerCtrl', ['authService', '$scope', function(authService, $scope) {
    var self = this;

    self.error = false;
    self.isRegistered = false;

    self.registerA = function(){
        authService.register(self.name, self.email, self.password, self.passwordConfirmation).then(function(data){
            self.error = false;
            self.isRegistered = true;
            console.log(data);
        }).catch(function(error){
            self.isRegistered = false;
            self.error = true;
            console.log(error);
        });
    };
}]);
