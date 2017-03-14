app.directive("myMarkerContext", [function() {
    return {
    	restrict : "E",
    	scope: {
    		description: '@',
    		ratingGood: '@',
    		ratingBad: '@',
            typeInfo: '@'
    	},
        template: `
            <div class="marker-context">
               {{description}}
                <hr>
                <div class="btn-block">
                    <i class="fa fa-thumbs-up" ng-click="voteUp()">{{ratingGood}}</i> &nbsp;
                    <i class="fa fa-thumbs-down" ng-click="voteDown()">{{ratingBad}}</i>
                </div>
            </div>
        `,
        link: function(scope, element, attrs)
        {
            scope.voteUp = function(){
                console.log('voteUp');
            }
            scope.voteDown = function(){
                console.log('voteDown');
            }
        }
    };
}]);
