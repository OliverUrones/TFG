<?php
/**
 * @author A. Oliver Urones García
 * @copyleft (cc) 2017, Oliver Urones
 * @license https://creativecommons.org/licenses/by-nc-sa/4.0/ Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0)
 * @version 1.0
 * 
 * Vista del listado de usuarios para la parte de administración
 * 
 * La vista recibe las siguientes variables del controlador
 * $usuarios Datos del los usuarios en el sistema
 * @var string JSON
 * 
 * $admin Datos del administrador conectado
 * @var string JSON
 */
if(isset($admin)) {
    $admin_json = json_decode($admin);
    //var_dump($admin_json);
}

if(isset($usuarios)) {
    $usuarios_json = json_decode($usuarios);
    //var_dump($usuarios_json);
}
?>
<?php ob_start() ?>
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" ng-app="usuarios" ng-controller="ListadoUsuariosController">
        <h2>Listado de usuarios</h2>
<!--        <input type="text" class="input-group-addon form-control" ng-model="textoBusqueda">-->
<!--        <div>{{usuarios}}</div>-->
        <?php if(isset($usuarios_json))  { ?>
        <?php $key = 0; foreach ($usuarios_json as $obj) { ?>
            <ng-model-options ng-model-options="{ getterSetter: true }">
                <ng-model ng-model="usuarios[<?php echo $key; ?>].email = '<?php echo $obj->email ?>'"></ng-model>
                <ng-model ng-model="usuarios[<?php echo $key; ?>].nombre = '<?php echo utf8_decode($obj->nombre); ?>'"></ng-model>
                <ng-model ng-model="usuarios[<?php echo $key; ?>].apellidos = '<?php echo utf8_decode($obj->apellidos) ?>'"></ng-model>
                <ng-model ng-model="usuarios[<?php echo $key; ?>].fecha_creacion = '<?php echo $obj->fecha_creacion; ?>'"></ng-model>
                <ng-model ng-model="usuarios[<?php echo $key; ?>].tipo = '<?php echo $obj->tipo; ?>'"></ng-model>
                <?php if(strcmp($obj->estado, '1')==0) { ?>
                    <ng-model ng-model="usuarios[<?php echo $key; ?>].estado = '<?php echo 'Activada' ?>'"></ng-model>
                <?php } else { ?>
                    <ng-model ng-model="usuarios[<?php echo $key; ?>].estado = '<?php echo 'Desactivada' ?>'"></ng-model>
                <?php } ?>
                <ng-model ng-model="usuarios[<?php echo $key; ?>].enlace_modificar = '?usuarios/modificar/<?php echo $obj->usuario_id; ?>/<?php echo $admin_json->token; ?>'"></ng-model>
                <ng-model ng-model="usuarios[<?php echo $key; ?>].img_modificar = '../web/imagenes/Admin/administracion_editar.png'"></ng-model>
                <ng-model ng-model="usuarios[<?php echo $key; ?>].enlace_borrar = '?usuarios/baja/<?php echo $obj->usuario_id; ?>/<?php echo $admin_json->token; ?>'"></ng-model>
                <ng-model ng-model="usuarios[<?php echo $key; ?>].img_borrar = '../web/imagenes/Admin/administracion_borrar.png'"></ng-model>
            </ng-model-options>
        <?php $key++; } ?>
        <form class="form-inline">
            <div class="form-group has-feedback">
                <a href="?usuarios/altaAdmin/<?php echo $admin_json->token; ?>" class="btn btn-default"><span class="glyphicon glyphicon-user"></span> <span class="glyphicon glyphicon-plus-sign"></span></a>
<!--                <input type="text" class="form-control" ng-model="textoBusqueda" placeholder="Filtrar...">
                <i class="glyphicon glyphicon-search form-control-feedback"></i>-->
            </div>
        </form>
        
        <table class="table table-striped table-hover" id="resultadosBusqueda" ng-table="tableParams">
<!--                <thead class="bg-primary">
                    <tr>
                        <td>Email</td>
                        <td>Nombre</td>
                        <td>Apellidos</td>
                        <td>Fecha de Creación</td>
                        <td>Tipo de Rol</td>
                        <td>Estado de la cuenta</td>
                        <td>Acciones</td>
                    </tr>
                </thead>-->
                <tbody>
                    <tr ng-repeat="usuario in $data | filter:textoBusqueda:strict | orderBy:usuario.email">
                        <td data-title="'Email'" sortable="'email'" filter="{email: 'text'}">{{usuario.email}}</td>
                        <td data-title="'Nombre'" sortable="'nombre'" filter="{nombre: 'text'}">{{usuario.nombre}}</td>
                        <td data-title="'Apellidos'" sortable="'apellidos'" filter="{apellidos: 'text'}">{{usuario.apellidos}}</td>
                        <td data-title="'Fecha de Creación'" sortable="'fecha'" filter="{fecha: 'text'}">{{usuario.fecha_creacion}}</td>
                        <td data-title="'Tipo'" sortable="'tipo'" filter="{tipo: 'text'}">{{usuario.tipo}}</td>
                        <td data-title="'estado'" sortable="'estado'" filter="{estado: 'text'}">{{usuario.estado}}</td>
                        <td data-title="'Acciones'">
                            <a href="{{usuario.enlace_modificar}}"><img class="img" src="{{usuario.img_modificar}}"></a>
                            <a href="{{usuario.enlace_borrar}}"><img class="img" src="{{usuario.img_borrar}}"></a>
                        </td>
                    </tr>
                    <?php //$key = 0; foreach ($usuarios_json as $obj) { ?>
<!--                            <tr ng-model-options="{ getterSetter: true }">
                                <td ng-model="usuarios[<?php echo $key; ?>].email = '<?php echo $obj->email ?>'">{{ usuarios[<?php echo $key ?>].email }}</td>
                                <td ng-model="usuarios[<?php echo $key; ?>].nombre = '<?php echo utf8_decode($obj->nombre); ?>'">{{ usuarios[<?php echo $key; ?>].nombre }}</td>
                                <td ng-model="usuarios[<?php echo $key; ?>].apellidos = '<?php echo utf8_decode($obj->apellidos) ?>'">{{ usuarios[<?php echo $key; ?>].apellidos }}</td>
                                <td ng-model="usuarios[<?php echo $key; ?>].fecha_creacion = '<?php echo $obj->fecha_creacion ?>'">{{ usuarios[<?php echo $key; ?>].fecha_creacion }}</td>
                                <td ng-model="usuarios[<?php echo $key; ?>].tipo = '<?php echo $obj->tipo; ?>'">{{ usuarios[<?php echo $key; ?>].tipo }}</td>
                                <td ng-model="usuarios[<?php echo $key; ?>].estado = <?php echo $obj->estado; ?>">{{ usuarios[<?php echo $key; ?>].estado }}</td>
                                <td ng-model="usuarios[<?php echo $key; ?>].estado = <?php echo $obj->estado; ?>"><?php if(strcmp($obj->estado, '1')==0) { echo "Activada"; } else { echo "Desactivada"; } ?></td>
                                <td>
                                    <a href="?usuarios/modificar/<?php echo $obj->usuario_id; ?>/<?php echo $admin_json->token; ?>"><img class="img" src="../web/imagenes/Admin/administracion_editar.png" ></a>
                                    <a href="?usuarios/baja/<?php echo $obj->usuario_id; ?>/<?php echo $admin_json->token; ?>"><img class="img" src="../web/imagenes/Admin/administracion_borrar.png" ></a>
                                </td>
                            </tr>-->
                    <?php //$key++; } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</div>
<?php $contenido = ob_get_clean(); ?>
<?php 
    /*Función para cargar plantilla en la configuración*/
    $ruta_plantillas = PLANTILLAS.'plantilla_admin.php';
    //echo '<br/>'.$ruta_plantillas;
    require_once $ruta_plantillas;
?>