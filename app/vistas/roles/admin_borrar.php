<?php
/**
 * @author A. Oliver Urones García
 * @copyleft (cc) 2017, Oliver Urones
 * @license https://creativecommons.org/licenses/by-nc-sa/4.0/ Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0)
 * @version 1.0
 * 
 * Vista del borrado de roles para la parte de administración
 * 
 * La vista recibe las siguientes variables del controlador
 * $rolBorrar Datos del rol a borrar
 * @var string JSON
 * 
 * $borrado Datos del resultado de la operación
 * @var string JSON
 * 
 * $admin Datos del administrador conectado
 * @var string JSON
 */
if(isset($admin)) {
    $admin_json = json_decode($admin);
}

if(isset($rolBorrar)) {
    $rolBorrar_json = json_decode($rolBorrar);
    //var_dump($rolBorrar_json);
}

if(isset($borrado)) {
    $borrado_json = json_decode($borrado);
    //var_dump("Usuario Borrado: ".$borrado_json);
}
?>
<?php ob_start() ?>
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
    <?php if(isset($admin_json) && isset($rolBorrar_json)) { ?>
        <h2>Borrar rol</h2>
        <form name="baja" class="form-horizontal" role="form" action="?roles/baja/<?php echo $admin_json->token; ?>" method="POST">
            <div class="form-group">
                <input type="hidden"
                       name="rol_id"
                       class="form-control"
                       id="rol_id"
                       data-ng-model=""
                       value="<?php echo $rolBorrar_json->rol_id; ?>"
                       required
                       readonly>
            </div>
            <div class="form-group">
                <label class="control-label">Tipo</label>
                <p class="form-control-static"><?php echo $rolBorrar_json->tipo; ?></p>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success" value="Enviar">Borrar</button>
                <a href="?roles/listar/<?php echo $admin_json->token; ?>" type="button" class="btn btn-danger" value="Enviar" data-ng-init="" data-ng-disabled="!alta.$valid">Volver</a>
            </div>
        </form>
    <?php } elseif (isset($admin_json) && isset ($borrado_json) ) { ?>
        <?php if(strcmp($borrado_json->estado_p, "200 OK")== 0) {?>
            <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"></button><?php echo $borrado_json->Mensaje ?></div>
            <a href="?roles/listar/<?php echo $admin_json->token; ?>" type="button" class="btn btn-success" value="Enviar" data-ng-init="" data-ng-disabled="!alta.$valid">Volver</a>
        <?php } else { ?>
            <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"></button><?php echo $borrado_json->Mensaje ?></div>
            <a href="?roles/listar/<?php echo $admin_json->token; ?>" type="button" class="btn btn-danger" value="Enviar" data-ng-init="" data-ng-disabled="!alta.$valid">Volver</a>
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