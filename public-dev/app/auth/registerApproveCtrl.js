app.controller('registerApproveCtrl', ['authService', '$stateParams', function(authService, $stateParams) {
    var self = this;
    self.isSuccess = false;

    if(!!$stateParams.tmp_auth){
        authService.registerApprove($stateParams.tmpAuth)
        .then(function(data){
            self.isSuccess = true;
            console.log('registration approve succesfull');
        }).catch(function(data){
            self.isSuccess = false;
            console.log('registration approve failed');
        });
    }
}]);
