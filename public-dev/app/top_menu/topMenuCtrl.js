app.controller('topMenuCtrl', function($scope) {
	var self = this;

	self.is_menu_open = false;

	self.toggle_menu = function(){
		self.is_menu_open = !self.is_menu_open;
	}
});
