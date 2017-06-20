<?php
/**
 * @author A. Oliver Urones García
 * @copyleft (cc) 2017, Oliver Urones
 * @license https://creativecommons.org/licenses/by-nc-sa/4.0/ Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0)
 * @version 1.0
 * 
 * Vista del alta de roles para la parte de administración
 * 
 * La vista recibe las siguientes variables del controlador
 * $resultado Datos del resultado de la operación
 * @var string JSON
 * 
 * $admin Datos del administrador conectado
 * @var string JSON
 */
if(isset($admin)) {
    $admin_json = json_decode($admin);
    //var_dump($admin_json);
}

if(isset($resultado)) {
    $resultado_json = json_decode($resultado);
    //var_dump($resultado_json);
}
?>
<?php ob_start() ?>
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3" data-ng-app="roles" data-ng-controller="ListadoRolesController">
        <h2>Alta rol</h2>
        <?php if( isset($resultado_json->estado_p) ) { ?>
            <?php if( $resultado_json->estado_p === "200 OK") { ?>
                <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"></button><?php echo $resultado_json->Mensaje; ?></div>
                <a href="?roles/listar/<?php echo $admin_json->token; ?>" type="button" class="btn btn-success" value="Enviar" data-ng-init="">Volver</a>
            <?php } else { ?>
                <div class="alert alert-info"><button type="button" class="close" data-dismiss="alert"></button><?php echo $resultado_json->Mensaje; ?></div>
                <a href="?roles/listar/<?php echo $admin_json->token; ?>" type="button" class="btn btn-info" value="Enviar" data-ng-init="">Volver</a>
            <?php } ?>
        <?php } elseif(!isset ($resultado_json)) { ?>
            <form name="alta" class="form-horizontal" role="form" action="?roles/alta/<?php echo $admin_json->token ?>" method="POST">
                <div class="form-group">
                    <label class="control-label">Tipo de rol</label>
                    <input type="tipo" 
                           name="tipo" 
                           class="form-control" 
                           data-ng-model="altaRol.tipo" 
                           data-ng-minlength="3"
                           required>
                    <span data-ng-show='alta.tipo.$error.required && !alta.tipo.$pristine'>El tipo es obligatorio.</span>
                    <span data-ng-show='alta.tipo.$error.minlength && !alta.tipo.$pristine'>Debe tener al menos 3 caracteres.</span>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success" value="Enviar" data-ng-init="resgistroDialog()" data-ng-disabled="!alta.$valid">Alta</button>
                    <a href="?roles/listar/<?php echo $admin_json->token; ?>" type="button" class="btn btn-danger" value="Enviar" data-ng-init="">Cancelar</a>
                </div>
            </form>
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