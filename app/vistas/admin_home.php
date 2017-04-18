<?php ob_start() ?>
<!--Contenedor principal-->
<div class="container text-center">
    
    <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="btn">
                <img class="img img-thumbnail" src="../web/imagenes/Admin/administracion_usuarios.png">
                <h1 class="">Usuarios</h1>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="btn">
                <img class="img img-thumbnail" src="../web/imagenes/Admin/administracion_roles.png">
                <h1 class="">Roles</h1>
            </div>
        </div>
    </div>

        <div class="clearfix"></div>
        
    <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="btn">
                <img class="img img-thumbnail" src="../web/imagenes/Admin/administracion_archivos.png">
                <h1 class="">Archivos</h1>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="btn">
                <img class="img img-thumbnail" src="../web/imagenes/Admin/administracion_categorias.png">
                <h1 class="">Categorias</h1>
            </div>
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