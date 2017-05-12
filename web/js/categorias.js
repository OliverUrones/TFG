var categorias = angular.module('categorias', ['ngTable']);

categorias.controller('ListadoCategoriasController', ['$scope', 'NgTableParams', function ($scope, NgTableParams) {
        $scope.categorias = [];
        $scope.tableParams = new NgTableParams({
            count: 5,
            sorting: {nombre: "asc"}
        },
        {
            paginationMaxBlocks: 13,
            paginationMinBlocks: 2,
            dataset: $scope.categorias
        });
        console.log($scope.tableParams.defaultSettings);
        console.log($scope.categorias);
}]);