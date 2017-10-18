app.controller('placeControlCtrl', ['objectControlService', '$scope', function(objectControlService, $scope) {
    var self = this;    
    
    $scope.isNotificationError = false;
    $scope.isNotificationMsg   = false;
    $scope.notificationMsg     = '';
    
    self.save = function(){
        var controlMarker = objectControlService.getControlMarker();
        
        if(null==controlMarker){
            $scope.notificationMsg = 'Укажите место на карте!';
            $scope.isNotificationError = true;
            return false;
        }
        
        console.log(objectControlService.getControlMarker().position.lat());
        console.log(self.title);
    }
}]);    
