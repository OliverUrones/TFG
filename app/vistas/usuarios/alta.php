<?php ob_start(); ?>
<!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" data-ng-app="altaApp" data-ng-controller="altaAppCtrl">-->
<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-lg-offset-3 col-md-offset-3" data-ng-app="RepositorioApp" data-ng-controller="ValidacionFormsController">
    <h2>Formulario para el registro</h2>
    <form name="alta" class="form-horizontal" role="form" action="?usuarios/alta" method="POST">
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
            <label class="control-label">Apellidos</label>
            <input type="text"
                   name="apellidos" 
                   class="form-control" 
                   id="apellidos" 
                   data-ng-model="altaModelo.apellidos"
                   required>
            <span data-ng-show='alta.apellidos.$error.required && !alta.apellidos.$pristine'>Los apellidos son obligatorios.</span>
        </div>
        <div class="form-group">
            <label class="control-label">E-mail</label>
            <input type="email" 
                   name="email" 
                   placeholder="correo@correo.es" 
                   class="form-control" 
                   data-ng-model="altaModelo.email" 
                   required>
            <span data-ng-show='alta.email.$error.required && !alta.email.$pristine'>El email es obligatorio.</span>
            <span data-ng-show='alta.email.$error.email && !alta.email.$pristine'>El email no es válido.</span>
        </div>
        <div class="form-group">
            <label class="control-label">Contraseña</label>
            <input type="password" 
                   name="password" 
                   placeholder="******" 
                   class="form-control" 
                   data-ng-model="altaModelo.password" 
                   data-ng-minlength="8"
                   required>
            <span data-ng-show='alta.password.$error.required && !alta.password.$pristine'>La contraseña es obligatoria.</span>
            <span data-ng-show='alta.password.$error.minlength && !alta.password.$pristine'>La contraseña debe tener al menos 8 caracteres.</span>
        </div>
        <div class="form-group">
            <label class="control-label">Repita la contraseña</label>
            <input type="password" 
                   name="password_repeat" 
                   placeholder="******" 
                   class="form-control" 
                   data-ng-model="altaModelo.password_repeat" 
                   data-ng-minlength="8"
                   required>
            <span data-ng-show="altaModelo.password_repeat !== altaModelo.password">Las contraseñas no coinciden.</span>
            <span data-ng-show='alta.password_repeat.$error.minlength'>La contraseña debe tener al menos 8 caracteres.</span>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success" value="Enviar" data-ng-init="resgistroDialog()" data-ng-disabled="!alta.$valid">Registrarse</button>
        </div>
    </form>
    <?php
        //Si vienen la respuesta del alta se muestra la ventana modal con el mensaje
        if(isset($registro)) {
            $registro_json = json_decode($registro);
            //var_dump($registro_json);
    ?>
    <div class="modal modal-content">
        <script type="text/ng-template" id="respuestaRegistro.html">
                <div class="modal-header">
                    <h3 class="modal-title">Estado del registro</h3>
                </div>
                <div class="modal-body">
                    <div>
                    <?php
                    //print_r($registro_json);
                        //var_dump($registro_son);
                        echo $registro_json->Mensaje;
                    ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <a data-ng-click="closeThisDialog()" type="button" class="btn btn-primary">Cerrar</a>
                </div>
        </script>
    </div>

    <?php } ?>
</div>
<?php $contenido = ob_get_clean(); ?>
<?php 
    /*Función para cargar plantilla en la configuración*/
    $ruta_plantillas = PLANTILLAS.'plantilla.php';
    //echo '<br/>'.$ruta_plantillas;
    require_once $ruta_plantillas;
?>