var archivos = angular.module('archivos', ['ngTable', 'ngDialog']);

archivos.controller('ListadoArchivosController', ['$scope', 'NgTableParams', 'ngDialog', '$http', function ($scope, NgTableParams, ngDialog, $http) {
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
        console.log($scope);
        
        //Modelo del archivo que se va a borrar
        $scope.archivoBorradoModelo = {};
        //console.log("Inicio controller");
        //console.log($scope);

        /**
         * Función que recibe como parámetros el ID del archivo a borrar y el token del usuario para construir la 
         * ruta para la petición get del archivo para obtener los datos de éste a través de su ID y presentarlos en el modal de confirmación para borrar.
         * @param {int} archivo_id
         * @param {string} token
         * @returns {undefined}
         */
        $scope.abreBorradoArchivo = function(archivo_id, token) {
            $scope.borraArchivoDialog = ngDialog.open({template: 'confirmaBorrado.html', className: 'ngdialog-theme-default', scope: $scope, showClose: false, closeByEscape: false, closeByDocument: false});
            var url = "index.php?archivos/ver/"+archivo_id+"/"+token;
            console.log("url : "+url);
            $http.get(url)
                .then(function (respuesta) {
                    $scope.archivoBorradoModelo = respuesta.data;
                    $scope.archivoBorradoModelo.token = token;
                });
        };

        //Función que abre el cuadro modal 
        $scope.abreResultadoBorrado = function () {
            $scope.resultadoBorradoDialog = ngDialog.open({template: 'resultadoBorrado.html', className: 'ngdialog-theme-default', scope: $scope, showClose: false, closeByEscape: false, closeByDocument: false});
            console.log("abreResultadoBorrado()");
            console.log($scope);
        };

        $scope.borraArchivo = function (datos) {
            //console.log("borraArchivo(datos)");
            //console.log("Datos del archivo a borrar");
            //console.log(datos);
            $http.post("index.php?archivos/baja", $scope.archivoBorradoModelo)
                .then(function (respuesta) {
                    console.log("Éxito $http.post()");
                    console.log(JSON.stringify(respuesta.data));
                    $scope.archivoBorradoModelo.resultado = respuesta.data;
                    //console.log($scope.archivoBorradoModelo.resultado);
                });
        };
}]);