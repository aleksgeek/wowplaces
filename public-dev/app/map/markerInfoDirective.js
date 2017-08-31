app.directive("myMarkerInfo", ['$rootScope', 'objectControlService', function($rootScope, objectControlService) {
    return {
        require: '^myMap',
    	restrict: "E",
        replace: true,
    	scope: true,
        template: `
            <div ng-if="markerInfoOpened" class="marker marker-info">
                <div ng-click="$parent.hide()" class="pull-right">
					<i class="fa fa-arrow-right pointer"></i>
				</div>
				<div class="pull-left">
					<a ui-sref="object_control"><i class="fa fa-edit pointer"></i></a>
				</div>
                <div class="title"> {{$parent.title}} </div>
                <div class="center-txt">  
					<i class="fa fa-thumbs-up"> {{$parent.rating_good}} </i> &nbsp;
                    <i class="fa fa-thumbs-down"> {{$parent.rating_bad}} </i>
                </div>
                <div> {{$parent.desc}} </div>
                <div> {{$parent.photo}} </div>
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
                    scope.rating_good = data.rating_good;
                    scope.rating_bad  = data.rating_bad;
                    scope.photo = '';
                }).catch(function(error) {
                    console.error(error);    
                }); 
            });
        }
    };
}]);
