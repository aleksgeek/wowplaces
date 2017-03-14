app.controller('registerCtrl', ['authService', '$scope', function(authService, $scope) {
	var self = this;

	self.error = false;
	self.is_registered = false;

	self.register_a = function(){
		authService.register(self.login_name, self.email, self.password, self.password_confirmation).then(function(data){
			self.error = false;
			self.is_registered = true;
			console.log(data);
		}).catch(function(error){
			self.is_registered = false;
			self.error = true;
			console.log(error);
		});
	};
}]);