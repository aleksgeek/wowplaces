'use strict';

var app = angular.module('wowPlaces', ['ui.router']);

app.constant('config', {
	"api_url":"http://localhost/wowplaces/public-dev/index.php/api",
	"url":{
		"login":"index.php/api/authenticate",
		"get_user":"index.php/api/user",
		"register":"index.php/api/register"
	}
});

app.config(function ($stateProvider, $urlRouterProvider) {
    $stateProvider
    .state('objects', {
    	url: "/objects",
     	templateUrl  : "app/map/objects.html",
      	controller   : 'objectsCtrl as objects'
    }).state('object_control', {
    	url: "/object_control",
     	templateUrl  : "app/object_control/object_form.html",
      	controller   : 'objectControlCtrl as objectControl'
    }).state('register', {
      	url: "/register",
      	templateUrl  : "app/auth/register.html",
        controller   : 'registerCtrl as register'
    }).state('register_approve', {
        url: "/register_approve/:tmp_auth",
        templateUrl  : "app/auth/registerApprove.html",
        controller   : 'registerApproveCtrl as registerApprove'
    });
    $urlRouterProvider.otherwise('/objects');
});

app.controller('navCtrl', function($scope) {
	var self = this;

	self.is_menu_open = false;

	self.toggle_menu = function(){
		self.is_menu_open = !self.is_menu_open;
	}
});
