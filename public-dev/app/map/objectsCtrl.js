app.controller('objectsCtrl', ['$scope', 'objectControlService', function($scope, objectControlService) {
	var self = this;
 		self.markers = [];

	objectControlService.getAllObjects().then(function(allObjects){
	    self.markers = allObjects;
	}).catch(function(error) {
		console.error(error);    
	});

	self.test = function(){
    	console.log('main mapCtrl test');
    };

}]);
