app.service('objectControlService', ['$q', '$http', 'config', function($q, $http, config){
    var self = this;
        
        self.latitude  = null;
        self.longitude = null;
        
    var url_get_objects = config.api_url+'/objects';

    return {
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
