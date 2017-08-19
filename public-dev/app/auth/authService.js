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
		var token_arr = getToken().split('.');
		var data_obj  = atob(token_arr[1]);
		sessionStorage.setItem('user_data', data_obj);
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
		register_approve: function(tmp_auth)
		{
			var deferred = $q.defer();

			$http.post(config.api_url+'/register_approve', {tmp_auth:tmp_auth})
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
		register: function(login_name, email, password, password_confirmation)
		{
			var deferred = $q.defer();

			$http.post(config.api_url+'/register', 
				{login_name:login_name, email:email, password:password, password_confirmation:password_confirmation})
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
