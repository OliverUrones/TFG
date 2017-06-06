var usuarios = angular.module('usuarios', ['ngTable', 'ngDialog']);

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

usuarios.controller('RecordarController', ['$scope', function ($scope) {
        $scope.recordarModelo = {};
}]);

usuarios.controller('EliminarCuentaController', ['$scope', 'ngDialog', '$http', function($scope, ngDialog, $http) {
        $scope.usuarioABorrar = {};
        $scope.abrirConfirmacionBorrado = function () {
            ngDialog.open({template: 'eliminarCuenta.html', className: 'ngdialog-theme-default', scope: $scope, showClose: true, closeByEscape: true, closeByDocument: true});
        };
        
        $scope.eliminarCuenta = function(borrado) {
            console.log("Estoy en eliminarCuenta. El usuario que se va a borrar es: ");
            var datos = {'id' : borrado.usuario_id, 'token' : borrado.token};
            $http.post("index.php?usuarios/bajaCuenta", datos)
                .then(function (respuesta) {
                    console.log("Éxito $http.post()");
                    console.log(JSON.stringify(respuesta.data));
                    $scope.usuarioABorrar.resultado = respuesta.data;
                    console.log($scope.usuarioABorrar.resultado);
                });
        };
        
        $scope.abreResultadoBaja = function () {
            $scope.resultadoSubidaDialog = ngDialog.open({template: 'resultadoBajaCuenta.html', className: 'ngdialog-theme-default', scope: $scope, showClose: false, closeByEscape: false, closeByDocument: false});
            console.log($scope.resultadoSubidaDialog);
            //console.log(altaModelo.respuesta);
            //console.log("Estoy aquí");
        };
}]);
