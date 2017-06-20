<?php
/**
 * @author A. Oliver Urones García
 * @copyleft (cc) 2017, Oliver Urones
 * @license https://creativecommons.org/licenses/by-nc-sa/4.0/ Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0)
 * @version 1.0
 * 
 * Vista del login de usuarios para la parte pública
 * 
 * La vista recibe las siguientes variables del controlador
 * $usuario Datos de la operación en caso de fallo
 * @var string JSON
 */
//var_dump($usuario); 
    if(isset($error)) {
        $error_json = json_decode($error);
        //var_dump($error_json);
    }
    if(isset($usuario)) {
        $usuario_json = json_decode($usuario);
        //var_dump($usuario_json);
    }
?>
<?php ob_start() ?>
<!--    <div data-ng-app="loginApp" data-ng-controller="loginAppCtrl">-->
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-lg-offset-3 col-md-offset-3">
        <h2>Login</h2>
        <?php if(isset($usuario_json) && $usuario_json->estado_p === '400 KO') { ?>
            <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><?php echo $usuario_json->Mensaje; ?></div>
        <?php } ?>
        <form name="loginForm" role="form" action="?usuarios/login" method="POST">
            <div class="form-group">
                <label class="control-label">Email</label>
                <input class="form-control"
                       type="text"
                       placeholder="corre@correo.es"
                       name="email_login"
                       data-ng-model="loginModelo.email"
                       autocomplete="off"
                       required>
                <span data-ng-show="loginForm.email_login.$error.required && !loginForm.email_login.$pristine">El email es obligatorio.</span>
                <span data-ng-show="loginForm.email_login.$error.email && !loginForm.email_login.$pristine">El email no es válido.</span>
            </div>
            <div class="form-group">
                <label class="control-label">Contraseña</label>
                <input class="form-control"
                       type="password"
                       placeholder="********"
                       name="password_login"
                       data-ng-model="loginModelo.password"
                       autocomplete="off"
                       required>
                <span data-ng-show='loginForm.password_login.$error.required && !loginForm.password_login.$pristine'>La contraseña es obligatoria.</span>
                <span data-ng-show='loginForm.password_login.$error.minlength && !loginForm.password_login.$pristine'>La contraseña debe tener al menos 8 caracteres.</span>
            </div>
            <div class="form-group">
                <a href="?usuarios/recordar">¿Ha olvidado la contraseña?</a>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success" data-ng-disabled="!loginForm.$valid" data-ng-click="login(loginModelo)">Entrar</button>
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