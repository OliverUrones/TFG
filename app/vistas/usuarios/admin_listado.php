<?php
if(isset($usuario)) {
    $usuario_json = json_decode($usuario);
}

if(isset($usuarios)) {
    $usuarios_json = json_decode($usuarios);
    //var_dump($usuarios_json);
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
                    <td>ID Usuario</td>
                    <td>ID Rol</td>
                    <td>Tipo de Rol</td>
                    <td>Email</td>
                    <td>Nombre</td>
                    <td>Apellidos</td>
                    <td>Fecha de Creación</td>
                    <td>Estado de la cuenta</td>
                    <td>Acciones</td>
                </tr>
            </thead>
            <tbody>
                <?php if(isset($usuarios_json))  { ?>
                    <?php foreach ($usuarios_json as $obj) { ?>
                        <tr>
                            <td><?php echo $obj->usuario_id ?></td>
                            <td><?php echo $obj->rol_id ?></td>
                            <td><?php echo $obj->tipo ?></td>
                            <td><?php echo $obj->email ?></td>
                            <td><?php echo utf8_decode($obj->nombre); ?></td>
                            <td><?php echo utf8_decode($obj->apellidos) ?></td>
                            <td><?php echo $obj->fecha_creacion ?></td>
                            <td><?php echo $obj->estado ?></td>
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