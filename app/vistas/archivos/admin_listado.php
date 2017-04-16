<?php
if(isset($usuario)) {
    $usuario_json = json_decode($usuario);
}

if(isset($archivos)) {
    $archivos_json = json_decode($archivos);
    //var_dump($archivos_json);
}
?>
<?php ob_start() ?>
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h2>Listado de usuarios</h2>
        <div>BUSCAR</div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <td>ID Archivo</td>
                    <td>ID Usuario</td>
                    <td>Categoría</td>
                    <td>Nombre del Archivo</td>
                    <td>Enlace_descarga</td>
                    <td>Nombre del usuario</td>
                    <td>Nombre de la categoría</td>
                    <td>Acciones</td>
                </tr>
            </thead>
            <tbody>
                <?php if(isset($archivos_json)) { ?>
                    <?php foreach ($archivos_json as $obj) { ?>
                        <tr>
                            <td><?php echo $obj->archivo_id ?></td>
                            <td><?php echo $obj->usuario_id ?></td>
                            <td><?php echo $obj->categoria_id ?></td>
                            <td><?php echo $obj->nombre ?></td>
                            <td><?php echo $obj->enlace_descarga ?></td>
                            <td><?php echo $obj->nombre_usuario ?></td>
                            <td><?php echo $obj->nombre_categoria ?></td>
                            <td>
                                <span class="glyphicon glyphicon-edit"></span>
                                <span class="glyphicon glyphicon-remove"></span>
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