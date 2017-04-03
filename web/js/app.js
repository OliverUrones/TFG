var formularios = angular.module('RepositorioApp', ['ngDialog']);

formularios.controller('ValidacionFormsController', ['$scope', 'ngDialog', function($scope, ngDialog) {
    //Objeto que representa al modelo de los datos del formulario de alta
    $scope.altaModelo = {};
    
    $scope.resgistroDialog = function() {
        //Abro el diálogo con la plantilla con id 'respuestaRegistro.html', con la clase 'ngdialog-theme-default' y le paso el scope para poder usar closeThisDialog() en la vista
        ngDialog.open({template: 'respuestaRegistro.html', className: 'ngdialog-theme-default', scope: $scope});
    }
}]);

formularios.controller('SubidaArchivoFormController', ['$scope', 'ngDialog', '$http', function($scope, ngDialog, $http) {
    $scope.abreFormSubida = function() {
        ngDialog.open({template: 'formSubidaArchivo.html', className: 'ngdialog-theme-default', scope: $scope});
    }
    
    $scope.subirArchivo = function (altaArchivoModelo) {
        console.log(altaArchivoModelo);
        $http.get("index.php?categorias/listarAjax", altaArchivoModelo)
                .then(function (respuesta) {
                    console.log(respuesta.data);
        });
        
    }
}]);

formularios.controller('LoginFormController', ['$scope', 'ngDialog', '$http', function($scope, ngDialog, $http) {
    $scope.abreFormLogin = function () {
        console.log("He entrado en abreFormLogin");
        ngDialog.open({template: 'app/vistas/usuarios/login.php', className: 'ngdialog-theme-default', scope: $scope});
    }
    
    $scope.login = function (loginModelo) {
        //loginModelo = {};
        console.log(loginModelo);
        console.log($scope);
        $http.post("index.php?usuarios/login", loginModelo)
                .then(function(respuesta){
                    console.log(respuesta);
                });
    }
}]);

angular
    .module('altaApp', ['ngDialog'])
    .controller('altaAppCtrl', ['$scope', 'ngDialog', function($scope, ngDialog) {

    //Función que se ejecuta en la directiva ng-click del formulario de alta
    $scope.enviar = function (altaModelo) {
        //alert(JSON.stringify(altaModelo));
    }
    
}]);

angular
    .module('estadoActivacionApp', ['ngDialog'])
    .controller('estadoActivacionController', ['$scope', 'ngDialog', function($scope, ngDialog) {
    
    //Objeto que representa al modelo de los datos del formulario de alta
    $scope.altaModelo = {};
    
    //Función que se ejecuta en la directiva ng-click del formulario de alta
    $scope.enviar = function (altaModelo) {
        //alert(JSON.stringify(altaModelo));
    }
    
    $scope.msgActivacion = function() {
        //Abro el diálogo con la plantilla con id 'estadoActivacion.html', con la clase 'ngdialog-theme-default' y le paso el scope para poder usar closeThisDialog() en la vista
        ngDialog.open({template: 'estadoActivacion.html', className: 'ngdialog-theme-default', scope: $scope, closeByEscape: false, closeByDocument: false, showClose: false});
    }
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
    }
}