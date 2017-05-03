<?php

define('SEPARADOR', DIRECTORY_SEPARATOR);
define('RAIZ', dirname(__DIR__));
define('DIRECTORIO_APLICACION', 'app'.SEPARADOR);
define('APLICACION', RAIZ. SEPARADOR . DIRECTORIO_APLICACION);
define('CONFIGURACION', APLICACION . 'config.php');
define('CONTROLADORES', APLICACION . 'controladores'. SEPARADOR);
define('MODELOS', APLICACION . 'modelos'. SEPARADOR);
define('VISTAS', APLICACION . 'vistas'. SEPARADOR);
define('PLANTILLAS', APLICACION . 'plantillas'. SEPARADOR);
define('DIRECTORIO_WEB',  RAIZ .SEPARADOR . 'web'. SEPARADOR);
define('DIRECTORIO_CSS',  DIRECTORIO_WEB . 'css' . SEPARADOR);
define('DIRECTORIO_JS',  DIRECTORIO_WEB . 'js' . SEPARADOR);
define('DIRECTORIO_FUENTES',  DIRECTORIO_WEB . 'fonts' . SEPARADOR);
define('ADODB', DIRECTORIO_APLICACION . 'adodb5' . SEPARADOR . 'adodb.inc.php');
define('ADODB_DRIVER_MYSQLI', DIRECTORIO_APLICACION . 'adodb5' . SEPARADOR . 'drivers' . SEPARADOR . 'adodb-mysqli.inc.php');
define('PHPMAILER', DIRECTORIO_APLICACION.'PHPMailer' . SEPARADOR . 'PHPMailerAutoload.php');
define('PHPMAILER_SMTP', DIRECTORIO_APLICACION.'PHPMailer' . SEPARADOR . 'class.smtp.php');
define('CARPETA_TEMPORALES', APLICACION . 'temp'.SEPARADOR);
define('DIRECTORIO_ARCHIVOS_RELATIVA', DIRECTORIO_APLICACION.'archivos'.SEPARADOR);
define('DIRECTORIO_ARCHIVOS_ABSOLUTA', APLICACION.'archivos'.SEPARADOR);
define('DIRECTORIO_LOGS', APLICACION.'logs'.SEPARADOR);

//echo '<br/>DS '.SEPARADOR;
//echo '<br/>RAIZ'.RAIZ;
//echo '<br/>DIRECTORIO APLICACION '.DIRECTORIO_APLICACION;
//echo '<br/>APLICACION '.APLICACION;
//echo '<br/>CONFIGURACION '.CONFIGURACION;
//echo '<br/>CONTROLADORES '.CONTROLADORES;
//echo '<br/>MODELOS '.MODELOS;
//echo '<br/>VISTAS '.VISTAS;
//echo '<br/>PLANTILLAS '.PLANTILLAS;
//echo '<br/>DIRECTORIO_WEB '.DIRECTORIO_WEB;
//echo '<br/>DIRECTORIO_CSS '.DIRECTORIO_CSS;
//echo '<br/>DIRECTORIO_JS '.DIRECTORIO_JS;
//echo '<br/>DIRECTORIO_FUENTES '.DIRECTORIO_FUENTES;
//echo '<br/>CARPETA_TEMPORALES '.CARPETA_TEMPORALES;
//echo '<br/>DIRECTORIO_ARCHIVOS_RELATIVA '.DIRECTORIO_ARCHIVOS_RELATIVA;
//echo '<br/>DIRECTORIO_ARCHIVOS_ABSOLUTA '.DIRECTORIO_ARCHIVOS_ABSOLUTA;

?>