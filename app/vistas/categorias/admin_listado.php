<?php
if(isset($admin)) {
    $admin_json = json_decode($admin);
}

if(isset($categorias)) {
    $categorias_json = json_decode($categorias);
    //var_dump($categorias_json);
}
?>
<?php ob_start() ?>
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
        <h2>Listado de categorías</h2>
        <div>BUSCAR</div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <td>ID Categoria</td>
                    <td>Nombre</td>
                    <td>ID Categoría Padre</td>
                    <td>Nombre Categoría Padre</td>
                    <td>Acciones</td>
                </tr>
            </thead>
            <tbody>
                <?php if(isset($categorias_json))  { ?>
                    <?php foreach ($categorias_json as $obj) { ?>
                        <tr>
                            <td><?php echo $obj->categoria_id ?></td>
                            <td><?php echo utf8_decode($obj->nombre); ?></td>
                            <td><?php echo $obj->categoria_padre ?></td>
                            <td><?php echo $obj->padre ?></td>
                            <td>
                                <a href="?categorias/modificar/<?php echo $obj->categoria_id; ?>/<?php echo $admin_json->token; ?>"><img class="img" src="../web/imagenes/Admin/administracion_editar.png" ></a>
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