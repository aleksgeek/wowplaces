app.service('objectControlService', ['$q', '$http', 'config', function($q, $http, config){
    var self = this;
        
        self.tempObjectData = {
            lat:null,
            lng:null
        }
        
    var url_get_objects = config.api_url+'/objects';

    return {
        setTempLatLng: function(lat, lng)
        {
            self.tempObjectData.lat  = lat;
            self.tempObjectData.lng = lng;
        },
        getTempObjectData: function()
        {
            return self.tempObjectData
        },
        getAllObjects: function()
        {
            var deferred = $q.defer();

            $http.get(url_get_objects).success(function(data){
                deferred.resolve(data);
            }).error(function(resp){
                deferred.reject(resp);    
            });

            return deferred.promise;
        },
        getObjectData: function(id)
        {
            var deferred = $q.defer();

            $http.get(url_get_objects+'/'+id).success(function(data){
                deferred.resolve(data);
            }).error(function(resp){
                deferred.reject(resp);
            });

            return deferred.promise;
        }
    };
}]);
