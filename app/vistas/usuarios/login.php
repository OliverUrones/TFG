<?php ob_start() ?>
<aside class="col-xs-12 col-sm-4 col-md-3" data-ng-app="loginApp" data-ng-controller="loginAppCtrl">
    <h2>Login</h2>
    <form role="form" action="?usuarios/login" method="POST">
        <div class="form-group">
            <input class="form-control" type="text" placeholder="corre@correo.es" name="email" data-ng-model="loginModelo.email">
            <span data-ng-show='login.email.$error.required && !login.email.$pristine'>El email es obligatorio.</span>
            <span data-ng-show='login.email.$error.email && !login.email.$pristine'>El email no es válido.</span>
        </div>
        <div class="form-group">
            <input class="form-control" type="password" placeholder="********" name="password" data-ng-model="loginModelo.password">
            <span data-ng-show='login.password.$error.required && !login.password.$pristine'>La contraseña es obligatoria.</span>
            <span data-ng-show='login.password.$error.minlength && !login.password.$pristine'>La contraseña debe tener al menos 8 caracteres.</span>
        </div>
        <div class="form-group">
            <a href="?usuarios/recordar">¿Ha olvidado la contraseña?</a>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success" data-ng-disabled="!login.$valid">Entrar</button>
        </div>
    </form>
</aside>
<?php $login = ob_get_clean(); ?>
