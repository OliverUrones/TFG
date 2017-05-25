<?php
if(isset($admin)) {
    $admin_json = json_decode($admin);
}

if(isset($categoriaBorrar)) {
    $categoriaBorrar_json = json_decode($categoriaBorrar);
    //var_dump($categoriaBorrar);
}

if(isset($borrado)) {
    $borrado_json = json_decode($borrado);
    //var_dump("Usuario Borrado: ".$borrado_json);
}
?>
<?php ob_start() ?>
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
    <?php if(isset($admin_json) && isset($categoriaBorrar_json)) { ?>
        <h2>Borrar categoría</h2>
        <form name="baja" class="form-horizontal" role="form" action="?categorias/baja/<?php echo $admin_json->token; ?>" method="POST">
            <div class="form-group">
                <input type="hidden"
                       name="categoria_id"
                       class="form-control"
                       id="categoria_id"
                       data-ng-model=""
                       value="<?php echo $categoriaBorrar_json->categoria_id; ?>"
                       required
                       readonly>
            </div>
            <div class="form-group">
                <label class="control-label">Nombre de la categoría</label>
                <p class="form-control-static"><?php echo $categoriaBorrar_json->nombre; ?></p>
            </div>
            <div class="form-group">
                <label class="control-label">Categoría padre</label>
                <p class="form-control-static"><?php echo ($categoriaBorrar_json->padre === "") ? 'Ninguna' : $categoriaBorrar_json->padre ?></p>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success" value="Enviar">Borrar</button>
                <a href="?categorias/listar/<?php echo $admin_json->token; ?>" type="button" class="btn btn-danger" value="Enviar" data-ng-init="" data-ng-disabled="!alta.$valid">Volver</a>
            </div>
        </form>
    <?php } elseif (isset($admin_json) && isset ($borrado_json) ) { ?>
        <?php if(strcmp($borrado_json->estado_p, "200 OK")== 0) {?>
            <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"></button><?php echo $borrado_json->Mensaje ?></div>
            <a href="?categorias/listar/<?php echo $admin_json->token; ?>" type="button" class="btn btn-success" value="Enviar" data-ng-init="" data-ng-disabled="!alta.$valid">Volver</a>
        <?php } else { ?>
            <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"></button><?php echo $borrado_json->Mensaje ?></div>
            <a href="?categorias/listar/<?php echo $admin_json->token; ?>" type="button" class="btn btn-danger" value="Enviar" data-ng-init="" data-ng-disabled="!alta.$valid">Volver</a>
        <?php } ?>
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