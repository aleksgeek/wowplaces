app.directive("myMarker", ['objectControlService', '$compile', function(objectControlService, $compile) {
    return {
        require: '^myMap',
    	restrict : "E",
    	scope: {
    		latitude: '@',
    		longitude: '@',
    		idObject: '@',
    		briefInfo: '@'
    	},
        link: function(scope, element, attrs, mapCtrl)
        {
            var marker = new google.maps.Marker({
                position: {lat:+scope.latitude, lng:+scope.longitude},
                animation: google.maps.Animation.DROP,
                title: scope.id_object
            });

            marker.addListener('rightclick', function(){                
                objectControlService.getObjectData(scope.idObject).then(function(data){  
                    var infoText = `
                        <my-marker-context
                            description  = `+data.brief_description+`
                            rating-good  = `+data.rating_good+`
                            rating-bad   = `+data.rating_bad+`
                            type-info    = `+scope.briefInfo+`
                        > 
                        </my-marker-context>  
                    `;
                        
                    var infoLink = $compile(infoText);
                    var infoDirective = infoLink(scope);
                    mapCtrl.markerInfoWindow.setContent(infoDirective[0]);
                    mapCtrl.markerInfoWindow.open(mapCtrl.map, marker);
                }).catch(function(error) {
                    console.error(error);    
                });                 
            });    

            marker.addListener('click', function(){ 
                mapCtrl.showMarkerInfo(scope.idObject);
    		});
            marker.setMap(mapCtrl.map);
            mapCtrl.addMarker(marker);
            
            scope.$on('$destroy', function(){
                console.log('destroy');      
            });       
        }
    };
}]);
