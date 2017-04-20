<?php
if(isset($admin)) {
    $admin_json = json_decode($admin);
}

if(isset($usuarioBorrar)) {
    $usuarioBorrar_json = json_decode($usuarioBorrar);
    var_dump($usuarioBorrar_json);
}

if(isset($borrado)) {
    $borrado_json = json_decode($borrado);
    //var_dump("Usuario Borrado: ".$borrado_json);
}
?>
<?php ob_start() ?>
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <?php if(isset($admin_json) && isset($usuarioBorrar_json)) { ?>
        <h2>Borrar usuario</h2>
        <form name="baja" class="form-horizontal" role="form" action="?usuarios/baja/<?php echo $admin_json->token; ?>" method="POST">
            <div class="form-group">
                <input type="hidden"
                       name="usuario_id"
                       class="form-control"
                       id="usuario_id"
                       data-ng-model=""
                       value="<?php echo $usuarioBorrar_json->usuario_id; ?>"
                       required
                       readonly>
            </div>
            <div class="form-group">
                <label class="control-label">Email</label>
                <p class="form-control-static"><?php echo $usuarioBorrar_json->email; ?></p>
            </div>
            <div class="form-group">
                <label class="control-label">Nombre</label>
                <p class="form-control-static"><?php echo $usuarioBorrar_json->nombre; ?></p>
            </div>
            <div class="form-group">
                <label class="control-label">Apellidos</label>
                <p class="form-control-static"><?php echo $usuarioBorrar_json->apellidos; ?></p>
            </div>
            <div class="form-group">
                <label class="control-label">Fecha de Creación</label>
                <p class="form-control-static"><?php echo $usuarioBorrar_json->fecha_creacion; ?></p>
            </div>
            <div class="form-group">
                <label class="control-label">Estado de la cuenta</label>
                <p class="form-control-static"><?php if(strcmp($usuarioBorrar_json->estado, '1') === 0) { echo "Activada"; } else { echo "Desactivada"; } ?></p>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success" value="Enviar">Borrar</button>
                <button type="button" class="btn btn-danger" value="Enviar"onclick="window.history.back();">Cancelar</button>
            </div>
        </form>
    <?php } elseif (isset($admin_json) && isset ($borrado_json) ) { ?>
        <?php if(strcmp($borrado_json->estado_p, "200 OK")== 0) {?>
            <div class="alert alert-success"><?php echo $borrado_json->Mensaje ?></div>
        <?php } else { ?>
            <div class="alert alert-danger"><?php echo $borrado_json->Mensaje ?></div>
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