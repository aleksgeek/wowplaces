app.directive("myMarkerControl", ['$compile', function($compile) {
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
                mapCtrl.showMarkerControlData(marker);                                   
            });     
            
            scope.$on('$destroy', function(){
                console.log('destroy myMarkerControl');      
            });       
        }
    };
}]);
