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
        <link href="../web/css/ng-dropzone.min.css" rel="stylesheet" type="text/css"/>
        <link href="../web/css/dropzone.css" rel="stylesheet" type="text/css"/>
        <script src="../web/js/angular.min.js"></script>
        <script src="../web/js/ngDialog.min.js"></script>
        <script src="../web/js/jquery.js"></script>
        <script src="../web/js/bootstrap.js"></script>
        <script src="../web/js/dropzone.js" type="text/javascript"></script>
        <script src="../web/js/ng-dropzone.min.js" type="text/javascript"></script>
        <script src="../web/js/app.js"></script>

    </head>
    <body>
        <?php if(isset($admin_json) && $admin_json->rol_id === '1') { ?>
        <header class="navbar navbar-inverse">
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
        </header>
        <?php } else { ?>
        <header class="nav">
            <div class="clearfix visible-lg-inline-block"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <h1>Admnistración</h1>
                        </div>
                    </div>
                </div>
            <div class="clearfix visible-lg-inline-block"></div>
        </header>
        <?php } ?>
        <div class="container">
            <?php
                echo $contenido;   
            ?>
        </div>
    </body>
</html>