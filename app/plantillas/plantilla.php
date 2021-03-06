<!DOCTYPE html>
<?php
/**
 * @author A. Oliver Urones García
 * @copyleft (cc) 2017, Oliver Urones
 * @license https://creativecommons.org/licenses/by-nc-sa/4.0/ Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0)
 * @version 1.0
 * 
 * Vista de la plantilla principal para la parte pública
 * 
 * La vista recibe las siguientes variables del controlador
 * $usuario Datos del usuario logueado
 * @var string JSON
 * 
 * $directorio_id Identificador del directorio temporal de conversión
 * @var string JSON
 * 
 * $admin Datos del administrador conectado
 * @var string JSON
 */
//var_dump($usuario);
    if(isset($usuario)) {
        $usuario_json = json_decode($usuario);
        //var_dump("Usuario json");
        //var_dump($usuario_json);
    }
    if(isset($directorio_id)) {
        $id_dir = true;
        $directorio_id_json = json_decode($directorio_id);
    } else {
        $id_dir = false;
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
        <link rel="stylesheet" href="web/css/ng-table.min.css">
        <link rel="stylesheet" href="web/css/ng-table.css">
        <link href="web/css/ng-dropzone.min.css" rel="stylesheet" type="text/css"/>
        <link href="web/css/dropzone.css" rel="stylesheet" type="text/css"/>
        <script src="web/js/angular.min.js"></script>
        <script src="web/js/ngDialog.min.js"></script>
        <script src="web/js/jquery.js"></script>
        <script src="web/js/bootstrap.js"></script>
        <script src="web/js/dropzone.js" type="text/javascript"></script>
        <script src="web/js/ng-dropzone.min.js" type="text/javascript"></script>
        <script src="web/js/app.js"></script>
        <script src="web/js/archivos.js"></script>
        <script src="web/js/usuarios.js"></script>
        <script src="web/js/cambiaPass.js"></script>
        <script src="web/js/dragAndDropController.js" type="text/javascript"></script>
        <script src="web/js/ng-table.js" type="text/javascript"></script>
        <script src="web/js/ng-table.min.js" type="text/javascript"></script>
    </head>
    <body data-ng-app="RepositorioApp" data-ng-controller="LoginFormController">
        <?php if(!isset($usuario_json->token)) { ?>
        <header>
            <nav class="navbar navbar-default">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Desplegar navegación</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <div class="container">
                        <div class="row">
                            <ul class="nav navbar-nav">
                                <li><a href="?home/index/<?php echo ($id_dir) ? $directorio_id_json->directorio_id : "" ?>">Inicio</a></li>
                                <li><a href="?archivos/convertir/<?php echo ($id_dir) ? $directorio_id_json->directorio_id : "" ?>">Conversión</a></li>
                                <li><a href="?usuarios/alta/<?php echo ($id_dir) ? $directorio_id_json->directorio_id : "" ?>">Registro</a></li>
                                <li><a href="?usuarios/login/<?php echo ($id_dir) ? $directorio_id_json->directorio_id : "" ?>">Login</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <?php } else { ?>
        <header>
            <nav class="navbar navbar-default">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Desplegar navegación</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <div class="container">
                        <div class="row">
                            <ul class="nav navbar-nav">
                                <li><a href="?home/index/<?php echo $usuario_json->token ?>/<?php echo ($id_dir) ? $directorio_id_json->directorio_id : "" ?>">Inicio</a></li>
                                <li><a href="?archivos/convertir/<?php echo $usuario_json->token ?>/<?php echo ($id_dir) ? $directorio_id_json->directorio_id : "" ?>">Conversión</a></li>
                                <li></li>
                                <li></li>
                                <li class="dropdown dr">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Perfil <span class="caret"></span></a>
                                    <ul class="dropdown-menu dropdown-menu-left">
                                        <li role="presentation" class=""><a href="?usuarios/perfil/<?php echo $usuario_json->usuario_id; ?>/<?php echo $usuario_json->token; ?>/<?php echo ($id_dir) ? $directorio_id_json->directorio_id : "" ?>">Mis datos</a></li>
                                        <li class="divider"></li>
                                        <li role="presentation" class=""><a href="?archivos/listar/<?php echo $usuario_json->usuario_id; ?>/<?php echo $usuario_json->token; ?>/<?php echo ($id_dir) ? $directorio_id_json->directorio_id : "" ?>">Mis archivos</a></li>
                                        <li class="divider"></li>
                                        <li role="presentation" class=""><a href="?usuarios/logout/<?php echo $usuario_json->usuario_id; ?>/<?php echo ($id_dir) ? $directorio_id_json->directorio_id : "" ?>">Salir</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <?php } ?>
<!--        <header class="navbar">
            <div class="clearfix visible-lg-inline-block"></div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                        <ul class="nav nav-pills nav-justified">
                                <?php //if(!isset($usuario_json->token)) { ?>
                                <li role="presentation"><a href="?home/index/<?php //echo ($id_dir) ? $directorio_id_json->directorio_id : "" ?>">Inicio</a></li>
                                <li role="presentation"><a href="?archivos/convertir/<?php //echo ($id_dir) ? $directorio_id_json->directorio_id : "" ?>">Conversión</a></li>
                                <li role="presentation"><a href="#">Categorías</a></li>
                                <li role="presentation" class="text-right"><a href="?usuarios/alta/<?php //echo ($id_dir) ? $directorio_id_json->directorio_id : "" ?>">Registro</a></li>
                                <li role="presentation" class="text-right"><a href="?usuarios/login/<?php //echo ($id_dir) ? $directorio_id_json->directorio_id : "" ?>">Login</a></li>
                            <?php //} else {
                                //$usuario = json_decode($usuario);
                                //var_dump($usuario->estado === '200 OK');
                            ?>
                                <li role="presentation"><a href="?home/index/<?php //echo $usuario_json->token ?>">Inicio</a></li>
                                <li role="presentation"><a href="?archivos/convertir/<?php //echo $usuario_json->token ?>">Conversión</a></li>
                                <li role="presentation"><a href="#">Categorías</a></li>
                                <li role="presentation" class="text-right"><a href="?usuarios/perfil/<?php //echo $usuario_json->usuario_id ?>/<?php //echo $usuario->token ?>">Perfil</a></li>
                                <li role="presentation" class="text-right"><a href="?usuarios/logout/<?php //echo $usuario_json->usuario_id ?>">Salir</a></li>
                                <li class="dropdown dr">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Perfil <span class="caret"></span></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li role="presentation" class="text-right"><a href="?usuarios/perfil/<?php //echo $usuario_json->usuario_id; ?>/<?php //echo $usuario_json->token; ?>">Ver perfil</a></li>
                                        <li class="divider"></li>
                                        <li role="presentation" class="text-right"><a href="?usuarios/logout/<?php //echo $usuario_json->usuario_id; ?>">Salir</a></li>
                                    </ul>
                                </li>
                            <?php
                                //}
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="clearfix visible-lg-inline-block"></div>
        </header>-->
        
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                    <?php if(!isset($usuario_json->token)) { ?>
                        <form name="buscar" action="?busqueda/archivos" method="POST">
                    <?php } else { ?>
                        <form name="buscar" action="?busqueda/archivos/<?php echo $usuario_json->token; ?>" method="POST">
                    <?php } ?>
                        <div class="input-group">
                            <input 
                                class="form-control" 
                                name="busqueda" 
                                id="busqueda" 
                                type="text" 
                                placeholder="Buscar documentos..."
                                required>
                            <span class="input-group-btn">
                                <button class="btn btn-info">Buscar</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="container" data-ng-app="RepositorioApp" data-ng-controller="ValidacionFormsController">
<!--            <section class="main row">-->
                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <?php echo $contenido ?>
                </article>
                
                <!-- login -->
                <?php 
//                    if(!isset($usuario->token)) {
//                        echo $login;
//                    }
                ?>

<!--                <aside class="col-xs-12 col-sm-4 col-md-3">
                    <h2>Categorías</h2>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquid ex ea commodi consequat. Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </p>
                </aside>-->
<!--            </section>-->
        </div>
        <div class="clearfix visible-xs-inline-block"></div>

        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <h1>Autor</h1>
                        <p class="text-justify">Este Trabajo de Fin de Grado ha sido desarrollado por el alumno <strong>Antonio Oliver Urones García</strong>, estudiante del Grado en Ingeniería Informática en Sistemas de Información en la Escuela Politécnica Superior de Zamora (Universidad de Salamanca)</p>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <h1>Documentación</h1>
                        <p class="text-justify"><a href="phpDoc/index.html" target="__blank">API Documentación para programadores</a></p>
                        <p class="text-justify"><a href="mailto:admin@admin.es" target="__blank">Contacte con el administrador</a></p>
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
