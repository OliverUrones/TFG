var cambiarPass = angular.module('CambiarPass', ['ngDialog']);

cambiarPass.controller('CambiaPassController', ['$scope', 'ngDialog', function ($scope, ngDialog) {
    $scope.cambioPass = {};
    //console.log($scope);
    
    $scope.cambioPassDialog = function() {
        //Abro el diálogo con la plantilla con id 'respuestaRegistro.html', con la clase 'ngdialog-theme-default' y le paso el scope para poder usar closeThisDialog() en la vista
        ngDialog.open({template: 'respuestaCambioPass.html', className: 'ngdialog-theme-default', scope: $scope, showClose: false, closeByEscape: false, closeByDocument: false});
    };
}]);

