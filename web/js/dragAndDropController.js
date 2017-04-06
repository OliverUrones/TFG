Dropzone.autoDiscover = false;
var dragAndDrop = angular.module('dragAndDropApp', ['thatisuday.dropzone']);

dragAndDrop.controller('DragAndDropController', function($scope){
    console.log($scope);
    $scope.archivos = [];
    $scope.dzOptions = {
        url: '?archivos/subir',
        method: 'post',
        parallelUpload: 1,
        paramName: 'archivos',
        uploadMultiple: true,
        addRemoveLinks: true,
        clickable: true,
        acceptedFiles: 'image/jpg, image/jpeg, image/png',
        dictDefaultMessage : 'Arrastre y suelte sus archivos escaneados',
        dictRemoveFile: "Eliminar",
        autoProcessQueue: true
    };
    console.log($scope.dzOptions);
    
    //Handle events for dropzone
    //Visit http://www.dropzonejs.com/#events for more events
    $scope.dzCallbacks = {
            'addedfile' : function(file){
                    //console.log(file.name);
                    $scope.newFile = file;
                    //Voy añadiendo cada uno de los archivos arrastrados al modelo
                    $scope.archivos.push(file);
                    console.log("Muestro el array de nombres de archivos "+$scope.archivos);
            },
            'success' : function(file, xhr){
                    console.log(file, xhr);
            }
    };
    console.log($scope.dzCallbacks);
});