app.controller('objectControlCtrl', ['objectControlService', '$scope', function(objectControlService, $scope) {
    var self = this;    
    
    self.save = function(){
		console.log(objectControlService.getControlMarker().position.lat());
    }
}]);    
