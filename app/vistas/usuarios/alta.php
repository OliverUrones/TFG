<?php ob_start(); ?>
<h2>Formulario para el registro</h2>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" data-ng-app="altaApp" data-ng-controller="altaAppCtrl as vm">
    <form class="form-horizontal" role="form" action="?usuarios/alta" method="POST">
        <div class="form-group has-error" data-ng-class="vm.clase_nombre">
            <label class="control-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" id="nombre" data-ng-model="vm.nombre" data-ng-keyup="vm.comprobarNombre()">
        </div>
        <div class="form-group text-info" data-ng-class="vm.clase_mensaje_nombre">
            {{vm.mensaje_nombre}}
        </div>
        <div class="form-group has-success">
            <label class="control-label">Apellidos</label>
            <input type="text" name="apellidos" class="form-control" id="apellidos">
        </div>
        <div class="form-group has-error" data-ng-class="vm.clase_email">
            <label class="control-label">E-mail</label>
            <input type="email" name="email" placeholder="correo@correo.es" class="form-control" data-ng-model="vm.email" data-ng-keyup="vm.comprobarEmail()">
        </div>
        <div class="form-group text-info" data-ng-class="vm.clase_mensaje_email">
            {{vm.mensaje_email}}
        </div>
        <div class="form-group has-error" data-ng-class="vm.clase_pass1">
            <label class="control-label">Contraseña</label>
            <input type="password" name="password" placeholder="******" class="form-control" data-ng-model="vm.pass1" data-ng-keyup="vm.comprobarLongitud()">
        </div>
        <div class="form-group text-info" data-ng-class="vm.clase_mensaje_pass1">
            {{vm.mensaje_pass1}}
        </div>
        <div class="form-group has-error" data-ng-class="vm.clase_pass2">
            <label class="control-label">Repita la contraseña</label>
            <input type="password" name="password_repeat" placeholder="******" class="form-control" data-ng-model="vm.pass2" data-ng-keyup="vm.comprobarPass()">
        </div>
        <div class="form-group text-info" data-ng-class="vm.clase_mensaje_pass2">
            {{vm.mensaje_pass2}}
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success" value="Enviar" data-ng-init="abrirDialog()">Registrarse</button>
        </div>
    </form>
    <?php
        //Si vienen la respuesta del alta se muestra la ventana modal con el mensaje
        if(isset($registro)) {
    ?>
    <script type="text/ng-template" id="popupTmpl.html">
            <div class="modal-header">
                <h3 class="modal-title">Estado del registro</h3>
            </div>
            <div class="modal-body">
                <div>
                <?php
                    $registro = json_decode($registro); 
                    //var_dump($registro);
                    echo $registro->Mensaje;
                ?>
                </div>
            </div>
    </script>
    <?php } ?>
</div>
<?php $contenido = ob_get_clean(); ?>
<?php 
    /*Función para cargar plantilla en la configuración*/
    $ruta_plantillas = PLANTILLAS.'plantilla.php';
    //echo '<br/>'.$ruta_plantillas;
    require_once $ruta_plantillas;
?>