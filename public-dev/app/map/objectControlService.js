app.service('objectControlService', ['$q', '$http', 'config', function($q, $http, config){
    var self = this;
    
    var url_get_objects = config.api_url+'/objects';
    var controlMarker   = null;
    
    return {
        addControlMarker: function(marker)
        {
            controlMarker = marker;
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
