<?php
/**
 * @author A. Oliver Urones García
 * @copyleft (cc) 2017, Oliver Urones
 * @license https://creativecommons.org/licenses/by-nc-sa/4.0/ Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0)
 * @version 1.0
 * 
 * Vista para recordar la contraseña de una cuenta de usuario para la parte pública
 * 
 * La vista recibe las siguientes variables del controlador
 * $respuesta Datos de la operación realizada
 * @var string JSON
 */
if(isset($respuesta)) {
    $respuesta_json = json_decode($respuesta);
    //var_dump($respuesta_json);
}
?>
<?php ob_start() ?>
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3" ng-app="usuarios" ng-controller="RecordarController">
        <h2>¿Ha olvidado la contraseña?</h2>
        <?php if(isset($respuesta_json)) { ?>
            <?php if( isset($respuesta_json->estado_p) && $respuesta_json->estado_p === '200 OK' ) { ?>
                <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><?php echo $respuesta_json->Mensaje; ?></div>
            <?php } else { ?>
                <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><?php echo $respuesta_json->Mensaje; ?></div>
            <?php } ?>
        <?php } ?>
        <p>Introduzca su email y se le enviará un correo para restablecer su contraseña.</p>
        <form name="recordar" class="form-horizontal" role="form" action="?usuarios/recordar" method="POST">
            <div class="form-group">
                <label class="control-label">Email</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       id="email"
                       ng-model="recordarModelo.email"
                       required>
                <span data-ng-show="recordar.email.$error.required && !recordar.email.$pristine">El email es obligatorio.</span>
                <span data-ng-show="recordar.email.$error.email && !recordar.email.$pristine">El email no es válido.</span>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success" value="Enviar" data-ng-init="" data-ng-disabled="!recordar.$valid">Enviar</button>
                <a href="?usuarios/login" type="button" class="btn btn-danger" value="Enviar" data-ng-init="">Volver</a>
            </div>
        </form>
    </div>
</div>
<?php $contenido = ob_get_clean(); ?>
<?php 
    /*Función para cargar plantilla en la configuración*/
    $ruta_plantillas = PLANTILLAS.'plantilla.php';
    //echo '<br/>'.$ruta_plantillas;
    require_once $ruta_plantillas;
?>