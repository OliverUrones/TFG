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
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  table-responsive" ng-app="roles" ng-controller="ListadoRolesController">
        <h2>Listado de roles</h2>
<!--        {{roles}}-->
        <?php if(isset($roles_json))  { ?>
            <?php $key = 0; foreach ($roles_json as $obj) { ?>
                <ng-model-options ng-model-options="{ getterSetter: true }">
                    <ng-model ng-model="roles[<?php echo $key; ?>].rol_id  = '<?php echo $obj->rol_id; ?>'"></ng-model>
                    <ng-model ng-model="roles[<?php echo $key; ?>].tipo  = '<?php echo utf8_decode($obj->tipo); ?>'"></ng-model>
                    <ng-model ng-model="roles[<?php echo $key; ?>].enlace_modificar = '?roles/modifica/<?php echo $obj->rol_id; ?>/<?php echo $admin_json->token; ?>'"></ng-model>
                    <ng-model ng-model="roles[<?php echo $key; ?>].img_modificar = '../web/imagenes/Admin/administracion_editar.png'"></ng-model>
<!--                    <ng-model ng-model="roles[<?php echo $key; ?>].enlace_borrar = '?roles/bajaAdmin/<?php echo $obj->rol_id; ?>/<?php echo $admin_json->token; ?>'"></ng-model>-->
                    <ng-model ng-model="roles[<?php echo $key; ?>].img_borrar = '../web/imagenes/Admin/administracion_borrar.png'"></ng-model>
                </ng-model-options>
            <?php $key++; } ?>
        <?php } ?>
        <form class="form-inline">
            <div class="form-group has-feedback">
                <button class="btn btn-default"><span class="glyphicon glyphicon-credit-card"></span> <span class="glyphicon glyphicon-plus-sign"></span></button>
                <input type="text" class="form-control" ng-model="textoBusqueda" placeholder="Filtrar...">
                <i class="glyphicon glyphicon-search form-control-feedback"></i>
            </div>
        </form>
        
        <table class="table table-striped table-hover">
            <thead class="bg-primary">
                <tr>
                    <td>Tipo</td>
                    <td class="">Acciones</td>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="rol in roles | filter:textoBusqueda">
                    <td>{{rol.tipo}}</td>
                    <td>
                        <a href="{{rol.enlace_modificar}}"><img class="img" src="{{rol.img_modificar}}"></a>
                        <img class="img" src="{{rol.img_borrar}}">
                    </td>
                </tr>
                <?php // if(isset($roles_json))  { ?>
                    <?php // foreach ($roles_json as $obj) { ?>
<!--                        <tr>
                            <td><?php echo utf8_decode($obj->tipo); ?></td>
                            <td>
                                <a href="?roles/modificar/<?php echo $obj->rol_id; ?>/<?php echo $admin_json->token; ?>"><img class="img" src="../web/imagenes/Admin/administracion_editar.png" ></a>
                                <img class="img" src="../web/imagenes/Admin/administracion_borrar.png" >
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