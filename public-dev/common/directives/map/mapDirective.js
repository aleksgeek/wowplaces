app.directive("myMap", ['objectControlService', function(objectControlService) {
    return {
        restrict : "E",
        scope: {
            latitude: '@',
            longitude: '@',
            zoom: '@',
            topIndent: '@',
            width: '@',
            height: '@'
        },
        controller: function($scope){
            var self = this;
                self.map = null;
                self.markers = [];

                self.addMarker = function(marker){
                    self.markers.push(marker);
                }

                self.showMarkerInfo = function(idObject){
                    $scope.$parent.$broadcast('showMarkerInfo', idObject);    
                }
                
                self.showMarkerControlData = function(marker){
                    objectControlService.addControlMarker(marker);
                }
        },
        compile: function compile(element, attrs, transclude) {
            return {
                pre: function preLink(scope, element, attrs, mapCtrl) {
                    element.append('<div></div>');
                    var map_element = element.find('div');
                    
                    var mode   = scope.mode   || 'show';
                    var width  = scope.width  || window.innerWidth;
                    var height = scope.height || window.innerHeight;   
                    var topIndent = scope.topIndent || 0;
                    
                    map_element.css('width', width+'px');
                    map_element.css('height', (height-topIndent)+'px');
                    
                    mapCtrl.map = new google.maps.Map(map_element[0], {
                        center: {lat:+scope.latitude, lng:+scope.longitude},
                        zoom: +scope.zoom
                    }); 
                    mapCtrl.markerInfoWindow = new google.maps.InfoWindow();                    
                }
            }
        },
        link: function(scope, element, attrs, mapCtrl)
        {

        }
    };
}]);
