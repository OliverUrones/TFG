<?php ob_start(); ?>
<?php
if(isset($estado_activacion)) {
?>
<div class="modal modal-content" data-ng-controller="estadoActivacionController" data-ng-init="msgActivacion()">
    <script type="text/ng-template" id="estadoActivacion.html">
                <div class="modal-header">
                    <h3 class="modal-title">Estado del registro</h3>
                </div>
                <div class="modal-body">
                    <div>
                    <?php
                        $estado_activacion = json_decode($estado_activacion); 
                        //var_dump($estado_activacion);
                        echo $estado_activacion->Mensaje;
                    ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="?home/index" type="button" class="btn btn-success">Ir al inicio</a>
                    <a href="?usuarios/login" type="button" class="btn btn-success">Login</a>
                </div>
    </script>
</div>
<?php
}
?>
<?php $contenido = ob_get_clean(); ?>
<?php 
    /*Función para cargar plantilla en la configuración*/
    $ruta_plantillas = PLANTILLAS.'plantilla.php';
    //echo '<br/>'.$ruta_plantillas;
    require_once $ruta_plantillas;
?>