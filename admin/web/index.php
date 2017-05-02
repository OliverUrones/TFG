<?php
/**
 * Archivo index.php para instanciar una petición a la clase Api
 */
require_once dirname(__DIR__,2). '/app/Api.php';
require_once dirname(__DIR__,2). '/app/config.php';
require_once dirname(__DIR__,2). '/app/interfaz/Rest.php';
require_once dirname(__DIR__,2). '/app/controladores/home.php';
require_once dirname(__DIR__,2). '/app/controladores/usuarios.php';
require_once dirname(__DIR__, 2).DIRECTORY_SEPARATOR.PHPMAILER;
require_once dirname(__DIR__,2). '/app/modelos/usuariosModelo.php';
require_once dirname(__DIR__,2). '/app/modelos/archivosModelo.php';
require_once dirname(__DIR__,2). '/app/modelos/categoriasModelo.php';
require_once dirname(__DIR__,2). '/app/modelos/rolesModelo.php';
//require_once ADODB;
require_once dirname(__DIR__,2).DIRECTORY_SEPARATOR.ADODB_DRIVER_MYSQLI;
//require_once PHPMAILER;
use app\Api;
$api = new Api\Api;
$api->Api();
