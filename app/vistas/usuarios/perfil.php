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

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" data-ng-app="RepositorioApp" data-ng-controller="BorraArchivoController">
            <?php if(isset($archivos_json->Mensaje)) { ?>
                <h2><?php echo $archivos_json->Mensaje; ?></h2>
            <?php } else { ?>
                <?php //var_dump($archivos_json); ?>
            <table class="table table-responsive table-bordered table-hover">
                <thead class="bg-primary">
                    <tr>
                        <td>Nombre</td>
                        <td>Categoría</td>
                        <td>Enlace de descarga</td>
                        <td>Ámbito</td>
                        <td>Acciones</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($archivos_json as $obj) { ?>
                        <tr>
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
                        </tr>
                        <div class="modal modal-content">
                            <script type="text/ng-template" id="confirmaBorrado.html">
                                    <div class="modal-header">
                                        <h3 class="modal-title">Borrar archivo</h3>
                                    </div>
                                    <form name="borrarArchivo" class="form-horizontal" role="form" action="?archivos/baja/<?php echo $obj->archivo_id; ?>/<?php echo $usuario_json->token; ?>" method="POST">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                ID Archivo: {{archivo_id}}
                                                Token: {{token}}
                                            </div>
                                              <p>¿Está seguro que desea borrar el archivo?</p>  
                                            {{datos}}
                                        </div>
                                        <div class="modal-footer">
                                            <a type="button" data-ng-click="borraArchivo(datos); abreResultadoBorrado();" data-ng-disabled="!borrarArchivo.$valid" type="submit" class="btn btn-primary">Confirmar</a>
                                            <a data-ng-click="closeThisDialog()" type="button" class="btn btn-primary">Cancelar</a>
                                        </div>
                                    </form>
                            </script>
                        </div>
                        <div class="modal modal-content" data-ng-app="RepositorioApp">
                            <script type="text/ng-template" id="resultadoBorrado.html">
                                <div class="modal-header">
                                    <h3 class="modal-title">Resultado del borrado</h3>
                                </div>
                                <div class="modal-body">
                                    {{datos.resultado}}
                                </div>
                                <div class="modal-footer">
                                    <a type="button" class="btn btn-primary" href="?archivos/listar/<?php echo $usuario_json->usuario_id; ?>/<?php echo $usuario_json->token; ?>">Volver</a>
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