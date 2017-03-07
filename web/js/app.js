angular
    .module('altaApp', ['ngDialog'])
    .controller('altaAppCtrl', ['$scope', 'ngDialog', function($scope, ngDialog) {
    
    $scope.altaModelo = {};
    
    $scope.enviar = function (altaModelo) {
        //alert(JSON.stringify(altaModelo));
    }
    
    $scope.abrirDialog = function() {
        ngDialog.open({template: 'popupTmpl.html', className: 'ngdialog-theme-default'});
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