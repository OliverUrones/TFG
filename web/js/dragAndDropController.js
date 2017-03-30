//Dropzone.autoDiscover = false;
var dragAndDrop = angular.module('dragAndDropApp', ['thatisuday.dropzone']);

dragAndDrop.controller('DragAndDropController', function($scope){
    console.log($scope);
    $scope.dzOptions = {
        url: '?archivos/convertir',
        paramName: [],
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
                    console.log(file);
                    $scope.newFile = file;
            },
            'success' : function(file, xhr){
                    console.log(file, xhr);
            }
    };
    console.log($scope.dzCallbacks);
});