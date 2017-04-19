<?php
if(isset($admin)) {
    $admin_json = json_decode($admin);
    var_dump($admin_json);
}
?>
<?php ob_start() ?>
<!--Contenedor principal-->
<div class="container text-center">
    
    <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-7 col-lg-offset-2">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <a href="?usuarios/listar/<?php echo $admin_json->token; ?>">
                <div class="btn">
                    <img class="img" src="../web/imagenes/Admin/administracion_usuarios.png">
                    <h1 class="">Usuarios</h1>
                </div>
            </a>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <a href="?roles/listar/<?php echo $admin_json->token; ?>">
                <div class="btn">
                    <img class="img" src="../web/imagenes/Admin/administracion_roles.png">
                    <h1 class="">Roles</h1>
                </div>
            </a>
        </div>
    </div>

        <div class="clearfix"></div>
        
    <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-7 col-lg-offset-2">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <a href="?archivos/listarTodos/<?php echo $admin_json->token; ?>">
                <div class="btn">
                    <img class="img" src="../web/imagenes/Admin/administracion_archivos.png">
                    <h1 class="">Archivos</h1>
                </div>
            </a>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <a href="?categorias/listar/<?php echo $admin_json->token; ?>">
                <div class="btn">
                    <img class="img" src="../web/imagenes/Admin/administarcion_categorias.png">
                    <h1 class="">Categorias</h1>
                </div>
            </a>
        </div>
    </div>
    
</div>

















<?php $contenido = ob_get_clean(); ?>
<?php 
    /*Función para cargar plantilla en la configuración*/
    $ruta_plantillas = PLANTILLAS.'plantilla_admin.php';
    //echo '<br/>'.$ruta_plantillas;
    require_once $ruta_plantillas;
?>