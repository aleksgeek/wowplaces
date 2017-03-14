app.service('voteService', ['$http', 'authService', 'config', function($http, authService, config){
	var self = this;
	
	return {
		make_vote: function(id_object, vote){
			var good = bad = 0;

			if(vote=='good'){
				good = 1;
			}else{
				bad = 1;
			}

			$http.post(config.api_url+'/vote', {id_object:id_object, good:good, bad:bad}, {headers: {
		        'Authorization': 'Bearer ' + authService.getToken()
		    }})
			.success(function(data){
				console.log(data);	
			})
			.error(function(data){
				console.log(data);	
			});
		}
	}
}]);