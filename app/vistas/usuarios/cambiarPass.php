<?php
if(isset($usuario)) {
    $usuario_json = json_decode($usuario);
    //var_dump($usuario_json);
}
?>
<?php ob_start() ?>
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3" ng-app="" ng-controller="">
        <?php if( (isset($usuario_json->accion) && $usuario_json->accion === 'modificar') && (isset($usuario_json->estado_p) && $usuario_json->estado_p === '200 OK') ) { ?>
            <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><?php echo $usuario_json->Mensaje; ?></div>
        <?php } ?>
        <h2>Cambio de contraseña</h2>
        <form name="cambiarPass" class="form-horizontal" role="form" action="?usuarios/modificarDatos/<?php echo $usuario_json->usuario_id; ?>/<?php echo $usuario_json->token; ?>" method="POST">
            <div class="form-group">
<!--                <label class="control-label">ID</label>-->
                <input type="hidden"
                       name="usuario_id"
                       class="form-control"
                       id="usuario_id"
                       value="<?php echo $usuario_json->usuario_id; ?>"
                       required
                       readonly
                       required>
            </div>
            <div class="form-group">
<!--                <label class="control-label">ID</label>-->
                <input type="hidden"
                       name="rol_id"
                       class="form-control"
                       id="rol_id"
                       value="<?php echo $usuario_json->rol_id; ?>"
                       required
                       readonly
                       required>
            </div>
            <div class="form-group">
                <label class="control-label">Email</label>
<!--                <p class="form-control-static"><?php //echo $usuario_json->email; ?></p>-->
                <p type="text"><?php echo $usuario_json->email; ?></p>
            </div>
            <div class="form-group">
                <label class="control-label">Contraseña nueva</label>
                <input type="text"
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
                <input type="text"
                       name="password_repeat"
                       class="form-control"
                       id="password_repeat"
                       ng-model="cambioPass.password_repeat"
                       data-ng-minlength="8"
                       required>
                <span data-ng-show="altaModelo.password_repeat !== altaModelo.password">Las contraseñas no coinciden</span>
                <span data-ng-show='cambiarPass.password.$error.minlength'>La contraseña debe tener al menos 8 caracteres.</span>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success" value="Enviar" data-ng-init="" data-ng-disabled="!cambiarPass.$valid">Modificar</button>
                <a href="?usuarios/perfil/<?php echo $usuario_json->usuario_id; ?>/<?php echo $usuario_json->token; ?>" type="button" class="btn btn-danger" value="Enviar" data-ng-init="">Volver</a>
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