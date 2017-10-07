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
        templateUrl  : "app/object_control/objectForm.html",
        controller   : 'objectControlCtrl as objectControl'
    }).state('tourist_guide', {
        url: "/tourist_guide",
        templateUrl  : "app/tourist_guide/countries.html",
        controller   : 'touristGuideCtrl as touristGuide'
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
