app.controller('objectControlCtrl', ['objectControlService', '$scope', function(objectControlService, $scope) {
    var self = this;
        
    var objectData = objectControlService.getTempObjectData();
        
    self.latitude  = objectData.lat;
    self.longitude = objectData.lng;     
}]);    
