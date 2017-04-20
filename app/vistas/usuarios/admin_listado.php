<?php
if(isset($admin)) {
    $admin_json = json_decode($admin);
    //var_dump($admin_json);
}

if(isset($usuarios)) {
    $usuarios_json = json_decode($usuarios);
    //var_dump($usuarios_json);
}
?>
<?php ob_start() ?>
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
        <h2>Listado de usuarios</h2>
        <div>BUSCAR</div>
        <table class="table table-striped table-hover">
            <thead class="bg-primary">
                <tr>
                    <td>Email</td>
                    <td>Nombre</td>
                    <td>Apellidos</td>
                    <td>Fecha de Creación</td>
                    <td>Tipo de Rol</td>
                    <td>Estado de la cuenta</td>
                    <td>Acciones</td>
                </tr>
            </thead>
            <tbody>
                <?php if(isset($usuarios_json))  { ?>
                    <?php foreach ($usuarios_json as $obj) { ?>
                        <tr>
                            <td><?php echo $obj->email ?></td>
                            <td><?php echo utf8_decode($obj->nombre); ?></td>
                            <td><?php echo utf8_decode($obj->apellidos) ?></td>
                            <td><?php echo $obj->fecha_creacion ?></td>
                            <td><?php echo $obj->tipo ?></td>
                            <td><?php if(strcmp($obj->estado, '1')==0) { echo "Activada"; } else { echo "Desactivada"; } ?></td>
                            <td>
                                <a href="?usuarios/modificar/<?php echo $obj->usuario_id; ?>/<?php echo $admin_json->token; ?>"><img class="img" src="../web/imagenes/Admin/administracion_editar.png" ></a>
                                <a href="?usuarios/baja/<?php echo $obj->usuario_id; ?>/<?php echo $admin_json->token; ?>"><img class="img" src="../web/imagenes/Admin/administracion_borrar.png" ></a>
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