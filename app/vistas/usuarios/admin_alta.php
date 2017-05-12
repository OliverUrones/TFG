<?php
if(isset($roles)) {
    $roles_json = json_decode($roles);
    //var_dump($roles_json);
}

if(isset($admin)) {
    $admin_json = json_decode($admin);
    //var_dump($admin_json);
}

if(isset($resultado)) {
    $resultado_json = json_decode($resultado);
    var_dump($resultado_json);
}
?>
<?php ob_start() ?>
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3" data-ng-app="RepositorioApp" data-ng-controller="ValidacionFormsController">
        <h2>Alta usuario</h2>
        <?php if( isset($resultado_json->estado_p) ) { ?>
            <?php if( $resultado_json->estado_p === "200 OK") { ?>
                <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"></button><?php echo $resultado_json->Mensaje; ?></div>
                <a href="?usuarios/altaAdmin/<?php echo $admin_json->token; ?>" type="button" class="btn btn-success" value="Enviar" data-ng-init="">Volver</a>
            <?php } else { ?>
                <div class="alert alert-info"><button type="button" class="close" data-dismiss="alert"></button><?php echo $resultado_json->Mensaje; ?></div>
                <a href="?usuarios/altaAdmin/<?php echo $admin_json->token; ?>" type="button" class="btn btn-info" value="Enviar" data-ng-init="">Volver</a>
            <?php } ?>
        <?php } elseif(!isset ($resultado_json)) { ?>
            <form name="alta" class="form-horizontal" role="form" action="?usuarios/altaAdmin/<?php echo $admin_json->usuario_id; ?>/<?php echo $admin_json->token ?>" method="POST">
                <div class="form-group">
                    <label class="control-label">E-mail</label>
                    <input type="email" 
                           name="email" 
                           placeholder="correo@correo.es" 
                           class="form-control" 
                           data-ng-model="altaModelo.email" 
                           required>
                    <span data-ng-show='alta.email.$error.required && !alta.email.$pristine'>El email es obligatorio.</span>
                    <span data-ng-show='alta.email.$error.email && !alta.email.$pristine'>El email no es válido.</span>
                </div>
                <div class="form-group">
                    <label class="control-label ">Nombre</label>
                    <input type="text" 
                           name="nombre" 
                           class="form-control" 
                           id="nombre" 
                           data-ng-model="altaModelo.nombre"
                           data-ng-minlength="3"
                           required>
                    <span data-ng-show='alta.nombre.$error.required && !alta.nombre.$pristine'>El nombre es obligatorio.</span>
                    <span data-ng-show='alta.nombre.$error.minlength && !alta.nombre.$pristine'>Debe tener al menos 3 caracteres.</span>
                </div>
                <div class="form-group">
                    <label class="control-label">Apellidos</label>
                    <input type="text"
                           name="apellidos" 
                           class="form-control" 
                           id="apellidos" 
                           data-ng-model="altaModelo.apellidos"
                           required>
                    <span data-ng-show='alta.apellidos.$error.required && !alta.apellidos.$pristine'>Los apellidos son obligatorios.</span>
                </div>
                <div class="form-group">
                    <label class="control-label">Rol</label>
                    <select class="form-control" name="rol_id" id="rol_id">
                        <?php if(isset($roles_json)) { ?>
                            <?php foreach ($roles_json as $rol) { ?>
                                <?php if($rol->rol_id === '2') { ?>
                                    <option selected value="<?php echo $rol->rol_id; ?>"><?php echo $rol->tipo; ?></option>
                                <?php } else { ?>
                                    <option value="<?php echo $rol->rol_id; ?>"><?php echo $rol->tipo; ?></option>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Activada</label>
                    <select class="form-control" name="estado" id="estado">
                        <option selected value="0">No</option>
                        <option value="1">Sí</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Contraseña</label>
                    <input type="password" 
                           name="password" 
                           placeholder="******" 
                           class="form-control" 
                           data-ng-model="altaModelo.password" 
                           data-ng-minlength="8"
                           required>
                    <span data-ng-show='alta.password.$error.required && !alta.password.$pristine'>La contraseña es obligatoria.</span>
                    <span data-ng-show='alta.password.$error.minlength && !alta.password.$pristine'>La contraseña debe tener al menos 8 caracteres.</span>
                </div>
                <div class="form-group">
                    <label class="control-label">Repita la contraseña</label>
                    <input type="password" 
                           name="password_repeat" 
                           placeholder="******" 
                           class="form-control" 
                           data-ng-model="altaModelo.password_repeat" 
                           data-ng-minlength="8"
                           required>
                    <span data-ng-show="altaModelo.password_repeat !== altaModelo.password">Las contraseñas no coinciden</span>
                    <span data-ng-show='alta.password.$error.minlength'>La contraseña debe tener al menos 8 caracteres.</span>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success" value="Enviar" data-ng-init="resgistroDialog()" data-ng-disabled="!alta.$valid">Alta</button>
                    <a href="?usuarios/listar/<?php echo $admin_json->token; ?>" type="button" class="btn btn-danger" value="Enviar" data-ng-init="">Cancelar</a>
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