var usuarios = angular.module('usuarios', []);

usuarios.controller('ListadoUsuariosController', ['$scope', function ($scope) {
        $scope.usuarios = [];
        console.log($scope.usuarios);
}]);