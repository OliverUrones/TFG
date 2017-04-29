<?php
if(isset($usuario)) {
    $usuario_json = json_decode($usuario);
}

if(isset($archivos)) {
    $archivos_json = json_decode($archivos);
    //var_dump($archivos_json);
}

if(isset($admin)) {
    $admin_json = json_decode($admin);
    //var_dump($admin_json);
}
?>
<?php ob_start() ?>
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" ng-app="archivos" ng-controller="ListadoArchivosController">
        <h2>Listado de archivos</h2>
        <div>BUSCAR <input ng-model="textoBusqueda"></div>
<!--        <div>{{archivos}}</div>-->
        <?php if(isset($archivos_json)) { ?>
            <?php $key=0; foreach ($archivos_json as $obj) { ?>
                <ng-model-options ng-model-options="{ getterSetter: true }">
                    <ng-model ng-model="archivos[<?php echo $key; ?>].nombre  = '<?php echo utf8_decode($obj->nombre); ?>'"></ng-model>
                    <ng-model ng-model="archivos[<?php echo $key; ?>].enlace_descarga  = '<?php echo $obj->enlace_descarga; ?>'"></ng-model>
                    <ng-model ng-model="archivos[<?php echo $key; ?>].nombre_usuario  = '<?php echo utf8_decode($obj->nombre_usuario); ?>'"></ng-model>
                    <ng-model ng-model="archivos[<?php echo $key; ?>].nombre_categoria  = '<?php echo utf8_decode($obj->nombre_categoria); ?>'"></ng-model>
                    <?php if($obj->ambito==0) { ?>
                        <ng-model ng-model="archivos[<?php echo $key; ?>].ambito = '<?php echo 'Privado' ?>'"></ng-model>
                    <?php } else { ?>
                        <ng-model ng-model="archivos[<?php echo $key; ?>].ambito = '<?php echo 'Público' ?>'"></ng-model>
                    <?php } ?>
                    <ng-model ng-model="archivos[<?php echo $key; ?>].enlace_modificar = '?archivos/modificarAdmin/<?php echo $obj->archivo_id; ?>/<?php echo $admin_json->token; ?>'"></ng-model>
                    <ng-model ng-model="archivos[<?php echo $key; ?>].img_modificar = '../web/imagenes/Admin/administracion_editar.png'"></ng-model>
                    <ng-model ng-model="archivos[<?php echo $key; ?>].enlace_borrar = '?archivos/bajaAdmin/<?php echo $obj->archivo_id; ?>/<?php echo $admin_json->token; ?>'"></ng-model>
                    <ng-model ng-model="archivos[<?php echo $key; ?>].img_borrar = '../web/imagenes/Admin/administracion_borrar.png'"></ng-model>
                </ng-model-options>
            <?php $key++; } ?>
        <?php } ?>
        <table class="table table-striped table-hover">
            <thead class="bg-primary">
                <tr>
                    <td>Nombre del Archivo</td>
                    <td>Enlace_descarga</td>
                    <td>Propietario</td>
                    <td>Categoría</td>
<!--                    <td>Valoración</td>-->
                    <td>Ámbito</td>
                    <td>Acciones</td>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="archivo in archivos | filter:textoBusqueda:strict">
                    <td>{{archivo.nombre}}</td>
                    <td>{{archivo.enlace_descarga}}</td>
                    <td>{{archivo.nombre_usuario}}</td>
                    <td>{{archivo.nombre_categoria}}</td>
                    <td>{{archivo.ambito}}</td>
                    <td>
                        <a href="{{archivo.enlace_modificar}}"><img class="img" src="{{archivo.img_modificar}}"></a>
                        <a href="{{archivo.enlace_borrar}}"><img class="img" src="{{archivo.img_borrar}}"></a>
                    </td>
                </tr>
                <?php // if(isset($archivos_json)) { ?>
                    <?php // foreach ($archivos_json as $obj) { ?>
<!--                        <tr>
                            <td><?php echo utf8_decode($obj->nombre); ?></td>
                            <td><?php echo $obj->enlace_descarga; ?></td>
                            <td><?php echo utf8_decode($obj->nombre_usuario); ?></td>
                            <td><?php echo utf8_decode($obj->nombre_categoria); ?></td>
                            <td><?php //echo $obj->puntuacion ?></td>
                            <td>
                                <?php if($obj->ambito==0) { ?>
                                    <span class="glyphicon glyphicon-eye-close"></span> Privado
                                <?php } else { ?>
                                    <span class="glyphicon glyphicon-eye-open"></span> Público
                                <?php } ?>
                            </td>
                            <td>
                                <a href="?archivos/modificarAdmin/<?php echo $obj->archivo_id; ?>/<?php echo $admin_json->token; ?>"><img class="img" src="../web/imagenes/Admin/administracion_editar.png"></a>
                                <a href="?archivos/bajaAdmin/<?php echo $obj->archivo_id; ?>/<?php echo $admin_json->token; ?>"><img class="img" src="../web/imagenes/Admin/administracion_borrar.png">
                            </td>
                        </tr>-->
                    <?php // } ?>
                <?php // } ?>
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