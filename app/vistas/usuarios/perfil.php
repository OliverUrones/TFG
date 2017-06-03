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
                <a href="?usuarios/perfil/<?php echo $usuario_json->usuario_id ?>/<?php echo $usuario_json->token ?>"><span class="glyphicon glyphicon glyphicon-user"></span> Mis datos</a>
            </li>
            <li class="active">
                <a href="?archivos/listar/<?php echo $usuario_json->usuario_id ?>/<?php echo $usuario_json->token ?>"><span class="glyphicon glyphicon-file"></span> Mis archivos</a>
            </li>
        </ul>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" ng-app="archivos" ng-controller="ListadoArchivosController">
            <?php if(isset($archivos_json->Mensaje)) { ?>
                <h2><?php echo $archivos_json->Mensaje; ?></h2>
            <?php } else { ?>
                <?php //var_dump($archivos_json); ?>
                <?php if(isset($archivos_json)) { ?>
                <table class="table table-striped table-hover" ng-table="tableParams">
                    <?php $key=0; foreach ($archivos_json as $obj) { ?>
                        <ng-model-options ng-model-options="{ getterSetter: true }">
                            <ng-model ng-model="archivos[<?php echo $key; ?>].archivo_id  = '<?php echo utf8_decode($obj->archivo_id); ?>'"></ng-model>
                            <ng-model ng-model="archivos[<?php echo $key; ?>].token  = '<?php echo utf8_decode($usuario_json->token); ?>'"></ng-model>
                            <ng-model ng-model="archivos[<?php echo $key; ?>].nombre  = '<?php echo utf8_decode($obj->nombre); ?>'"></ng-model>
                            <ng-model ng-model="archivos[<?php echo $key; ?>].nombre_categoria  = '<?php echo utf8_decode($obj->nombre_categoria); ?>'"></ng-model>
                            <ng-model ng-model="archivos[<?php echo $key; ?>].enlace_descarga  = '<?php echo $obj->enlace_descarga; ?>'"></ng-model>
                            <?php if($obj->ambito==0) { ?>
                                <ng-model ng-model="archivos[<?php echo $key; ?>].ambito = '<?php echo 'Privado' ?>'"></ng-model>
                            <?php } else { ?>
                                <ng-model ng-model="archivos[<?php echo $key; ?>].ambito = '<?php echo 'Público' ?>'"></ng-model>
                            <?php } ?>
                            <ng-model ng-model="archivos[<?php echo $key; ?>].etiquetas  = '<?php echo utf8_decode($obj->etiquetas); ?>'"></ng-model>
                            <ng-model ng-model="archivos[<?php echo $key; ?>].enlace_modificar = '?archivos/modificar/<?php echo $obj->archivo_id; ?>/<?php echo $usuario_json->token; ?>'"></ng-model>
                            <ng-model ng-model="archivos[<?php echo $key; ?>].img_modificar = 'web/imagenes/Admin/administracion_editar.png'"></ng-model>
<!--                            <ng-model ng-model="archivos[<?php echo $key; ?>].enlace_borrar = 'abreBorradoArchivo(<?php echo $obj->archivo_id; ?>, \'<?php echo $usuario_json->token; ?>\''"></ng-model>-->
                            <ng-model ng-model="archivos[<?php echo $key; ?>].img_borrar = 'web/imagenes/Admin/administracion_borrar.png'"></ng-model>
                        </ng-model-options>
                    <?php $key++; } ?>
                <?php } ?>
<!--                <thead class="bg-primary">
                    <tr>
                        <td>Nombre</td>
                        <td>Categoría</td>
                        <td>Ámbito</td>
                        <td>Etiquetas</td>
                        <td>Enlace de descarga</td>
                        <td>Acciones</td>
                    </tr>
                </thead>-->
                <tbody>
                    <tr ng-repeat="archivo in $data">
                        <td data-title="'Nombre'" sortable="'nombre'">{{archivo.nombre}}</td>
                        <td data-title="'Categoria'" sortable="'nombre_categoria'">{{archivo.nombre_categoria}}</td>
                        <td data-title="'Ambito'" sortable="'ambito'">
                            <span ng-class="(archivo.ambito == 'Público') ? 'glyphicon glyphicon-eye-open' : 'glyphicon glyphicon-eye-close'"></span>
                            {{archivo.ambito}}
                        </td>
                        <td data-title="'Etiquetas'" sortable="'etiquetas'">{{archivo.etiquetas}}</td>
                        <td data-title="'Descarga'" sortable="'enlace_descarga'"><span class="glyphicon glyphicon-save"></span> <a type="button" href="?archivos/descargarArchivo/{{archivo.enlace_descarga}}">Descargar</a></td>
                        <td data-title="'Acciones'">
                            <a href="{{archivo.enlace_modificar}}"><img src="{{archivo.img_modificar}}"></a>
                            <a ng-click="abreBorradoArchivo(archivo.archivo_id, archivo.token)" href="#"><img src="{{archivo.img_borrar}}"></a>
                        </td>
                    </tr>
                    <?php foreach ($archivos_json as $obj) { ?>
<!--                        <tr>
                            <td><span class="glyphicon glyphicon-file"></span> <?php echo utf8_decode($obj->nombre); ?></td>
                            <td><span class="glyphicon glyphicon-list-alt"></span> <?php echo utf8_decode($obj->nombre_categoria); ?></td>
                            <td><span class="glyphicon glyphicon-save"></span> <a type="button" href="?archivos/descargarArchivo/<?php echo $obj->enlace_descarga; ?>">Descargar</a></td>
                            <td>
                                <?php if($obj->ambito==0) { ?>
                                    <span class="glyphicon glyphicon-eye-close"></span> Privado
                                <?php } else { ?>
                                    <span class="glyphicon glyphicon-eye-open"></span> Público
                                <?php } ?>
                            </td>
                            <td>
                                <a href="?archivos/modificar/<?php echo $obj->archivo_id; ?>/<?php echo $usuario_json->token; ?>"><img class="img" src="web/imagenes/Admin/administracion_editar.png" ></a>
                                <a data-ng-click="abreBorradoArchivo(<?php echo $obj->archivo_id; ?>, '<?php echo $usuario_json->token; ?>');" href="#"><img class="img" src="web/imagenes/Admin/administracion_borrar.png" ></a>
                            </td>
                        </tr>-->
                        <div class="modal modal-content">
                            <script type="text/ng-template" id="confirmaBorrado.html">
                                <div ng-if="archivoBorradoModelo.estado_p == '200 OK'">
                                    <div class="modal-header">
                                        <h3 class="modal-title">Borrar archivo</h3>
                                    </div>
                                    <form name="borrarArchivo" class="form-horizontal" role="form" action="?archivos/baja/<?php echo $obj->archivo_id; ?>/<?php echo $usuario_json->token; ?>" method="POST">
                                        <div class="modal-body">
                                            <p>¿Está seguro que desea borrar el archivo?</p>
                                            <table class="table table-responsive table-bordered table-hover">
                                                <thead class="bg-info">
                                                    <tr>
                                                        <td>Nombre</td>
                                                        <td>Categoría</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <input
                                                            type="hidden"
                                                            value="{{archivoBorradoModelo.archivo_id}}"
                                                            disabled>
                                                        <td>{{archivoBorradoModelo.nombre}}</td>
                                                        <td>{{archivoBorradoModelo.nombre_categoria}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <a type="button" data-ng-click="borraArchivo(archivoBorradoModelo); abreResultadoBorrado();" type="submit" class="btn btn-primary">Confirmar</a>
                                            <a data-ng-click="closeThisDialog()" type="button" class="btn btn-primary">Cancelar</a>
                                        </div>
                                    </form>
                                </div>
                                
                                <div ng-if="archivoBorradoModelo.estado_p == '400 KO'">
                                    <div class="modal-header">
                                        <h3 class="modal-title">Error</h3>
                                    </div>
                                        <div class="modal-body">                                            
                                            <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"></button><strong>¡Error! </strong>{{archivoBorradoModelo.Mensaje}}</div>
                                        </div>
                                        <div class="modal-footer">
                                            <a type="button" href="?usuarios/login" class="btn btn-primary">Login</a>
                                        </div>
                                </div>
                            </script>
                        </div>
                        <div class="modal modal-content">
                            <script type="text/ng-template" id="resultadoBorrado.html">
                            <div ng-if="archivoBorradoModelo.resultado.estado_p == '200 OK'">
                                <div class="modal-header">
                                    <h3 class="modal-title">Resultado del borrado</h3>
                                </div>
                                <div class="modal-body">
                                    {{archivoBorradoModelo.resultado.Mensaje}}
                                </div>
                                <div class="modal-footer">
                                    <a type="button" class="btn btn-primary" href="?archivos/listar/<?php echo $usuario_json->usuario_id; ?>/<?php echo $usuario_json->token; ?>">Volver</a>
                                </div>
                            </div>
                            
                            <div ng-if="archivoBorradoModelo.resultado.estado_p == '400 KO'">
                                <div class="modal-header">
                                    <h3 class="modal-title">Error al borrar el archivo</h3>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"></button><strong>¡Error! </strong>{{archivoBorradoModelo.resultado.Mensaje}}</div>
                                </div>
                                <div class="modal-footer">
                                    <a type="button" class="btn btn-primary" href="?usuarios/login">Login</a>
                                </div>
                            </div>
                            </script>
                        </div>
                    <?php } ?>
                </tbody>
            </table>
            <?php } ?>
        </div>
    <?php } else { ?>
        <ul class="nav nav-tabs nav-justified">
            <li class="active">
                <a href="?usuarios/perfil/<?php echo $usuario_json->usuario_id ?>/<?php echo $usuario_json->token ?>"><span class="glyphicon glyphicon glyphicon-user"></span> Mis datos</a>
            </li>
            <li class="">
                <a href="?archivos/listar/<?php echo $usuario_json->usuario_id ?>/<?php echo $usuario_json->token ?>"><span class="glyphicon glyphicon-file"></span> Mis archivos</a>
            </li>
        </ul>
    
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-app="usuarios" ng-controller="EliminarCuentaController">
                <?php //var_dump($usuario_json); ?>
            <div class="form-group has-feedback">
                <a href="?usuarios/modificarDatos/<?php echo $usuario_json->usuario_id; ?>/<?php echo $usuario_json->token; ?>" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span> Modificar datos</a>
                <a href="?usuarios/cambiarPass/<?php echo $usuario_json->usuario_id; ?>/<?php echo $usuario_json->token; ?>" class="btn btn-default"><span class="glyphicon glyphicon-lock"></span> Cambiar contraseña</a>
<!--                <a ng-click="eliminarCuenta();" href="?usuarios/eliminar/<?php echo $usuario_json->usuario_id; ?>/<?php echo $usuario_json->token; ?>" class="btn btn-default"><span class="glyphicon glyphicon-remove-circle"></span> Eliminar cuenta</a>-->
                <a ng-click="abrirConfirmacionBorrado();" class="btn btn-default"><span class="glyphicon glyphicon-remove-circle"></span> Eliminar cuenta</a>
            </div>
<!--            <div class="btn-group btn-group-md">
                <button type="button" class="btn btn-default">Modificar mis datos</button>
                <button type="button" class="btn btn-default">Cambiar contraseña</button>
                <button type="button" class="btn btn-default">Eliminar cuenta</button>
            </div>-->
            <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
                <form>
                    <div class="form-group">
                        <h3><label class="control-label">Email</label></h3>
                        <h3>
                            <input 
                                class="form-control"
                                readonly
                                value="<?php echo $usuario_json->email ?>">
                        </h3>
                    </div>
                    <div class="form-group">
                        <h3><label class="control-label">Nombre y Apellidos</label></h3>
                        <h3>
                            <input 
                                class="form-control"
                                readonly
                                value="<?php echo $usuario_json->nombre ?> <?php echo $usuario_json->apellidos ?>">
                        </h3>
                    </div>
                    <div class="form-group">
                        <h3><label class="control-label">Fecha de creación</label></h3>
                        <h3>
                            <input 
                                class="form-control"
                                readonly
                                value="<?php echo $usuario_json->fecha_creacion ?>">
                        </h3>
                    </div>
                </form>
            </div>
            <div class="modal modal-content">
                <script type="text/ng-template" id="eliminarCuenta.html">
                    <form name="guardarArchivo" class="form-horizontal" role="form" action="" method="POST">
                        <div class="modal-header">
                            <h3 class="modal-title">¿Está seguro de que desea borrar su cuenta?</h3>
                        </div>
                        <div class="modal-body">
                            También se borrarán sus archivos subidos al repositorio
                            <input 
                                type="hidden"
                                disabled
                                name="usuario_id"
                                id="usuario_id"
                                ng-model="usuarioABorrar.usuario_id"
                                data-ng-init="usuarioABorrar.usuario_id = '<?php echo $usuario_json->usuario_id; ?>'"
                                value="<?php echo $usuario_json->usuario_id; ?>">
                            <input 
                                type="hidden"
                                disabled
                                name="token"
                                id="token"
                                ng-model="usuarioABorrar.token"
                                data-ng-init="usuarioABorrar.token = '<?php echo $usuario_json->token; ?>'"
                                value="<?php echo $usuario_json->token; ?>">
                        </div>
                        {{usuarioABorrar}}
                        <div class="modal-footer">
                            <a data-ng-click="eliminarCuenta(usuarioABorrar); closeThisDialog(); abreResultadoBaja();" type="button" class="btn btn-primary">Confirmar</a>
                            <a data-ng-click="closeThisDialog()" type="button" class="btn btn-danger">Cancelar</a>
                        </div>
                    <form>
                </script>
            </div>

            <div class="modal modal-content" data-ng-app="RepositorioApp">
                <script type="text/ng-template" id="resultadoBajaCuenta.html">
                    <div class="modal-header">
                        <h3 class="modal-title">Eliminación de la cuenta</h3>
                    </div>
                    <div class="modal-body">
                        {{usuarioABorrar.resultado.Mensaje}}
                    </div>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-primary" href="?home/index">Salir</a> 
                    </div>
                </script>
            </div>
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
