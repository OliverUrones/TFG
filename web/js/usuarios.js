var usuarios = angular.module('usuarios', ['ngTable']);

usuarios.controller('ListadoUsuariosController', ['$scope', 'NgTableParams', function ($scope, NgTableParams) {
        $scope.usuarios = [];
        $scope.tableParams = new NgTableParams({
            count: 5,
            sorting: {email: "asc"}
        },
        {
            paginationMaxBlocks: 13,
            paginationMinBlocks: 2,
            dataset: $scope.usuarios
        });
        console.log($scope.tableParams.defaultSettings);
}]);