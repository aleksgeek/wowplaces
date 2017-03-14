app.controller('registerApproveCtrl', ['authService', '$stateParams', function(authService, $stateParams) {
	var self = this;
	self.is_success = false;

	if(!!$stateParams.tmp_auth){
		authService.register_approve($stateParams.tmp_auth)
		.then(function(data){
			self.is_success = true;
			console.log('registration approve succesfull');
		}).catch(function(data){
			self.is_success = false;
			console.log('registration approve failed');
		});
	}
}]);