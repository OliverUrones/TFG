angular
    .module('altaApp', ['ngDialog'])
    .controller('altaAppCtrl', ['$scope', 'ngDialog', function($scope, ngDialog) {
    
    //Objeto que representa al modelo de los datos del formulario de alta
    $scope.altaModelo = {};
    
    //Función que se ejecuta en la directiva ng-click del formulario de alta
    $scope.enviar = function (altaModelo) {
        //alert(JSON.stringify(altaModelo));
    }
    
    $scope.abrirDialog = function() {
        ngDialog.open({template: 'popupTmpl.html', className: 'ngdialog-theme-default'});
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
}])

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