<?php
if(isset($admin)) {
    $admin_json = json_decode($admin);
}

if(isset($roles)) {
    $roles_json = json_decode($roles);
    //var_dump($roles_json);
}
?>
<?php ob_start() ?>
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  table-responsive">
        <h2>Listado de roles</h2>
        <div>BUSCAR</div>
        <table class="table table-striped table-hover">
            <thead class="bg-primary">
                <tr>
                    <td>Tipo</td>
                    <td class="">Acciones</td>
                </tr>
            </thead>
            <tbody>
                <?php if(isset($roles_json))  { ?>
                    <?php foreach ($roles_json as $obj) { ?>
                        <tr>
                            <td><?php echo utf8_decode($obj->tipo); ?></td>
                            <td>
                                <a href="?roles/modificar/<?php echo $obj->rol_id; ?>/<?php echo $admin_json->token; ?>"><img class="img" src="../web/imagenes/Admin/administracion_editar.png" ></a>
                                <img class="img" src="../web/imagenes/Admin/administracion_borrar.png" >
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