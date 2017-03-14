app.controller('objectsCtrl', ['$scope', 'objectControlService', function($scope, objectControlService) {
	var self = this;
 		self.markers = [];

	objectControlService.getAllObjects().then(function(all_objects){
	    self.markers = all_objects;
	}).catch(function(error) {
		console.error(error);    
	});

	self.test = function(){
    	console.log('main mapCtrl test');
    };

}]);
