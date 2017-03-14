app.directive("myMap", ['objectControlService', function(objectControlService) {
    return {
    	restrict : "E",
    	scope: {
    		latitude: '@',
    		longitude: '@',
    		zoom: '@',
    		topIndent: '@'
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

    			self.test = function(){
                    console.log('mapCtrl test');
    			}
        },
        link: function(scope, element, attrs, mapCtrl)
        {
        	element.append('<div></div>');
        	var map_element = element.find('div');

			map_element.css('width', window.innerWidth+'px');
			map_element.css('height', (window.innerHeight-scope.topIndent)+'px');
			
			mapCtrl.map = new google.maps.Map(map_element[0], {
                center: {lat:+scope.latitude, lng:+scope.longitude},
                zoom: +scope.zoom
            }); 
            mapCtrl.markerInfoWindow = new google.maps.InfoWindow(); 
        }
    };
}]);
