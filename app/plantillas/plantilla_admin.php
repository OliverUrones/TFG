<!DOCTYPE html>
<?php 
    if(isset($admin)) {
        $admin_json = json_decode($admin);
        //var_dump($usuario_json);
    }
?>
<html>
    <head>
        <title>Repositorio</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../web/css/bootstrap.min.css">
        <link rel="stylesheet" href="../web/css/estilos.css">
        <link rel="stylesheet" href="../web/css/ngDialog-theme-default.min.css">
        <link rel="stylesheet" href="../web/css/ngDialog.min.css">
        <link rel="stylesheet" href="../web/css/ng-table.min.css">
        <link rel="stylesheet" href="../web/css/ng-table.css">
        <link href="../web/css/ng-dropzone.min.css" rel="stylesheet" type="text/css"/>
        <link href="../web/css/dropzone.css" rel="stylesheet" type="text/css"/>
        <script src="../web/js/angular.min.js"></script>
        <script src="../web/js/ngDialog.min.js"></script>
        <script src="../web/js/jquery.js"></script>
        <script src="../web/js/bootstrap.js"></script>
        <script src="../web/js/dropzone.js" type="text/javascript"></script>
        <script src="../web/js/ng-dropzone.min.js" type="text/javascript"></script>
        <script src="../web/js/app.js"></script>
        <script src="../web/js/usuarios.js"></script>
        <script src="../web/js/roles.js"></script>
        <script src="../web/js/archivos.js"></script>
        <script src="../web/js/categorias.js"></script>
        <script src="../web/js/ng-table.min.js"></script>
        <script src="../web/js/ng-table.js"></script>
    </head>
    <body>
        <?php if(isset($admin_json) && $admin_json->rol_id === '1') { ?>
        <header>
            <nav class="navbar navbar-default">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Desplegar navegación</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="?home/adminIndex/<?php echo $admin_json->token ?>">Administración</a>
                </div>
                
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <div class="container">
                        <div class="row">
                            <ul class="nav navbar-nav">
                                <li><a href="?usuarios/listar/<?php echo $admin_json->token ?>">Usuarios</a></li>
                                <li><a href="?roles/listar/<?php echo $admin_json->token ?>">Roles</a></li>
                                <li><a href="?archivos/listarTodos/<?php echo $admin_json->token ?>">Archivos</a></li>
                                <li><a href="?categorias/listar/<?php echo $admin_json->token ?>">Categorías</a></li>
                                <li><a href="?usuarios/adminLogout/<?php echo $admin_json->usuario_id ?>">Salir</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
<!--        <header class="navbar navbar-inverse">
            <div class="clearfix visible-lg-inline-block"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <ul class="nav nav-pills nav-justified">
                                <li>
                                    <a href="?home/adminIndex/<?php echo $admin_json->token ?>">Inicio</a>
                                </li>
                                <li>
                                    <a href="?usuarios/listar/<?php echo $admin_json->token ?>">Usuarios</a>
                                </li>
                                <li>
                                    <a href="?roles/listar/<?php echo $admin_json->token ?>">Roles</a>
                                </li>
                                <li>
                                    <a href="?archivos/listarTodos/<?php echo $admin_json->token ?>">Archivos</a>
                                </li>
                                <li>
                                    <a href="?categorias/listar/<?php echo $admin_json->token ?>">Categorías</a>
                                </li>
                                <li>
                                    <a href="?usuarios/adminLogout/<?php echo $admin_json->usuario_id ?>">Salir</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            <div class="clearfix visible-lg-inline-block"></div>
        </header>-->
        <?php } else { ?>
            <header>
                <nav class="navbar navbar-default">
                    <div class="navbar-header">
                        <h1 class="navbar-brand">Administración</h1>
                    </div>
                </nav>
            </header>
<!--        <header class="nav">
            <div class="clearfix visible-lg-inline-block"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <h1 class="text-center">Admnistración</h1>
                        </div>
                    </div>
                </div>
            <div class="clearfix visible-lg-inline-block"></div>
        </header>-->
        <?php } ?>
        <div class="container">
            <?php
                echo $contenido;   
            ?>
        </div>
        
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <h1>Autor</h1>
                        <p class="text-justify">Este Trabajo de Fin de Grado ha sido desarrollado por el alumno <strong>Antonio Oliver Urones García</strong>, estudiante del Grado en Ingeniería Informática en Sistemas de Información en la Escuela Politécnica Superior de Zamora (Universidad de Salamanca)</p>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <h1>Documentación</h1>
                        <p class="text-justify"><a href="#">Para programadores</a></p>
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