<?php
require_once dirname(__DIR__). '/app/Api.php';
require_once dirname(__DIR__). '/app/config.php';
require_once dirname(__DIR__). '/app/controladores/home.php';
require_once dirname(__DIR__). '/app/controladores/usuarios.php';
require_once dirname(__DIR__). '/app/modelos/usuariosModelo.php';
use app\Api;

//var_dump(parse_url(urldecode($_SERVER['REQUEST_URI'])));
//echo '<br/>/'.basename(__FILE__);
//echo '<br/>'. __DIR__;
//echo '<br/>'. dirname(__DIR__);
//echo '<br/>'.urldecode($_SERVER['REQUEST_URI']);

$api = new Api\Api;
?>