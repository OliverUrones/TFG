<?php 
if(isset($categoria)) {
    $categoria_json = json_decode($categoria);
    var_dump($categoria_json);
}

if(isset($admin)) {
    $admin_json = json_decode($admin);
    //var_dump($admin_json);
}
?>
<?php ob_start() ?>
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3" data-ng-app="categorias">
        <?php if( (isset($categoria_json->accion) && $categoria_json->accion === 'modificar') && (isset($categoria_json->estado_p) && $categoria_json->estado_p === '200 OK') ) { ?>
            <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"></button><?php echo $categoria_json->Mensaje; ?></div>
        <?php } ?>
        <h2>Modificar categoría</h2>
        <form name="modificar" class="form-horizontal" role="form" action="?categorias/modificar/<?php echo $admin_json->token; ?>" method="POST">
            <div class="form-group">
<!--                <label class="control-label">Categoría ID</label>-->
                <input type="hidden"
                       name="categoria_id"
                       class="form-control"
                       id="categoria_id"
                       data-ng-model="categoriaModificada.categoria_id"
                       data-ng-init="categoriaModificada.categoria_id = '<?php echo $categoria_json->categoria_id; ?>'"
                       value="<?php echo $categoria_json->categoria_id; ?>"
                       required
                       readonly>
            </div>
            <div class="form-group">
                <label class="control-label">Nombre</label>
                <input type="text"
                       name="nombre"
                       class="form-control"
                       id="nombre"
                       data-ng-model="categoriaModificada.nombre"
                       data-ng-init="categoriaModificada.nombre = '<?php echo $categoria_json->nombre; ?>'"
                       data-ng-minlength="3"
                       value="<?php echo $categoria_json->nombre; ?>"
                       required
                       >
                <span data-ng-show='modificar.nombre.$error.required && !modificar.nombre.$pristine'>El nombre es obligatorio.</span>
                <span data-ng-show='modificar.nombre.$error.minlength && !modificar.nombre.$pristine'>Debe tener al menos 3 caracteres.</span>
            </div>
<!--            <div class="form-group">
                <label class="control-label">Categoría padre ID</label>
                <input type="text"
                       name="rol_id"
                       class="form-control"
                       id="rol_id"
                       data-ng-model=""
                       value="<?php // echo $categoria_json->categoria_padre; ?>"
                       required
                       >
            </div>-->
<!--            <div class="form-group">
                <label class="control-label">Nombre categoría padre ID</label>
                <input type="text"
                       name="rol_id"
                       class="form-control"
                       id="rol_id"
                       data-ng-model=""
                       value="<?php //echo $categoria_json->padre; ?>"
                       required
                       >
            </div>-->
            <div class="form-group">
                <label class="control-label">Categoría padre</label>
                <select class="form-control" name="categoria_padre" id="categoria_padre">
                    <?php if(empty($categoria_json->categoria_padre)) {?>
                        <option selected value="">Ninguna</option>>
                    <?php } else { ?>
                        <option value="">Ninguna</option>
                    <?php } ?>
                    <?php foreach ($categoria_json->categorias as $key => $value) { ?>
                        <?php if($value->categoria_id === $categoria_json->categoria_padre) { ?>
                        <option selected value="<?php echo $value->categoria_id; ?>"><?php echo utf8_decode($value->nombre); ?></option>
                        <?php } else {?>
                            <option value="<?php echo $value->categoria_id; ?>"><?php echo utf8_decode($value->nombre); ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success" value="Enviar" data-ng-init="" data-ng-disabled="!modificar.$valid">Modificar</button>
                <a href="?categorias/listar/<?php echo $admin_json->token; ?>" type="button" class="btn btn-danger" value="Enviar" data-ng-init="">Volver</a>
            </div>
        </form>
    </div>
</div>
<?php $contenido = ob_get_clean(); ?>
<?php 
    /*Función para cargar plantilla en la configuración*/
    $ruta_plantillas = PLANTILLAS.'plantilla_admin.php';
    //echo '<br/>'.$ruta_plantillas;
    require_once $ruta_plantillas;
?>
