app.service('objectInfoService', ['$http', 'config', function($http, config){
    var self = this;
        self.fullInfoStatus = false;

    var urlGetObjects = config.api_url+'/objects';

	return {
        showFullInfo: function()
        {
            self.fullInfoStatus = true;    
        }
    };
}]);
