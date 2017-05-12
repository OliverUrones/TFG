<?php 
if(isset($rol)) {
    $rol_json = json_decode($rol);
    var_dump($rol_json);
}

if(isset($admin)) {
    $admin_json = json_decode($admin);
    //var_dump($admin_json);
}
?>
<?php ob_start() ?>
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
        <?php if( (isset($rol_json->accion) && $rol_json->accion === 'modificar') && (isset($rol_json->estado_p) && $rol_json->estado_p === '200 OK') ) { ?>
            <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"></button><?php echo $rol_json->Mensaje; ?></div>
        <?php } ?>
        <h2>Modificar rol</h2>
        <form name="modificar" class="form-horizontal" role="form" action="?roles/modificar/<?php echo $admin_json->token; ?>" method="POST">
            <div class="form-group">
                <label class="control-label">ID</label>
                <input type="text"
                       name="rol_id"
                       class="form-control"
                       id="rol_id"
                       data-ng-model=""
                       value="<?php echo $rol_json->rol_id; ?>"
                       required
                       readonly>
            </div>
            <div class="form-group">
                <label class="control-label">Rol ID</label>
                <input type="text"
                       name="tipo"
                       class="form-control"
                       id="tipo"
                       data-ng-model=""
                       value="<?php echo $rol_json->tipo; ?>"
                       required
                       >
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success" value="Enviar" data-ng-init="" data-ng-disabled="!alta.$valid">Modificar</button>
                <a href="?roles/listar/<?php echo $admin_json->token; ?>" type="button" class="btn btn-danger" value="Enviar" data-ng-init="" data-ng-disabled="!alta.$valid">Volver</a>
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
