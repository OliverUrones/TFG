<?php
if(isset($archivo)) {
    $archivo_json = json_decode($archivo);
    //var_dump($usuario_json);
}

if(isset($admin)) {
    $admin_json = json_decode($admin);
    //var_dump($admin_json);
}
?>
<?php ob_start() ?>
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
        <h2>Modificar usuario</h2>
        <form name="modificar" class="form-horizontal" role="form" action="?archivos/modificar/<?php echo $admin_json->token; ?>" method="POST">
            <div class="form-group">
                <label class="control-label">ArchivoID</label>
                <input type="text"
                       name="archivo_id"
                       class="form-control"
                       id="archivo_id"
                       data-ng-model=""
                       value="<?php echo $archivo_json->archivo_id; ?>"
                       required
                       readonly>
            </div>
            <div class="form-group">
                <label class="control-label">Usuario ID</label>
                <input type="text"
                       name="rol_id"
                       class="form-control"
                       id="rol_id"
                       data-ng-model=""
                       value="<?php echo $archivo_json->usuario_id; ?>"
                       required
                       >
            </div>
            <div class="form-group">
                <label class="control-label">Categoría ID</label>
                <p class="form-control-static"><?php echo $archivo_json->categoria_id; ?></p>
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
                <label class="control-label">Nombre del archivo</label>
                <input type="text"
                       name="nombre"
                       class="form-control"
                       id="nombre"
                       data-ng-model=""
                       value="<?php echo $archivo_json->nombre; ?>"
                       required>
            </div>
            <div class="form-group">
                <label class="control-label">Enlace de descarga</label>
                <input type="text"
                       name="apellidos"
                       class="form-control"
                       id="apellidos"
                       data-ng-model=""
                       value="<?php echo $archivo_json->enlace_descarga; ?>"
                       required>
            </div>
            <div class="form-group">
                <label class="control-label">Nombre del usuario</label>
                <p class="form-control-static"><?php echo $archivo_json->nombre_usuario; ?></p>
<!--                <input type="text"
                       name="fecha_creacion"
                       class="form-control"
                       id="fecha_creacion"
                       data-ng-model=""
                       value="<?php //echo $usuario_json->fecha_creacion; ?>"
                       required
                       readonly>-->
            </div>
            <div class="form-group">
                <label class="control-label">Nombre de la categoría</label>
                <p class="form-control-static"><?php echo $archivo_json->nombre_categoria; ?></p>
<!--                <input type="text"
                       name="fecha_creacion"
                       class="form-control"
                       id="fecha_creacion"
                       data-ng-model=""
                       value="<?php //echo $usuario_json->fecha_creacion; ?>"
                       required
                       readonly>-->
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success" value="Enviar" data-ng-init="" data-ng-disabled="!alta.$valid">Modificar</button>
                <button type="button" class="btn btn-danger" value="Enviar" data-ng-init="" data-ng-disabled="!alta.$valid" onclick="window.history.back();">Cancelar</button>
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