app.service('objectInfoService', ['$http', 'config', function($http, config){
    var self = this;
        self.fullinfoStatus = false;

    var url_get_objects = config.api_url+'/objects';

	return {
        showFullInfo: function()
        {
            self.fullinfoStatus = true;    
        }
    };
}]);