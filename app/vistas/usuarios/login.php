<aside class="col-xs-12 col-sm-4 col-md-3">
    <div class="modal modal-content">
<!--        <script type="text/ng-template" id="login.php">-->
        <h2 class="modal-header">Login</h2>
        <div class="modal-body">
            <form name="loginForm" role="form" action="?usuarios/login" method="POST">
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
        </div>
                <div class="form-group modal-footer">
                    <button type="submit" class="btn btn-success" data-ng-disabled="!loginForm.$valid" data-ng-click="login(loginModelo)">Entrar</button>
                </div>
            </form>
        </script>
    </div>
</aside>
