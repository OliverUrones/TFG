<?php //var_dump($usuario); 
    if(isset($usuario)) {
        $usuario_json = json_decode($usuario);
        //var_dump($usuario_json);
    }
    
    if(isset($archivos)) {
        $archivos_json = json_decode($archivos);
        //var_dump($archivos_json);
    }
?>
<?php ob_start(); ?>
<?php 
    if(isset($usuario_json->token)) {
?>
    <h2 class="page-header">Bienvenido <?php echo $usuario_json->nombre ?></h2>
    <?php if(isset($archivos_json)) { ?>
        <ul class="nav nav-tabs nav-justified">
            <li class="">
                <a href="?usuarios/perfil/<?php echo $usuario_json->usuario_id ?>/<?php echo $usuario_json->token ?>"><span class="glyphicon glyphicon glyphicon-user"></span>Mis datos</a>
            </li>
            <li class="active">
                <a href="?archivos/listar/<?php echo $usuario_json->usuario_id ?>/<?php echo $usuario_json->token ?>"><span class="glyphicon glyphicon-file"></span>Mis archivos</a>
            </li>
        </ul>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php if(isset($archivos_json->Mensaje)) { ?>
                <h2><?php echo $archivos_json->Mensaje; ?></h2>
            <?php } else { ?>
                <?php //var_dump($archivos_json); ?>
            <table class="table table-responsive table-bordered text-center table-hover">
                <thead>
                    <tr>
                        <td>Nombre</td>
                        <td>Categoría</td>
                        <td>Enlace de descarga</td>
<!--                        <td>Acciones</td>-->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($archivos_json as $obj) { ?>
                        <tr>
                            <td><?php echo $obj->nombre; ?><span class="glyphicon glyphicon-file"></span></td>
                            <td><?php echo $obj->nombre_categoria; ?><span class="glyphicon glyphicon-list-alt"></span></td>
                            <td><a type="button" href="?archivos/descargarArchivo/<?php echo $obj->enlace_descarga; ?>"><span class="glyphicon glyphicon-save"></span>Descargar2</a></td>
<!--                            <td><span class=".glyphicon .glyphicon-remove"></span></td>-->
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php } ?>
        </div>
    <?php } else { ?>
        <ul class="nav nav-tabs nav-justified">
            <li class="active">
                <a href="?usuarios/perfil/<?php echo $usuario_json->usuario_id ?>/<?php echo $usuario_json->token ?>"><span class="glyphicon glyphicon glyphicon-user"></span>Mis datos</a>
            </li>
            <li class="">
                <a href="?archivos/listar/<?php echo $usuario_json->usuario_id ?>/<?php echo $usuario_json->token ?>"><span class="glyphicon glyphicon-file"></span>Mis archivos</a>
            </li>
        </ul>
    
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <table>
                <?php var_dump($usuario_json); ?>
            </table>
        </div>
    <?php } ?>
<?php
    } else {
?>
    <h2>No tiene permiso para ver esta página</h2>
<?php
    }
?>
<?php $contenido = ob_get_clean(); ?>
<?php 
    /*Función para cargar plantilla en la configuración*/
    $ruta_plantillas = PLANTILLAS.'plantilla.php';
    //echo '<br/>'.$ruta_plantillas;
    require_once $ruta_plantillas;
?>