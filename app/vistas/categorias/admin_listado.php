<?php
if(isset($usuario)) {
    $usuario_json = json_decode($usuario);
}

if(isset($categorias)) {
    $categorias_json = json_decode($categorias);
    //var_dump($categorias_json);
}
?>
<?php ob_start() ?>
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h2>Listado de categorías</h2>
        <div>BUSCAR</div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <td>ID Categoria</td>
                    <td>Nombre</td>
                    <td>Categoría Padre</td>
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