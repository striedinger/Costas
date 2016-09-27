angular.module('app.controllers', [])
.controller('MainController', function($scope, $http){
    $scope.test = "Hello world";
    $scope.teest = function(){
    	console.log('test');
    };
});
