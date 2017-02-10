<?php 
?>
<?php ob_start(); ?>
<h2>Formulario para el registro</h2>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <form class="form-horizontal" role="form" action="?usuarios/alta" method="POST">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" id="nombre">
        </div>
        <div class="form-group">
            <label>Apellidos</label>
            <input type="text" name="apellidos" class="form-control" id="apellidos">
        </div>
        <div class="form-group">
            <label>E-mail</label>
            <input type="text" name="email" placeholder="correo@correo.es" class="form-control">
        </div>
        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" name="password" placeholder="******" class="form-control">
        </div>
        <div class="form-group">
            <label>Repita la contraseña</label>
            <input type="password" name="password_repeat" placeholder="******" class="form-control">
        </div>
        <div class="form-group">
            <button type="submit" na class="btn btn-success" value="Enviar">Registrarse</button>
        </div>
    </form>
</div>
<?php $contenido = ob_get_clean(); ?>
<?php 
    /*Función para cargar plantilla en la configuración*/
    $ruta_plantillas = PLANTILLAS.'plantilla.php';
    //echo '<br/>'.$ruta_plantillas;
    require_once $ruta_plantillas;
?>