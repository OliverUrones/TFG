<?php
if(isset($admin)) {
    $admin_json = json_decode($admin);
    //var_dump($admin_json);
}

if(isset($archivoBorrar)) {
    $archivoBorrar_json = json_decode($archivoBorrar);
    var_dump($archivoBorrar_json);
}

if(isset($borrado)) {
    $borrado_json = json_decode($borrado);
    var_dump($borrado_json);
}
?>
<?php ob_start() ?>
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
    <?php if(isset($admin_json) && isset($archivoBorrar_json)) { ?>
        <h2>Borrar archivo</h2>
        <form name="baja" class="form-horizontal" role="form" action="?archivos/bajaAdmin/<?php echo $admin_json->token; ?>" method="POST">
            <div class="form-group">
                <input type="hidden"
                       name="archivo_id"
                       class="form-control"
                       id="archivo_id"
                       data-ng-model=""
                       value="<?php echo $archivoBorrar_json->archivo_id; ?>"
                       required
                       readonly>
            </div>
            <div class="form-group">
                <label class="control-label">Nombre</label>
                <p class="form-control-static"><?php echo $archivoBorrar_json->nombre; ?></p>
            </div>
            <div class="form-group">
                <label class="control-label">Enlace de descarga</label>
                <p class="form-control-static"><?php echo $archivoBorrar_json->enlace_descarga; ?></p>
            </div>
            <div class="form-group">
                <label class="control-label">Propietario</label>
                <p class="form-control-static"><?php echo $archivoBorrar_json->nombre_usuario; ?></p>
            </div>
            <div class="form-group">
                <label class="control-label">Categoría</label>
                <p class="form-control-static"><?php echo $archivoBorrar_json->nombre_categoria; ?></p>
            </div>
            <div class="form-group">
                <label class="control-label">Ámbito del archivo</label>
                <p class="form-control-static">
                    <?php if($archivoBorrar_json->ambito==0) { ?>
                        <span class="glyphicon glyphicon-eye-close"></span> Privado
                    <?php } else { ?>
                        <span class="glyphicon glyphicon-eye-open"></span> Público
                    <?php } ?>
                </p>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success" value="Enviar">Borrar</button>
                <a href="?archivos/listarTodos/<?php echo $admin_json->token; ?>" type="button" class="btn btn-danger" value="Enviar" data-ng-init="" data-ng-disabled="!alta.$valid">Volver</a>
            </div>
        </form>
    <?php } elseif (isset($admin_json) && isset ($borrado_json) ) { ?>
        <?php if(strcmp($borrado_json->estado_p, "200 OK")== 0) {?>
            <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><?php echo $borrado_json->Mensaje ?></div>
            <a href="?archivos/listarTodos/<?php echo $admin_json->token; ?>" type="button" class="btn btn-success" value="Enviar" data-ng-init="" data-ng-disabled="!alta.$valid">Volver</a>
        <?php } else { ?>
            <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><?php echo $borrado_json->Mensaje ?></div>
            <a href="?archivos/listarTodos/<?php echo $admin_json->token; ?>" type="button" class="btn btn-danger" value="Enviar" data-ng-init="" data-ng-disabled="!alta.$valid">Volver</a>
        <?php } ?>
    <?php } ?>
    </div>
</div>
<?php $contenido = ob_get_clean(); ?>
<?php 
    /*Función para cargar plantilla en la configuración*/
    $ruta_plantillas = PLANTILLAS.'plantilla_admin.php';
    //echo '<br/>'.$ruta_plantillas;
    require_once $ruta_plantillas;
?>