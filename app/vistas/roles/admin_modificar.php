<?php 
/**
 * @author A. Oliver Urones García
 * @copyleft (cc) 2017, Oliver Urones
 * @license https://creativecommons.org/licenses/by-nc-sa/4.0/ Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0)
 * @version 1.0
 * 
 * Vista de la modificación de roles para la parte de administración
 * 
 * La vista recibe las siguientes variables del controlador
 * $rol Datos del rol a modificar
 * @var string JSON
 * 
 * $admin Datos del administrador conectado
 * @var string JSON
 */
if(isset($rol)) {
    $rol_json = json_decode($rol);
    //var_dump($rol_json);
}

if(isset($admin)) {
    $admin_json = json_decode($admin);
    //var_dump($admin_json);
}
?>
<?php ob_start() ?>
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3" data-ng-app="roles">
        <?php if( (isset($rol_json->accion) && $rol_json->accion === 'modificar') && (isset($rol_json->estado_p) && $rol_json->estado_p === '200 OK') ) { ?>
            <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"></button><?php echo $rol_json->Mensaje; ?></div>
        <?php } ?>
        <h2>Modificar rol</h2>
        <form name="modificar" class="form-horizontal" role="form" action="?roles/modificar/<?php echo $admin_json->token; ?>" method="POST">
            <div class="form-group">
<!--                <label class="control-label">ID</label>-->
                <input type="hidden"
                       name="rol_id"
                       class="form-control"
                       id="rol_id"
                       data-ng-model="rolModificado.rol_id"
                       data-ng-init="rolModificado.rol_id = '<?php echo $rol_json->rol_id; ?>'"
                       value="<?php echo $rol_json->rol_id; ?>"
                       required
                       readonly>
            </div>
            <div class="form-group">
                <label class="control-label">Tipo</label>
                <input type="text"
                       name="tipo"
                       class="form-control"
                       id="tipo"
                       data-ng-model="rolModificado.tipo"
                       data-ng-init="rolModificado.tipo = '<?php echo $rol_json->tipo; ?>'"
                       data-ng-minlength="3"
                       value="<?php echo $rol_json->tipo; ?>"
                       required
                       >
                <span data-ng-show='modificar.tipo.$error.required && !modificar.tipo.$pristine'>El tipo es obligatorio.</span>
                <span data-ng-show='modificar.tipo.$error.minlength && !modificar.tipo.$pristine'>Debe tener al menos 3 caracteres.</span>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success" value="Enviar" data-ng-init="" data-ng-disabled="!modificar.$valid">Modificar</button>
                <a href="?roles/listar/<?php echo $admin_json->token; ?>" type="button" class="btn btn-danger" value="Enviar" data-ng-init="">Volver</a>
            </div>
        </form>
    </div>
</div>
<?php $contenido = ob_get_clean(); ?>
<?php 
    /*Función para cargar plantilla en la configuración*/
    $ruta_plantillas = PLANTILLAS.'plantilla_admin.php';
    //echo '<br/>'.$ruta_plantillas;
    require_once $ruta_plantillas;
?>
