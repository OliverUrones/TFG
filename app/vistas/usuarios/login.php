<?php ob_start() ?>
<aside class="col-xs-12 col-sm-4 col-md-3">
    <h2>Login</h2>
    <form role="form" action="?usuarios/login" method="POST">
        <div class="form-group">
            <input class="form-control" type="text" placeholder="corre@correo.es" name="email">
        </div>
        <div class="form-group">
            <input class="form-control" type="password" placeholder="********" name="password">
        </div>
        <div class="form-group">
            <a href="?usuarios/recordar">¿Ha olvidado la contraseña?</a>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success">Entrar</button>
        </div>
    </form>
</aside>
<?php $login = ob_get_clean(); ?>
