<html>
    <head>
        <title>Estado de la activación de la cuenta</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="web/css/bootstrap.min.css">
        <link rel="stylesheet" href="web/css/estilos.css">
        <link rel="stylesheet" href="web/css/ngDialog-theme-default.min.css">
        <link rel="stylesheet" href="web/css/ngDialog.min.css">
        <script src="web/js/angular.min.js"></script>
        <script src="web/js/ngDialog.min.js"></script>
        <script src="web/js/jquery.js"></script>
        <script src="web/js/bootstrap.js"></script>
        <script src="web/js/app.js"></script>
    </head>
    <body  data-ng-app="estadoActivacionApp" data-ng-controller="estadoActivacionController" data-ng-init="msgActivacion()">
<?php
if(isset($estado_activacion)) {
?>
    <script type="text/ng-template" id="estadoActivacion.html">
                <div class="modal-header">
                    <h3 class="modal-title">Estado del registro</h3>
                </div>
                <div class="modal-body">
                <div>
                <?php
                    $estado_activacion = json_decode($estado_activacion); 
                    //var_dump($registro);
                    echo $estado_activacion->Mensaje;
                ?>
                </div>
            </div>
    </script>
<?php
}
?>
    </body>
</html>