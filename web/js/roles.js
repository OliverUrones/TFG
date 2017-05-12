var roles = angular.module('roles', ['ngTable']);

roles.controller('ListadoRolesController', ['$scope', 'NgTableParams', function ($scope, NgTableParams) {
        $scope.roles = [];
        $scope.tableParams = new NgTableParams({
            count: 5,
            sorting: {tipo: "asc"}
        },
        {
            paginationMaxBlocks: 13,
            paginationMinBlocks: 2,
            dataset: $scope.roles
        });
        console.log($scope.tableParams.defaultSettings);
        console.log($scope.roles);
}]);