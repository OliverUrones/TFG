<?php
if(isset($admin)) {
    $admin_json = json_decode($admin);
    //var_dump($admin_json);
}

if(isset($usuarios)) {
    $usuarios_json = json_decode($usuarios);
    //var_dump($usuarios_json);
}
?>
<?php ob_start() ?>
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" ng-app="" ng-controller="">
        <h2>Resultado de la búsqueda</h2>
    </div>
</div>
<?php $contenido = ob_get_clean(); ?>
<?php 
    /*Función para cargar plantilla en la configuración*/
    $ruta_plantillas = PLANTILLAS.'plantilla.php';
    //echo '<br/>'.$ruta_plantillas;
    require_once $ruta_plantillas;
?>