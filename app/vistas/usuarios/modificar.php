<?php
if(isset($usuario)) {
    $usuario_json = json_decode($usuario);
    //var_dump($usuario_json);
}
?>
<?php ob_start() ?>
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
        <?php if( (isset($usuario_json->accion) && $usuario_json->accion === 'modificar') && (isset($usuario_json->estado_p) && $usuario_json->estado_p === '200 OK') ) { ?>
            <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><?php echo $usuario_json->Mensaje; ?></div>
        <?php } ?>
        <h2>Modificar mis datos</h2>
        <form name="modificar" class="form-horizontal" role="form" action="?usuarios/modificarDatos/<?php echo $usuario_json->usuario_id; ?>/<?php echo $usuario_json->token; ?>" method="POST">
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
                <input type="text"
                       name="email"
                       class="form-control"
                       id="email"
                       value="<?php echo $usuario_json->email; ?>"
                       required>
            </div>
            <div class="form-group">
                <label class="control-label">Nombre</label>
                <input type="text"
                       name="nombre"
                       class="form-control"
                       id="nombre"
                       value="<?php echo $usuario_json->nombre; ?>"
                       required>
            </div>
            <div class="form-group">
                <label class="control-label">Apellidos</label>
                <input type="text"
                       name="apellidos"
                       class="form-control"
                       id="apellidos"
                       value="<?php echo $usuario_json->apellidos; ?>"
                       required>
            </div>
            <div class="form-group">
                <label class="control-label">Fecha de Creación</label>
                <p class="form-control-static" name="fecha_creacion" id="fecha_creacion"><?php echo $usuario_json->fecha_creacion; ?></p>
            </div>
            <div class="form-group">
                <label class="control-label">Estado de la cuenta</label>
                <?php if(strcmp($usuario_json->estado, '1')==0) { ?>
                    <p>Activada</p>
                <?php } else { ?>
                    <p>Desactivada</p>
                <?php }  ?>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success" value="Enviar" data-ng-init="" data-ng-disabled="!modificar.$valid">Modificar</button>
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