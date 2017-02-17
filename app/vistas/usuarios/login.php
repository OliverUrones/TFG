<?php ob_start() ?>
<aside class="col-xs-12 col-sm-4 col-md-3">
    <h2>Login</h2>
    <form role="form" action="?usuarios/login" method="POST">
        <div class="form-group">
            <input class="form-control" type="text" placeholder="corre@correo.es">
        </div>
        <div class="form-group">
            <input class="form-control" type="password" placeholder="********">
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox"> No cerrar sesión
            </label>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success">Entrar</button>
        </div>
    </form>
</aside>
<?php $login = ob_get_clean(); ?>
