var roles = angular.module('roles', []);

roles.controller('ListadoRolesController', ['$scope', function ($scope) {
        $scope.roles = [];
        console.log($scope.roles);
}]);