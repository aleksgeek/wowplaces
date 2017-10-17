app.controller('topMenuCtrl', function($scope) {
    var self = this;

    self.isMenuOpen = false;

    self.toggleMenu = function(){
        self.isMenuOpen = !self.isMenuOpen;
    }
});
