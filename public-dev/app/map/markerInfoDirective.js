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
                    <a ui-sref="object-control"><i class="fa fa-edit pointer"></i></a>
                </div>
                <div class="title"> {{$parent.title}} </div>
                <div class="center-txt">  
                    <i class="fa fa-thumbs-up"> {{$parent.ratingGood}} </i> &nbsp;
                    <i class="fa fa-thumbs-down"> {{$parent.ratingBad}} </i>
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
                    scope.ratingGood = data.ratingGood;
                    scope.ratingBad  = data.ratingBad;
                    scope.photo = '';
                }).catch(function(error) {
                    console.error(error);    
                }); 
            });
        }
    };
}]);
