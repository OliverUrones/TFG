<?php ob_start() ?>
<!--    <div data-ng-app="loginApp" data-ng-controller="loginAppCtrl">-->
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-lg-offset-3 col-md-offset-3 col-sm-offset-3 col-xs-offset-3" data-ng-app="RepositorioApp" data-ng-controller="LoginFormController">
        <h2>Login</h2>
        <form name="loginForm" role="form" action="?usuarios/admin" method="POST">
            <div class="form-group">
                <label class="control-label">Email</label>
                <input class="form-control"
                       type="text"
                       placeholder="corre@correo.es"
                       name="email_login"
                       data-ng-model="loginModelo.email"
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
                       required>
                <span data-ng-show='loginForm.password_login.$error.required && !loginForm.password_login.$pristine'>La contraseña es obligatoria.</span>
                <span data-ng-show='loginForm.password_login.$error.minlength && !loginForm.password_login.$pristine'>La contraseña debe tener al menos 8 caracteres.</span>
            </div>
<!--            <div class="form-group">
                <a href="?usuarios/recordar">¿Ha olvidado la contraseña?</a>
            </div>-->
            <div class="form-group">
                <button type="submit" class="btn btn-success" data-ng-disabled="!loginForm.$valid" data-ng-click="login(loginModelo)">Entrar</button>
            </div>
        </form>
    </div>
<?php $contenido = ob_get_clean(); ?>
<?php 
    /*Función para cargar plantilla en la configuración*/
    $ruta_plantillas = PLANTILLAS.'plantilla_admin.php';
    //echo '<br/>'.$ruta_plantillas;
    require_once $ruta_plantillas;
?>