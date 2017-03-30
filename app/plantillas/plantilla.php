<!DOCTYPE html>
<?php //var_dump($usuario);
    if(isset($usuario)) {
        $usuario = json_decode($usuario);
    }
?>
<html>
    <head>
        <title>Repositorio</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="web/css/bootstrap.min.css">
        <link rel="stylesheet" href="web/css/estilos.css">
        <link rel="stylesheet" href="web/css/ngDialog-theme-default.min.css">
        <link rel="stylesheet" href="web/css/ngDialog.min.css">
        <link href="web/css/dropzone.css" rel="stylesheet" type="text/css"/>
        <link href="web/css/ng-dropzone.min.css" rel="stylesheet" type="text/css"/>
        <script src="web/js/angular.min.js"></script>
        <script src="web/js/ngDialog.min.js"></script>
        <script src="web/js/jquery.js"></script>
        <script src="web/js/bootstrap.js"></script>
        <script src="web/js/dropzone.js" type="text/javascript"></script>
        <script src="web/js/ng-dropzone.min.js" type="text/javascript"></script>
        <script src="web/js/app.js"></script>
        <script src="web/js/dragAndDropController.js" type="text/javascript"></script>
    </head>
    <body>
        <header class="navbar">
            <div class="clearfix visible-lg-inline-block"></div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                        <ul class="nav nav-pills nav-justified">
                                <?php if(!isset($usuario->token)) { ?>
                                <li role="presentation"><a href="?home/index">Inicio</a></li>
                                <li role="presentation"><a href="?archivos/convertir">Conversión</a></li>
                                <li role="presentation"><a href="#">Categorías</a></li>
                                <li role="presentation" class="text-right"><a href="?usuarios/alta">Registro</a></li>
                            <?php } else {
                                //$usuario = json_decode($usuario);
                                //var_dump($usuario->estado === '200 OK');
                            ?>
                                <li role="presentation"><a href="?home/index/<?php echo $usuario->token ?>">Inicio</a></li>
                                <li role="presentation"><a href="?archivos/convertir/<?php echo $usuario->token ?>">Conversión</a></li>
                                <li role="presentation"><a href="#">Categorías</a></li>
<!--                                <li role="presentation" class="text-right"><a href="?usuarios/perfil/<?php echo $usuario->usuario_id ?>/<?php echo $usuario->token ?>">Perfil</a></li>
                                <li role="presentation" class="text-right"><a href="?usuarios/logout/<?php echo $usuario->usuario_id ?>">Salir</a></li>-->
                                <li class="dropdown dr">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Perfil <span class="caret"></span></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li role="presentation" class="text-right"><a href="?usuarios/perfil/<?php echo $usuario->usuario_id ?>/<?php echo $usuario->token ?>">Ver perfil</a></li>
                                        <li class="divider"></li>
                                        <li role="presentation" class="text-right"><a href="?usuarios/logout/<?php echo $usuario->usuario_id ?>">Salir</a></li>
                                    </ul>
                                </li>
                            <?php
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="clearfix visible-lg-inline-block"></div>
        </header>
        
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                    <form action="">
                        <div class="input-group">
                            <input class="form-control" id="buscar" type="text" placeholder="Buscar documentos...">
                            <span class="input-group-btn">
                                <button class="btn btn-info">Buscar</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="container" data-ng-app="RepositorioApp" data-ng-controller="ValidacionFormsController">
            <section class="main row">
                <article class="col-xs-12 col-sm-8 col-md-9">
                    <?php echo $contenido ?>
                </article>
                
                <!-- login -->
                <?php 
                    if(!isset($usuario->token)) {
                        echo $login;
                    }
                ?>

                <aside class="col-xs-12 col-sm-4 col-md-3">
                    <h2>Categorías</h2>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquid ex ea commodi consequat. Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </p>
                </aside>
            </section>
        </div>
        <div class="clearfix visible-xs-inline-block"></div>

        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <h1>Autor</h1>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <h1>Mapa Web</h1>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-sm-offset-1 col-md-3 col-md-offset-1 col-lg-3 col-lg-offset-1">
                        <h1>
                            <a target="_blank" rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/">
                                <img class="center-block" alt="Licencia de Creative Commons" src="https://i.creativecommons.org/l/by-nc-sa/4.0/88x31.png" />
                            </a>
                        </h1>
                        <p class="text-justify"><a target="_blank" rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/">Esta obra está bajo una licencia de Creative Commons Reconocimiento-NoComercial-CompartirIgual 4.0 Internacional</a>.</p>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
