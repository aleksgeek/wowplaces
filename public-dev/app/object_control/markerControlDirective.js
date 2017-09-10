app.directive("myMarkerControl", ['objectControlService', '$compile', function(objectControlService, $compile) {
    return {
        require: '^myMap',
        restrict : "E",
        link: function(scope, element, attrs, mapCtrl)
        {
            var marker = null;
            
            mapCtrl.map.addListener('click', function(e){ 
                if(marker){
                    marker.setMap(null);
                }

                marker = new google.maps.Marker({
                    position: {lat:+e.latLng.lat(), lng:+e.latLng.lng()},
                    animation: google.maps.DROP,
                    title: 'new object'
                });
                marker.setMap(mapCtrl.map);
                mapCtrl.addMarker(marker);
                
                objectControlService.setTempLatLng(e.latLng.lat(), e.latLng.lng());                        
            });     
            
            scope.$on('$destroy', function(){
                console.log('destroy myMarkerControl');      
            });       
        }
    };
}]);
