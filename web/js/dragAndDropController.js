Dropzone.autoDiscover = false;
var dragAndDrop = angular.module('dragAndDropApp', ['thatisuday.dropzone']);

dragAndDrop.controller('DragAndDropController', function($scope){
    //console.log($scope);
    $scope.convertir = { 'archivos' : []};
    $scope.dzOptions = {
        //url: '?archivos/subir',
        url: '?archivos/convertir',
        method: 'post',
        parallelUpload: 100,
        maxFiles: 100,
        paramName: 'archivos',
        uploadMultiple: true,
        addRemoveLinks: true,
        clickable: true,
        acceptedFiles: 'image/jpg, image/jpeg, image/png',
        dictDefaultMessage : 'Arrastre aquí sus archivos escaneados',
        dictRemoveFile : 'Borrar',
        dictResponseError : 'No se puede subir la foto',
        autoProcessQueue: false,
        init: function() {
            var botonEnviar = document.querySelector('#EnviarArchivos');
            botonEnviar.addEventListener("click", function() {
                $scope.dzMethods.processQueue();
            });
            //console.log(miDropzone.on());
            console.log($scope);
            console.log($scope.dzMethods);
            //console.log($scope.dzOptions);
            //console.log(document.querySelector("#EnviarArchivos"));
            
        }
    };
    $scope.dzMethods = {};
    
    //Handle events for dropzone
    //Visit http://www.dropzonejs.com/#events for more events
    $scope.dzCallbacks = {
            'addedfile' : function(file){
                    //console.log(file.name);
                    $scope.newFile = file;
                    //Voy añadiendo cada uno de los archivos arrastrados al modelo
                    $scope.convertir.archivos.push(file);
                    //console.log("Muestro el array de nombres de archivos "+$scope.convertir.archivos);
                    console.log("Añadido archivo");
                    console.log($scope.convertir.archivos);
            },
            'removefile' : function(file) {
                console.log("Eliminado archivo");
                console.log(file);
            },
            'sendingmultiple' : function(file, xhr) {
                console.log('Enviando múltiples');
            },
            'successmultiple' : function(file, xhr) {
                console.log('Múltiple exitoso');
            },
            'errormultiple' : function(file, xhr) {
                console.log('Error múltiple');
            },
            'completemultiple' : function(file, xhr){
                    console.log('Completado múltiple');
            },
            'queuecomplete' : function(){
                console.log("Cola completada");
            }
    };
});