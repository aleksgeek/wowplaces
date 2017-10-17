app.service('voteService', ['$http', 'authService', 'config', function($http, authService, config){
    var self = this;
    
    return {
        makeVote: function(idObject, vote){
            var good = bad = 0;

            if(vote=='good'){
                good = 1;
            }else{
                bad = 1;
            }

            $http.post(config.api_url+'/vote', {idObject:idObject, good:good, bad:bad}, {headers: {
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
