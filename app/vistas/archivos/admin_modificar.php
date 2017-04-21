<?php
if(isset($archivo)) {
    $archivo_json = json_decode($archivo);
    //var_dump($archivo_json);
}

if(isset($admin)) {
    $admin_json = json_decode($admin);
    //var_dump($admin_json);
}
?>
<?php ob_start() ?>
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
        <?php if( (isset($archivo_json->accion) && $archivo_json->accion === 'modificar') && (isset($archivo_json->estado_p) && $archivo_json->estado_p === '200 OK') ) { ?>
            <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><?php echo $archivo_json->Mensaje; ?></div>
        <?php } ?>
        <h2>Modificar archivo</h2>
        <form name="modificar" class="form-horizontal" role="form" action="?archivos/modificar/<?php echo $admin_json->token; ?>" method="POST">
<!--            <div class="form-group">-->
<!--                <label class="control-label">ArchivoID</label>-->
                <input type="hidden"
                       name="archivo_id"
                       class="form-control"
                       id="archivo_id"
                       data-ng-model=""
                       value="<?php echo $archivo_json->archivo_id; ?>"
                       required
                       readonly>
<!--            </div>-->
<!--            <div class="form-group">-->
<!--                <label class="control-label">Usuario ID</label>-->
                <input type="hidden"
                       name="usuario_id"
                       class="form-control"
                       id="usuario_id"
                       data-ng-model=""
                       value="<?php echo $archivo_json->usuario_id; ?>"
                       required
                       readonly>
<!--            </div>-->
<!--            <div class="form-group">-->
<!--                <label class="control-label">Categoría ID</label>-->
<!--                <p class="form-control-static"><?php //echo $archivo_json->categoria_id; ?></p>-->
<!--                <input type="hidden"
                       name="categoria_id"
                       class="form-control"
                       id="categoria_id"
                       data-ng-model=""
                       value="<?php //echo $archivo_json->categoria_id; ?>"
                       required
                       readonly>-->
<!--            </div>-->
            <div class="form-group">
                <label class="control-label">Propietario del archivo</label>
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
                <p class="form-control-static"><?php echo $archivo_json->enlace_descarga; ?></p>
<!--                <input type="text"
                       name="enlace_descarga"
                       class="form-control"
                       id="enlace_descarga"
                       data-ng-model=""
                       value="<?php //echo $archivo_json->enlace_descarga; ?>"
                       required>-->
            </div>
            <div class="form-group">
                <label class="control-label">Puntuacion</label>
                <p class="form-control-static"><?php echo $archivo_json->puntuacion; ?></p>
<!--                <input type="text"
                       name="enlace_descarga"
                       class="form-control"
                       id="enlace_descarga"
                       data-ng-model=""
                       value="<?php //echo $archivo_json->enlace_descarga; ?>"
                       required>-->
            </div>
            <div class="form-group">
                <label class="control-label">Nombre de la categoría</label>
                <select class="form-control" name="categoria_id" id="categoria_id">
                    <?php foreach ($archivo_json->categorias as $key => $value) { ?>
                        <?php if($value->categoria_id === $archivo_json->categoria_id) { ?>
                            <option selected value="<?php echo $value->categoria_id; ?>"><?php echo $value->nombre; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $value->categoria_id; ?>"><?php echo $value->nombre; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
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
                <a href="?archivos/listarTodos/<?php echo $admin_json->token; ?>" type="button" class="btn btn-danger" value="Enviar" data-ng-init="" data-ng-disabled="!alta.$valid">Volver</a>
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