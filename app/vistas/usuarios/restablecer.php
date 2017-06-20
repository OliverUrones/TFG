<?php
/**
 * @author A. Oliver Urones García
 * @copyleft (cc) 2017, Oliver Urones
 * @license https://creativecommons.org/licenses/by-nc-sa/4.0/ Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0)
 * @version 1.0
 * 
 * Vista para restablecer la contraseña de una cuenta de usuario para la parte pública
 * 
 * La vista recibe las siguientes variables del controlador
 * $usuario_id Identificador del usuario
 * @var string JSON
 * 
 * $respuesta Datos de la operación realizada
 * @var string JSON
 */
if(isset($usuario_id)) {
    $usuario_id_json = json_decode($usuario_id);
    //var_dump($usuario_id_json);
}
if(isset($respuesta)) {
    $respuesta_json = json_decode($respuesta);
}
?>
<?php ob_start() ?>
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3" ng-app="CambiarPass" ng-controller="CambiaPassController">
        <h2>Restablezca su contraseña</h2>
        <?php if(isset($respuesta_json)) { ?>
            <?php if( isset($respuesta_json->estado_p) && $respuesta_json->estado_p === '200 OK' ) { ?>
                <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"></button><?php echo $respuesta_json->Mensaje; ?></div>
            <?php } else { ?>
                <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"></button><?php echo $respuesta_json->Mensaje; ?></div>
            <?php } ?>
        <?php } ?>
        <?php if(isset($usuario_id_json)) { ?>
            <form name="cambiarPass" class="form-horizontal" role="form" action="?usuarios/restablecer/<?php echo $usuario_id_json->id ?>" method="POST">
<!--                <label class="control-label">ID</label>-->
                <input type="hidden"
                       name="usuario_id"
                       class="form-control"
                       id="usuario_id"
                       value="<?php echo $usuario_id_json->id; ?>"
                       required
                       readonly
                       required>
            <div class="form-group">
                <label class="control-label">Contraseña nueva</label>
                <input type="password"
                       name="password"
                       class="form-control"
                       id="password"
                       ng-model="cambioPass.password"
                       data-ng-minlength="8"
                       required>
                <span data-ng-show='cambiarPass.password.$error.required && !cambiarPass.password.$pristine'>La contraseña es obligatoria.</span>
                <span data-ng-show='cambiarPass.password.$error.minlength && !cambiarPass.password.$pristine'>La contraseña debe tener al menos 8 caracteres.</span>
            </div>
            <div class="form-group">
                <label class="control-label">Repetir contraseña nueva</label>
                <input type="password"
                       name="password_repeat"
                       class="form-control"
                       id="password_repeat"
                       ng-model="cambioPass.password_repeat"
                       data-ng-minlength="8"
                       required>
                <span data-ng-show='cambioPass.password_repeat !== cambioPass.password'>Las contraseñas no coinciden.</span>
                <span data-ng-show='cambiarPass.password_repeat.$error.minlength'>La contraseña debe tener al menos 8 caracteres.</span>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success" value="Enviar" data-ng-disabled="!cambiarPass.$valid">Modificar</button>
            </div>
            </form>
        <?php } else { ?>
            <p>
                <a href="?usuarios/login" class="btn btn-primary btn-lg" role="button">Login</a>
            </p>
        <?php } ?>
    </div>
</div>
<?php $contenido = ob_get_clean(); ?>
<?php 
    /*Función para cargar plantilla en la configuración*/
    $ruta_plantillas = PLANTILLAS.'plantilla.php';
    //echo '<br/>'.$ruta_plantillas;
    require_once $ruta_plantillas;
?>