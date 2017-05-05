<?php
if(isset($resultado)) {
    $resultado_json = json_decode($resultado);
    //var_dump($resultado_json);
}

if(isset($usuario)) {
    $usuario_json = json_decode($usuario);
    //var_dump($usuario_json);
}
?>
<?php ob_start() ?>
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-app="" ng-controller="">
        <?php if(isset($resultado_json) && $resultado_json != 'null') { ?>
            <h1>Resultado de la búsqueda: <small><?php echo $resultado_json->cadena; ?></small></h1>
            <?php if($resultado_json->total > 0) { ?>
            <h2>Encontrados <?php echo $resultado_json->total; ?> documentos.</h2>
                <?php foreach ($resultado_json as $obj) { ?>
                    <?php if(is_object($obj)) { ?>
                        <article class="media">
                            <div class="media-object">
                                <img class="pull-left" src="web/imagenes/public/pdf_file.png" alt="Icono de archivo">
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">ID: <small><?php echo $obj->archivo_id; ?></small></h4>
                                <h4 class="media-heading">Nombre: <small><?php echo utf8_decode($obj->nombre_archivo); ?></small></h4>
                                <h4 class="media-heading">Categoria: <small><?php echo utf8_decode($obj->categoria); ?></small><h4>
                                <h4 class="media-heading">Etiquetas: <small><?php echo $obj->etiquetas; ?></small></h4>
                            </div>
                            <div class="media-left">
                                <a class="btn btn-default" href="?archivos/descargarArchivo/<?php echo $obj->enlace_descarga; ?>"><h5><i class="glyphicon glyphicon-download"></i> Descargar</h5></a>
                            </div>
                        </article>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        <?php } else { ?>
            <h1>Resultado de la búsqueda: <small>No hay resultados.</small></h1>
        <?php } ?>
        <?php //if(isset($resultado_json) && isset($resultado_json->cadena)) { ?>
<!--            <h1>Resultado de la búsqueda: <small><?php //echo $resultado_json->cadena; ?></small></h1>-->
            <?php //if($resultado_json->total > 0) { ?>
<!--            <h2>Encontrados <?php //echo $resultado_json->total; ?> resultados.</h2>-->
                <?php //foreach ($resultado_json as $obj) { ?>
                    <?php //if(is_object($obj)) { ?>
<!--                        <article class="media">
                            <div class="media-object">
                                <img class="pull-left" src="web/imagenes/public/pdf_file.png" alt="Icono de archivo">
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">ID: <small><?php //echo $obj->archivo_id; ?></small></h4>
                                <h4 class="media-heading">Nombre: <small><?php //echo utf8_decode($obj->nombre_archivo); ?></small></h4>
                                <h4 class="media-body">Categoria: <small><?php //echo utf8_decode($obj->categoria); ?></small><h4>
                                <h4 class="media-object">Etiquetas: <small><?php //echo $obj->etiquetas; ?></small></h4>
                            </div>
                            <div class="media-left">
                                <a class="btn btn-default" href="?archivos/descargarArchivo/<?php //echo $obj->enlace_descarga; ?>"><h5><i class="glyphicon glyphicon-download"></i> Descargar</h5></a>
                            </div>
                        </article>-->
                    <?php //} ?>
                <?php //} ?>
            <?php //} else { ?>
<!--                <h1>Resultado de la búsqueda: <small>No hay resultados.</small></h1>-->
            <?php //} ?>
        <?php //} else { ?>
<!--            <h1>Resultado de la búsqueda: <small>No se han encontrado archivos con el criterio introducido.</small></h1>-->
        <?php //} ?>
    </div>
</div>
<?php $contenido = ob_get_clean(); ?>
<?php 
    /*Función para cargar plantilla en la configuración*/
    $ruta_plantillas = PLANTILLAS.'plantilla.php';
    //echo '<br/>'.$ruta_plantillas;
    require_once $ruta_plantillas;
?>