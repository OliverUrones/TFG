<?php
if(isset($usuario)) {
    $usuario_json = json_decode($usuario);
}

if(isset($archivos)) {
    $archivos_json = json_decode($archivos);
    //var_dump($archivos_json);
}

if(isset($admin)) {
    $admin_json = json_decode($admin);
    //var_dump($admin_json);
}
?>
<?php ob_start() ?>
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
        <h2>Listado de archivos</h2>
        <div>BUSCAR</div>
        <table class="table table-striped table-hover">
            <thead class="bg-primary">
                <tr>
                    <td>Nombre del Archivo</td>
                    <td>Enlace_descarga</td>
                    <td>Propietario</td>
                    <td>Categoría</td>
                    <td>Valoración</td>
                    <td>Acciones</td>
                </tr>
            </thead>
            <tbody>
                <?php if(isset($archivos_json)) { ?>
                    <?php foreach ($archivos_json as $obj) { ?>
                        <tr>
                            <td><?php echo $obj->nombre ?></td>
                            <td><?php echo $obj->enlace_descarga ?></td>
                            <td><?php echo $obj->nombre_usuario ?></td>
                            <td><?php echo $obj->nombre_categoria ?></td>
                            <td><?php echo $obj->puntuacion ?></td>
                            <td>
                                <a href="?archivos/modificar/<?php echo $obj->archivo_id; ?>/<?php echo $admin_json->token; ?>"><img class="img" src="../web/imagenes/Admin/administracion_editar.png"></a>
                                <a href="?archivos/baja/<?php echo $obj->archivo_id; ?>/<?php echo $admin_json->token; ?>"><img class="img" src="../web/imagenes/Admin/administracion_borrar.png">
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php $contenido = ob_get_clean(); ?>
<?php 
    /*Función para cargar plantilla en la configuración*/
    $ruta_plantillas = PLANTILLAS.'plantilla_admin.php';
    //echo '<br/>'.$ruta_plantillas;
    require_once $ruta_plantillas;
?>