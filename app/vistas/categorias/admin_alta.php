<?php
if(isset($admin)) {
    $admin_json = json_decode($admin);
    //var_dump($admin_json);
}

if(isset($listaCategorias)) {
    $listaCategorias_json = json_decode($listaCategorias);
    //var_dump($listaCategorias_json);
}

if(isset($resultado)) {
    $resultado_json = json_decode($resultado);
    var_dump($resultado_json);
}
?>
<?php ob_start() ?>
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
        <h2>Alta categoría</h2>
        <?php if( isset($resultado_json->estado_p) ) { ?>
            <?php if( $resultado_json->estado_p === "200 OK") { ?>
                <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><?php echo $resultado_json->Mensaje; ?></div>
                <a href="?categorias/listar/<?php echo $admin_json->token; ?>" type="button" class="btn btn-success" value="Enviar" data-ng-init="">Volver</a>
            <?php } else { ?>
                <div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button><?php echo $resultado_json->Mensaje; ?></div>
                <a href="?categorias/listar/<?php echo $admin_json->token; ?>" type="button" class="btn btn-info" value="Enviar" data-ng-init="">Volver</a>
            <?php } ?>
        <?php } elseif(!isset ($resultado_json)) { ?>
            <form name="alta" class="form-horizontal" role="form" action="?categorias/alta/<?php echo $admin_json->token ?>" method="POST">
                <div class="form-group">
                    <label class="control-label">Nombre de la categoría</label>
                    <input type="nombre" 
                           name="nombre" 
                           class="form-control" 
                           data-ng-model="altaModelo.email" 
                           required>
                </div>
                <div class="form-group">
                    <label class="control-label">Categoría padre</label>
                    <select class="form-control" name="categoria_padre" id="categoria_padre">
                        <option selected value="">Ninguna</option>
                        <?php foreach ($listaCategorias_json as $obj) { ?>
                        <option value="<?php echo $obj->categoria_id ?>"><?php echo utf8_decode($obj->nombre); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success" value="Enviar" data-ng-init="resgistroDialog()" data-ng-disabled="!alta.$valid">Alta</button>
                    <a href="?categorias/listar/<?php echo $admin_json->token; ?>" type="button" class="btn btn-danger" value="Enviar" data-ng-init="">Cancelar</a>
                </div>
            </form>
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