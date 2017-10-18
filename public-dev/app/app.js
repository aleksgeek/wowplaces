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
    }).state('place-control', {
        url: "/place-control",
        templateUrl  : "app/place-control/placeForm.html",
        controller   : 'placeControlCtrl as placeControl'
    }).state('tourist-guide', {
        url: "/tourist-guide",
        templateUrl  : "app/tourist-guide/countries.html",
        controller   : 'touristGuideCtrl as touristGuide'
    }).state('register', {
        url: "/register",
        templateUrl  : "app/auth/register.html",
        controller   : 'registerCtrl as register'
    }).state('register-approve', {
        url: "/register-approve/:tmpAuth",
        templateUrl  : "app/auth/registerApprove.html",
        controller   : 'registerApproveCtrl as registerApprove'
    });
    $urlRouterProvider.otherwise('/objects');
});
