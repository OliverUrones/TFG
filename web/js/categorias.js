var categorias = angular.module('categorias', []);

categorias.controller('ListadoCategoriasController', ['$scope', function ($scope) {
        $scope.categorias = [];
        console.log($scope.categorias);
}]);