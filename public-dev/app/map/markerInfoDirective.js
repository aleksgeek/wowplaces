app.directive("myMarkerInfo", ['$rootScope', 'objectControlService', function($rootScope, objectControlService) {
    return {
        require: '^myMap',
    	restrict: "E",
        replace: true,
    	scope: true,
        template: `
            <div ng-if="markerInfoOpened" class="marker-info">
                <div ng-click="$parent.hide()" class="pull-right"><i class="fa fa-arrow-right pointer"></i></div>
                <div class="title"> {{$parent.title}} </div>
                <div> {{$parent.desc}} </div>
            </div> 
        `,
        link: function(scope, element, attrs, mapCtrl)
        {
            scope.hide = function(){
                scope.markerInfoOpened = false;
            }

            scope.$on('showMarkerInfo', function (event, idObject) {
                objectControlService.getObjectData(idObject).then(function(data){
                    scope.markerInfoOpened = true;
                    scope.title = data.title;  
                    scope.desc  = data.description; 
                }).catch(function(error) {
                    console.error(error);    
                }); 
            });
        }
    };
}]);
