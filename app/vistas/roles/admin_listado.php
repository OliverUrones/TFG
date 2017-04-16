<?php
if(isset($usuario)) {
    $usuario_json = json_decode($usuario);
}

if(isset($roles)) {
    $roles_json = json_decode($roles);
    //var_dump($roles_json);
}
?>
<?php ob_start() ?>
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h2>Listado de roles</h2>
        <div>BUSCAR</div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <td>ID Rol</td>
                    <td>Tipo</td>
                    <td>Acciones</td>
                </tr>
            </thead>
            <tbody>
                <?php if(isset($roles_json))  { ?>
                    <?php foreach ($roles_json as $obj) { ?>
                        <tr>
                            <td><?php echo $obj->rol_id ?></td>
                            <td><?php echo utf8_decode($obj->tipo); ?></td>
                            <td>
                                <span class="glyphicon glyphicon-edit"></span>
                                <span class="glyphicon glyphicon-remove"></span>
                            </td>                        </tr>
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