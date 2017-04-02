<?php
if(isset($nombre_archivo)) {
    $nombre_archivo_json = json_decode($nombre_archivo);
    var_dump($nombre_archivo_json);
?>
<?php ob_start() ?>
    <h2>Resultado de la conversión</h2>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<?php 
if(isset($usuario)) {
    $usuario_json = json_decode($usuario);
    var_dump($usuario_json);
    
?>
    <div  data-ng-app="RepositorioApp" data-ng-controller="SubidaArchivoFormController">
    <button type="button" class="btn btn-default btn-lg btn-block" data-ng-click="abreFormSubida()">Subir al repositorio</button>
    <div class="modal modal-content">
        <script type="text/ng-template" id="formSubidaArchivo.html">
                <div class="modal-header">
                    <h3 class="modal-title">Formulario de subida de archivos</h3>
                </div>
                <form name="guardarArchivo" class="form-horizontal" role="form" action="?archivos/alta/<?php echo $usuario_json->usuario_id; ?>/<?php echo $usuario_json->token; ?>" method="POST">
                    <div class="modal-body">
                            <div class="form-group">
                                <input 
                                    type="hidden"
                                    disabled
                                    name="usuario_id"
                                    id="usuario_id"
                                    data-ng-model="altaModelo.usuario_id"
                                    data-ng-init="altaModelo.usuario_id = <?php echo $usuario_json->usuario_id; ?>"
                                    value="<?php echo $usuario_json->usuario_id; ?>">{{altaModelo.usuario_id}}
                            </div>
                            <div class="form-group">
                                <input 
                                    type="text"
                                    name="token"
                                    id="token"
                                    data-ng-model="altaModelo.token"
                                    data-ng-init="altaModelo.token = <?php echo $usuario_json->token; ?>"
                                    value="<?php echo $usuario_json->token; ?>">{{altaModelo.token}}
                            </div>
                            <div class="form-group">
                                <label class="control-label ">Nombre</label>
                                <input type="text" 
                                       name="nombre" 
                                       class="form-control" 
                                       id="nombre" 
                                       data-ng-model="altaModelo.nombre"
                                       data-ng-minlength="3"
                                       required>
                                <span data-ng-show='alta.nombre.$error.required && !alta.nombre.$pristine'>El nombre es obligatorio.</span>
                                <span data-ng-show='alta.nombre.$error.minlength && !alta.nombre.$pristine'>Debe tener al menos 3 caracteres.</span>
                            </div>
                            <div class="form-group">
                                <label class="control-label ">Categorías</label>
                                <select class="form-control">
                                    <!--Debería devolver a esta vista las categorías ya existentes en la base de datos-->
                                    <option>Categoría 1</option>
                                    <option>Categoría 2</option>
                                    <option>Categoría 3</option>
                                    <option>Categoría 4</option>
                                </select>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <a data-ng-click="subirArchivo(altaModelo)" data-ng-disabled="!guardarArchivo.$valid" type="submit" class="btn btn-primary">Subir</a>
                        <a data-ng-click="closeThisDialog()" type="button" class="btn btn-primary">Cancelar</a>
                    </div>
                </form>
        </script>
    </div>
    </div>
<?php
}
?>
    <a href="?archivos/descargar/<?php echo $nombre_archivo_json->nombre; ?>" type="button" class="btn btn-default btn-lg btn-block">Descargar</a>
</div>
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