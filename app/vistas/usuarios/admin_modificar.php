<?php
if(isset($usuario)) {
    $usuario_json = json_decode($usuario);
    var_dump($usuario_json);
}

if(isset($admin)) {
    $admin_json = json_decode($admin);
    //var_dump($admin_json);
}
?>
<?php ob_start() ?>
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3" data-ng-app="usuarios">
        <?php if( (isset($usuario_json->accion) && $usuario_json->accion === 'modificar') && (isset($usuario_json->estado_p) && $usuario_json->estado_p === '200 OK') ) { ?>
            <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"></button><?php echo $usuario_json->Mensaje; ?></div>
        <?php } ?>
        <h2>Modificar usuario</h2>
        <form name="modificar" class="form-horizontal" role="form" action="?usuarios/modificar/<?php echo $admin_json->token; ?>" method="POST">
            <div class="form-group">
<!--                <label class="control-label">ID</label>-->
                <input type="hidden"
                       name="usuario_id"
                       class="form-control"
                       id="usuario_id"
                       data-ng-model="usuarioModificado.usuario_id"
                       data-ng-init="usuarioModificado.usuario_id = '<?php echo $usuario_json->usuario_id; ?>'"
                       value="<?php echo $usuario_json->usuario_id; ?>"
                       required
                       readonly>
            </div>
<!--            <div class="form-group">
                <label class="control-label">Rol ID</label>
                <input type="text"
                       name="rol_id"
                       class="form-control"
                       id="rol_id"
                       data-ng-model=""
                       value="<?php // echo $usuario_json->rol_id; ?>"
                       required
                       >
            </div>-->
            <div class="form-group">
                <label class="control-label">Tipo de Rol</label>
                <select class="form-control" name="rol_id" id="rol_id">
                    <?php foreach ($usuario_json->roles as $key => $value) { ?>
                        <?php if($value->rol_id === $usuario_json->rol_id) { ?>
                            <option selected value="<?php echo $value->rol_id; ?>"><?php echo $value->tipo; ?></option>
                        <?php } else {?>
                            <option value="<?php echo $value->rol_id; ?>"><?php echo $value->tipo; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Email</label>
                <p class="form-control-static"><?php echo $usuario_json->email; ?></p>
<!--                <input type="text"
                       name="email"
                       class="form-control"
                       id="email"
                       data-ng-model=""
                       value="<?php //echo $usuario_json->email; ?>"
                       required
                       readonly>-->
            </div>
            <div class="form-group">
                <label class="control-label">Nombre</label>
                <input type="text"
                       name="nombre"
                       class="form-control"
                       id="nombre"
                       data-ng-model="usuarioModificado.nombre"
                       data-ng-init="usuarioModificado.nombre = '<?php echo $usuario_json->nombre; ?>'"
                       data-ng-minlength="3"
                       value="<?php echo $usuario_json->nombre; ?>"
                       required>
                <span data-ng-show='modificar.nombre.$error.required && !modificar.nombre.$pristine'>El nombre es obligatorio.</span>
                <span data-ng-show='modificar.nombre.$error.minlength && !modificar.nombre.$pristine'>Debe tener al menos 3 caracteres.</span>
            </div>
            <div class="form-group">
                <label class="control-label">Apellidos</label>
                <input type="text"
                       name="apellidos"
                       class="form-control"
                       id="apellidos"
                       data-ng-model="usuarioModificado.apellidos"
                       data-ng-init="usuarioModificado.apellidos = '<?php echo $usuario_json->apellidos; ?>'"
                       value="<?php echo $usuario_json->apellidos; ?>"
                       required>
            </div>
            <?php if(strlen($usuario_json->validez_token)) { ?>
            <div class="form-group">
                <label class="control-label">Validez token</label>
            <p class="form-control-static"><?php echo $usuario_json->validez_token; ?></p>
<!--                <input type="text"
                       name="validez_token"
                       class="form-control"
                       id="validez_token"
                       data-ng-model=""
                       value="<?php //echo $usuario_json->validez_token; ?>"
                       >-->
            </div>
            <?php } ?>
            <div class="form-group">
                <label class="control-label">Fecha de Creación</label>
                <p class="form-control-static" name="fecha_creacion" id="fecha_creacion"><?php echo $usuario_json->fecha_creacion; ?></p>
<!--                <input type="text"
                       name="fecha_creacion"
                       class="form-control"
                       id="fecha_creacion"
                       data-ng-model=""
                       value="<?php //echo $usuario_json->fecha_creacion; ?>"
                       required
                       readonly>-->
            </div>
<!--            <div class="form-group">
                <label class="control-label">Estado</label>
                <input type="text"
                       name="estado"
                       class="form-control"
                       id="estado"
                       data-ng-model=""
                       value="<?php //echo $usuario_json->estado; ?>">
            </div>-->
            <div class="form-group">
                <label class="control-label">Estado de la cuenta</label>
                <select class="form-control" id="estado" name="estado">
                    <?php if(strcmp($usuario_json->estado, '1')==0) { ?>
                        <option value="<?php echo $usuario_json->estado; ?>">Activada</option>
                        <option value="0">Desactivada</option>
                    <?php } else { ?>
                        <option value="<?php echo $usuario_json->estado; ?>">Desactivada</option>
                        <option value="1">Activada</option>
                    <?php }  ?>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success" value="Enviar" data-ng-init="" data-ng-disabled="!modificar.$valid">Modificar</button>
                <a href="?usuarios/listar/<?php echo $admin_json->token; ?>" type="button" class="btn btn-danger" value="Enviar" data-ng-init="">Volver</a>
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