<?php
if(isset($usuario)) {
    $usuario_json = json_decode($usuario);
}

if(isset($usuarioBorrar)) {
    $usuarioBorrar_json = json_decode($usuarioBorrar);
    var_dump($usuarioBorrar_json);
}
?>
<?php ob_start() ?>
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h2>Borrar usuario</h2>
        <form name="baja" class="form-horizontal" role="form" action="?usuarios/baja/<?php echo $usuario_json->token; ?>" method="POST">
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
    </div>
</div>
<?php $contenido = ob_get_clean(); ?>
<?php 
    /*Función para cargar plantilla en la configuración*/
    $ruta_plantillas = PLANTILLAS.'plantilla_admin.php';
    //echo '<br/>'.$ruta_plantillas;
    require_once $ruta_plantillas;
?>