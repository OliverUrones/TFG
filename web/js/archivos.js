var archivos = angular.module('archivos', []);

archivos.controller('ListadoArchivosController', ['$scope', function ($scope) {
        $scope.archivos = [];
        console.log($scope.archivos);
}]);