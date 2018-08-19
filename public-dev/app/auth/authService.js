app.service('authService', ['$q', '$http', 'config', function($q, $http, config){
	
    function saveAuthUserFromToken(token)
    {
        var tokenArr = token.split('.');
        var dataObj  = atob(tokenArr[1]);
        sessionStorage.setItem('user_data', dataObj);
    }

    function removeToken()
    {
        return sessionStorage.removeItem('token');
    }

    function getAuthUser()
    {
        return JSON.parse(sessionStorage.getItem('user_data'));
    }

    return {
        login: function(email, password)
        {
            var deferred = $q.defer();

            $http.post(config.api_url+'/authenticate', {email:email, password:password}).then(
            function(ok){
                var token = ok.data;
                
                saveAuthUserFromToken(token);
                deferred.resolve(token);
            }, 
            function(error){
                deferred.reject(error);
            }); 

            return deferred.promise;
        },
        logout: function(){
            removeToken();
        },
        registerApprove: function(tmpAuth)
        {
            var deferred = $q.defer();

            $http.post(config.api_url+'/register_approve', {tmpAuth:tmpAuth})
            .then(
                function(resp){
                    deferred.resolve(resp.data);
                },
                function(resp){
                    deferred.reject(resp);
                }
            );  

            return deferred.promise;
        },
        register: function(name, email, password, passwordConfirmation)
        {
            var deferred = $q.defer();

            $http.post(config.api_url+'/register', 
                {name:name, email:email, password:password, password_confirmation:passwordConfirmation})
            .then(
                function(resp){
                    deferred.resolve(resp.data);
                },
                function(resp){
                    deferred.reject(resp);
                }
            );  

            return deferred.promise;
        },
        isLogined:function()
        {
            return !!getAuthUser();
        },
        getAuthUser: function()
        {
            return getAuthUser();
        }
    }
}]);
