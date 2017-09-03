app.directive("myMarkerControl", ['objectControlService', '$compile', function(objectControlService, $compile) {
    return {
        require: '^myMap',
    	restrict : "E",
        link: function(scope, element, attrs, mapCtrl)
        {
			var marker = null;
			
			console.log(mapCtrl);
			/*
			mapCtrl.map.addListener('rightclick', function(e){ 
				if(null==marker){
					marker = new google.maps.Marker({
						position: {lat:+e.latLng.lat(), lng:+e.latLng.lng()},
						animation: google.maps.Animation.DROP,
						title: 'new object'
					});
					marker.setMap(mapCtrl.map);
					mapCtrl.addMarker(marker);
				}
			});	    
			
            marker.addListener('click', function(){ 
    		});
            */
            
            scope.$on('$destroy', function(){
                console.log('destroy');      
            });       
        }
    };
}]);
