var archivos = angular.module('archivos', ['ngTable']);

archivos.controller('ListadoArchivosController', ['$scope', 'NgTableParams', function ($scope, NgTableParams) {
        $scope.archivos = [];
        $scope.tableParams = new NgTableParams({
            count: 5,
            sorting: {nombre: "asc"}
        },
        {
            paginationMaxBlocks: 13,
            paginationMinBlocks: 2,
            dataset: $scope.archivos
        });
        console.log($scope.tableParams.defaultSettings);
}]);