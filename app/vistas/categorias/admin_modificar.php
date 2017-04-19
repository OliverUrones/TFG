<?php 
if(isset($categoria)) {
    $categoria_json = json_decode($categoria);
    //var_dump($categoria_json);
}

if(isset($admin)) {
    $admin_json = json_decode($admin);
    //var_dump($admin_json);
}
?>
<?php ob_start() ?>
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
        <h2>Modificar categoría</h2>
        <form name="modificar" class="form-horizontal" role="form" action="?rol/modificar/<?php echo $admin_json->token; ?>" method="POST">
            <div class="form-group">
                <label class="control-label">Categoría ID</label>
                <input type="text"
                       name="rol_id"
                       class="form-control"
                       id="rol_id"
                       data-ng-model=""
                       value="<?php echo $categoria_json->categoria_id; ?>"
                       required
                       readonly>
            </div>
            <div class="form-group">
                <label class="control-label">Nombre</label>
                <input type="text"
                       name="rol_id"
                       class="form-control"
                       id="rol_id"
                       data-ng-model=""
                       value="<?php echo $categoria_json->nombre; ?>"
                       required
                       >
            </div>
            <div class="form-group">
                <label class="control-label">Categoría padre ID</label>
                <input type="text"
                       name="rol_id"
                       class="form-control"
                       id="rol_id"
                       data-ng-model=""
                       value="<?php echo $categoria_json->categoria_padre; ?>"
                       required
                       >
            </div>
            <div class="form-group">
                <label class="control-label">Nombre categoría padre ID</label>
                <input type="text"
                       name="rol_id"
                       class="form-control"
                       id="rol_id"
                       data-ng-model=""
                       value="<?php echo $categoria_json->padre; ?>"
                       required
                       >
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success" value="Enviar" data-ng-init="" data-ng-disabled="!alta.$valid">Modificar</button>
                <button type="button" class="btn btn-danger" value="Enviar" data-ng-init="" data-ng-disabled="!alta.$valid" onclick="window.history.back();">Cancelar</button>
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
