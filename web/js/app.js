var formularios = angular.module('RepositorioApp', ['ngDialog']);

formularios.controller('ValidacionFormsController', ['$scope', 'ngDialog', function($scope, ngDialog) {
    //Objeto que representa al modelo de los datos del formulario de alta
    $scope.altaModelo = {};
    
    $scope.resgistroDialog = function() {
        //Abro el diálogo con la plantilla con id 'respuestaRegistro.html', con la clase 'ngdialog-theme-default' y le paso el scope para poder usar closeThisDialog() en la vista
        ngDialog.open({template: 'respuestaRegistro.html', className: 'ngdialog-theme-default', scope: $scope});
    }
}]);

formularios.controller('SubidaArchivoFormController', ['$scope', 'ngDialog', function($scope, ngDialog) {
    $scope.abreFormSubida = function() {
        ngDialog.open({template: 'formSubidaArchivo.html', className: 'ngdialog-theme-default', scope: $scope});
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
    .module('loginApp', [])
    .controller('loginAppCtrl', ['$scope', function($scope) {
            
    //Objeto que representa al modelo de los datos del formulario de login
    $scope.loginModelo = {};
    
    //Función que se ejecuta en la directia ng-click del formulario de login
    $scope.login = function (loginModelo) {
        console.log(loginModelo);
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