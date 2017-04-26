var formularios = angular.module('RepositorioApp', ['ngDialog']);

formularios.controller('ValidacionFormsController', ['$scope', 'ngDialog', function($scope, ngDialog) {
    //Objeto que representa al modelo de los datos del formulario de alta
    $scope.altaModelo = {};
    $scope.bajaArchivoModelo = {};
    
    $scope.resgistroDialog = function() {
        //Abro el diálogo con la plantilla con id 'respuestaRegistro.html', con la clase 'ngdialog-theme-default' y le paso el scope para poder usar closeThisDialog() en la vista
        ngDialog.open({template: 'respuestaRegistro.html', className: 'ngdialog-theme-default', scope: $scope});
    };
}]);

//Cuadro de diálog parar el borrado de archivos en el perfil del usuario de la parte pública
formularios.controller('BorraArchivoController', ['$scope', 'ngDialog', '$http', function($scope, ngDialog, $http) {
    
    //Modelo del archivo que se va a borrar
    $scope.archivoBorradoModelo = {};
    console.log("Inicio controller");
    console.log($scope);
    
    //Función que abre el cuadro modal de confirmación pasándole como parámetros el ID del archivo a borrar y el token del usuario
    $scope.abreBorradoArchivo = function(archivo_id, token) {
        $scope.borraArchivoDialog = ngDialog.open({template: 'confirmaBorrado.html', className: 'ngdialog-theme-default', scope: $scope});
        $scope.archivoBorradoModelo.archivo_id = archivo_id;
        $scope.archivoBorradoModelo.token = token;
        $scope.archivoBorradoModelo.resultado = {};
        console.log("abreBorradoArchivo()");
        console.log($scope);
    };
    
//    //Función que abre el cuadro modal 
//    $scope.abreResultadoBorrado = function () {
//        $scope.resultadoBorradoDialog = ngDialog.open({template: 'resultadoBorrado.html', className: 'ngdialog-theme-default', scope: $scope, showClose: false, closeByEscape: false, closeByDocument: false});
//        console.log("abreResultadoBorrado()");
//        console.log($scope);
//    };
    
    $scope.borraArchivo = function (datos) {
        console.log("borraArchivo(datos)");
        console.log($scope.archivoBorradoModelo);
        console.log("datos");
        console.log(datos);
        $http.post("index.php?archivos/baja", $scope.archivoBorradoModelo)
            .then(function (respuesta) {
                console.log("Respuesta de $http.post()");
                console.log(respuesta);
                //$scope.archivoBorradoModelo.resultado = respuesta.data;
                //console.log($scope.archivoBorradoModelo.resultado);
            });
    };
    
}]);

formularios.controller('SubidaArchivoFormController', ['$scope', 'ngDialog', '$http', function($scope, ngDialog, $http) {
    $http.get("index.php?categorias/listarAjax",$scope.altaModelo.categorias)
            .then(function (respuesta) {
                //console.log(JSON.stringify(respuesta.data));
                $scope.altaModelo.categorias = respuesta.data;
                console.log($scope.altaModelo.categorias);
    });
    
    $scope.abreFormSubida = function() {
        $scope.miDialog = ngDialog.open({template: 'formSubidaArchivo.html', className: 'ngdialog-theme-default', scope: $scope});
        //console.log($scope.altaModelo.categoria.$$state);
    };
    
    $scope.subirArchivo = function (altaModelo) {
        //console.log(altaModelo);
        //console.log(altaModelo.categorias);
        $http.post("index.php?archivos/alta", altaModelo)
                .then(function (respuesta) {
                    altaModelo.respuesta = respuesta.data;
                    console.log(altaModelo.respuesta);
                    //console.log($scope.miDialog);
                    $scope.miDialog.close();
                });
    };
    
    $scope.abreResultadoSubida = function () {
        $scope.resultadoSubidaDialog = ngDialog.open({template: 'resultadoSubida.html', className: 'ngdialog-theme-default', scope: $scope, showClose: false, closeByEscape: false, closeByDocument: false});
        console.log($scope.resultadoSubidaDialog);
        //console.log(altaModelo.respuesta);
        //console.log("Estoy aquí");
    };
}]);

formularios.controller('DameCategoriasController', ['$scope', '$http', function ($scope, $http) {
//    $scope.altaModelo = {};
    
//    $scope.dameCategorias = function ($scope) {
//        //console.log($scope);
//            $http.get("index.php?categorias/listarAjax",$scope.altaModelo.categorias)
//                .then(function (respuesta) {
//                    //console.log(JSON.stringify(respuesta.data));
//                    $scope.altaModelo.categorias = respuesta.data;
//                    console.log($scope.altaModelo.categorias);
//            });
//    }
}]);

formularios.controller('LoginFormController', ['$scope', 'ngDialog', '$http', function($scope, ngDialog, $http) {
    $scope.abreFormLogin = function () {
        console.log("He entrado en abreFormLogin");
        ngDialog.open({template: 'app/vistas/usuarios/login.php', className: 'ngdialog-theme-default', scope: $scope});
    };
    
    $scope.login = function (loginModelo) {
        //loginModelo = {};
        console.log(loginModelo);
        console.log($scope);
        $http.post("index.php?usuarios/login", loginModelo)
                .then(function(respuesta){
                    console.log(respuesta);
                });
    };
}]);

angular
    .module('altaApp', ['ngDialog'])
    .controller('altaAppCtrl', ['$scope', 'ngDialog', function($scope, ngDialog) {

    //Función que se ejecuta en la directiva ng-click del formulario de alta
    $scope.enviar = function (altaModelo) {
        //alert(JSON.stringify(altaModelo));
    };
    
}]);

angular
    .module('estadoActivacionApp', ['ngDialog'])
    .controller('estadoActivacionController', ['$scope', 'ngDialog', function($scope, ngDialog) {
    
    //Objeto que representa al modelo de los datos del formulario de alta
    $scope.altaModelo = {};
    
    //Función que se ejecuta en la directiva ng-click del formulario de alta
    $scope.enviar = function (altaModelo) {
        //alert(JSON.stringify(altaModelo));
    };
    
    $scope.msgActivacion = function() {
        //Abro el diálogo con la plantilla con id 'estadoActivacion.html', con la clase 'ngdialog-theme-default' y le paso el scope para poder usar closeThisDialog() en la vista
        ngDialog.open({template: 'estadoActivacion.html', className: 'ngdialog-theme-default', scope: $scope, closeByEscape: false, closeByDocument: false, showClose: false});
    };
}]);

angular
    .module('avanzadasApp', [])
    .controller("avanzadasAppCtrl", OpcionesAvanzadas);
    
function OpcionesAvanzadas() {
    //var vm = this;
    this.clase = "hidden";
    this.texto_boton = "Ver opciones avanzadas";
    
    this.ver = function() {
        if(this.clase === "hidden") {
            this.clase = "";
            this.texto_boton = "Ocultar opciones avanzadas";
            console.log(this.clase);
            console.log(this.texto_boton);
        }else
        {
            this.clase = "hidden";
            this.texto_boton = "Ver opciones avanzadas";
            console.log(this.clase);
            console.log(this.texto_boton);
        }
    };
}
