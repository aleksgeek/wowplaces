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
            <div class="marker marker-context">
               {{description}}
                <hr>
                <div class="btn-block">                 
                    <i class="fa fa-thumbs-up"> {{ratingGood}} </i> &nbsp;
                    <i class="fa fa-thumbs-down"> {{ratingBad}} </i>
                </div>
            </div>
        `,
        link: function(scope, element, attrs)
        {
            
        }
    };
}]);
