app.service('authService', ['$q', '$http', 'config', function($q, $http, config){

    function saveToken(token)
    {
        sessionStorage.setItem('token', token);
    }

    function getToken()
    {
        return sessionStorage.getItem('token');
    }

    function saveAuthUser()
    {
        var tokenArr = getToken().split('.');
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
                saveToken(token);
                saveAuthUser();
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
        register: function(loginName, email, password, passwordConfirmation)
        {
            var deferred = $q.defer();

            $http.post(config.api_url+'/register', 
                {loginName:loginName, email:email, password:password, passwordConfirmation:passwordConfirmation})
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
            return !!getToken();
        },
        getToken: function()
        {
            return getToken();
        },
        getAuthUser: function()
        {
            return getAuthUser();
        }
    }
}]);
