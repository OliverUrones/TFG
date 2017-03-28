<?php
if(isset($nombre_archivo)) {
    $nombre_archivo_json = json_decode($nombre_archivo);
    var_dump($nombre_archivo_json);
?>
<?php ob_start() ?>
    <h2>Resultado de la conversión</h2>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<?php 
if(isset($usuario)) {
    $usuario_json = json_decode($usuario);
    //var_dump($usuario_json->token);
    
?>
    <button type="button" class="btn btn-default btn-lg btn-block">Subir al repositorio</button>
<?php
}
?>
    <a href="?archivos/descargar/<?php echo $nombre_archivo_json->nombre; ?>" type="button" class="btn btn-default btn-lg btn-block">Descargar</a>
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