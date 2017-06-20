<?php
/**
 * @author A. Oliver Urones García
 * @copyleft (cc) 2017, Oliver Urones
 * @license https://creativecommons.org/licenses/by-nc-sa/4.0/ Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0)
 * @version 1.0
 * 
 * Vista del listado de categorías para la parte de administración
 * 
 * La vista recibe las siguientes variables del controlador
 * $categorias Datos de las categorías del sistema
 * @var string JSON
 * 
 * $admin Datos del administrador conectado
 * @var string JSON
 */
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
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" ng-app="categorias" ng-controller="ListadoCategoriasController">
        <h2>Listado de categorías</h2>
<!--        {{categorias}}-->
        <?php if(isset($categorias_json)) { ?>
            <?php $key = 0; foreach ($categorias_json as $obj) { ?>
                <ng-model-options ng-model-options="{ getterSetter: true }">
                    <ng-model ng-model="categorias[<?php echo $key; ?>].categoria_id  = '<?php echo $obj->categoria_id; ?>'"></ng-model>
                    <ng-model ng-model="categorias[<?php echo $key; ?>].nombre  = '<?php echo utf8_decode($obj->nombre); ?>'"></ng-model>
                    <ng-model ng-model="categorias[<?php echo $key; ?>].padre  = '<?php echo utf8_decode($obj->padre); ?>'"></ng-model>
                    <ng-model ng-model="categorias[<?php echo $key; ?>].enlace_modificar = '?categorias/modificar/<?php echo $obj->categoria_id; ?>/<?php echo $admin_json->token; ?>'"></ng-model>
                    <ng-model ng-model="categorias[<?php echo $key; ?>].img_modificar = '../web/imagenes/Admin/administracion_editar.png'"></ng-model>
                    <ng-model ng-model="categorias[<?php echo $key; ?>].enlace_borrar = '?categorias/baja/<?php echo $obj->categoria_id; ?>/<?php echo $admin_json->token; ?>'"></ng-model>
                    <ng-model ng-model="categorias[<?php echo $key; ?>].img_borrar = '../web/imagenes/Admin/administracion_borrar.png'"></ng-model>
                </ng-model-options>
            <?php $key++; } ?>
        <?php } ?>
        <form class="form-inline">
            <div class="form-group has-feedback">
                <a href="?categorias/alta/<?php echo $admin_json->token; ?>" class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span> <span class="glyphicon glyphicon-plus-sign"></span></a>
<!--                <input type="text" class="form-control" ng-model="textoBusqueda" placeholder="Filtrar...">
                <i class="glyphicon glyphicon-search form-control-feedback"></i>-->
            </div>
        </form>
        <table class="table table-striped table-hover" ng-table='tableParams'>
<!--            <thead class="bg-primary">
                <tr>
                    <td>Nombre</td>
                    <td>Nombre Categoría Padre</td>
                    <td>Acciones</td>
                </tr>
            </thead>-->
            <tbody>
                <tr ng-repeat="categoria in $data | filter:textoBusqueda">
                    <td data-title="'Nombre'" sortable="'nombre'" filter="{nombre: 'text'}">{{categoria.nombre}}</td>
                    <td data-title="'Categoría padre'" sortable="'padre'" filter="{padre: 'text'}">{{categoria.padre}}</td>
                    <td data-title="'Acciones'" class="text-center">
                        <a href="{{categoria.enlace_modificar}}"><img class="img" src="{{categoria.img_modificar}}"></a>
                        <a href="{{categoria.enlace_borrar}}"><img class="img" src="{{categoria.img_borrar}}"></a>
                    </td>
                </tr>
                <?php //if(isset($categorias_json))  { ?>
                    <?php //foreach ($categorias_json as $obj) { ?>
<!--                        <tr>
                            <td><?php echo utf8_decode($obj->nombre); ?></td>
                            <td><?php echo $obj->padre ?></td>
                            <td>
                                <a href="?categorias/modificar/<?php echo $obj->categoria_id; ?>/<?php echo $admin_json->token; ?>"><img class="img" src="../web/imagenes/Admin/administracion_editar.png" ></a>
                                <img class="img" src="../web/imagenes/Admin/administracion_borrar.png" >
                            </td>
                        </tr>-->
                    <?php //} ?>
                <?php //} ?>
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