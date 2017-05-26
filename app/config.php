<?php
/**
 * Definición de las constantes de la aplicación
 */

/**
 * Separador de directorio.
 * @var string SEPARADOR
 */
define('SEPARADOR', DIRECTORY_SEPARATOR);
/**
 * Directorio raiz del proyecto.
 * @var string RAIZ
 */
define('RAIZ', dirname(__DIR__));
/**
 * Ruta relativa de la aplicación app/
 * @var string DIRECTORIO_APLICACION
 */
define('DIRECTORIO_APLICACION', 'app'.SEPARADOR);
/**
 * Ruta absoluta de la aplicación en el sistema
 * @var string APLICACION
 */
define('APLICACION', RAIZ. SEPARADOR . DIRECTORIO_APLICACION);
/**
 * Ruta absoluta del archivo de configuración config.php
 * @var string CONFIGURACION
 */
define('CONFIGURACION', APLICACION . 'config.php');
/**
 * Ruta absoluta de la ruta a los controladores
 * @var string CONTROLADORES
 */
define('CONTROLADORES', APLICACION . 'controladores'. SEPARADOR);
/**
 * Ruta absoluta de la ruta a los modelos
 * @var string MODELOS
 */
define('MODELOS', APLICACION . 'modelos'. SEPARADOR);
/**
 * Ruta absoluta de la ruta a las vistas
 * @var string VISTAS
 */
define('VISTAS', APLICACION . 'vistas'. SEPARADOR);
/**
 * Ruta absoluta de la ruta a las plantillas
 * @var string PLANTILLAS
 */
define('PLANTILLAS', APLICACION . 'plantillas'. SEPARADOR);
/**
 * Ruta absoluta al directorio de entrada a la aplicación
 * @var string DIRECTORIO_WEB
 */
define('DIRECTORIO_WEB',  RAIZ .SEPARADOR . 'web'. SEPARADOR);
/**
 * Ruta absoluta a los archivos css
 * @var string DIRECTORIO_CSS
 */
define('DIRECTORIO_CSS',  DIRECTORIO_WEB . 'css' . SEPARADOR);
/**
 * Ruta absoluta a los archivos js
 * @var string DIRECTORIO_JS
 */
define('DIRECTORIO_JS',  DIRECTORIO_WEB . 'js' . SEPARADOR);
/**
 * Ruta absoluta a las fuentes de texto
 * @var string DIRECTORIO_FUENTES
 */
define('DIRECTORIO_FUENTES',  DIRECTORIO_WEB . 'fonts' . SEPARADOR);
/**
 * Ruta relativa a la clase adodb.inc.php
 * @var string ADODB
 */
define('ADODB', DIRECTORIO_APLICACION . 'adodb5' . SEPARADOR . 'adodb.inc.php');
/**
 * Ruta relativa a la clase adodb-mysqli-inc.php
 * @var string ADODB_DRIVER_MYSQLI
 */
define('ADODB_DRIVER_MYSQLI', DIRECTORIO_APLICACION . 'adodb5' . SEPARADOR . 'drivers' . SEPARADOR . 'adodb-mysqli.inc.php');
/**
 * Ruta relativa a la clase PHPMailerAutoload
 * @var string PHPMAILER
 */
define('PHPMAILER', DIRECTORIO_APLICACION.'PHPMailer' . SEPARADOR . 'PHPMailerAutoload.php');
/**
 * Ruta relativa a la clase class.smtp.php de la librería PHPMailer
 * @var string PHPMAILER_SMTP
 */
define('PHPMAILER_SMTP', DIRECTORIO_APLICACION.'PHPMailer' . SEPARADOR . 'class.smtp.php');
/**
 * Ruta absoluta a la carpeta de archivos temporales de la aplicación app/temp
 * @var string CARPETA_TEMPORALES
 */
define('CARPETA_TEMPORALES', APLICACION . 'temp'.SEPARADOR);
/**
 * Ruta relativa al directorio de archivos. Este es el directorio donde se almacenan físicamente los archivos subidos al repositorio
 * @var string DIRECTORIO_ARCHIVOS_RELATIVA
 */
define('DIRECTORIO_ARCHIVOS_RELATIVA', DIRECTORIO_APLICACION.'archivos'.SEPARADOR);
/**
 * Ruta absoluta al directorio de archivos. Este es el directorio donde se almacenan físicamente los archivos subidos al repositorio
 * @var string DIRECTORIO_ARCHIVOS_ABSOLUTA
 */
define('DIRECTORIO_ARCHIVOS_ABSOLUTA', APLICACION.'archivos'.SEPARADOR);
/**
 * Ruta absoluta al directorio de registros del sistema (logs)
 * @var string DIRECTORIO_LOGS
 */
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
//echo '<br/>ADODB '.ADODB;
//echo '<br/>ADODB_DRIVER_MYSQLI '.ADODB_DRIVER_MYSQLI;
//echo '<br/>PHPMAILER '.PHPMAILER;
//echo '<br/>PHPMAILER_SMTP '.PHPMAILER_SMTP;
//echo '<br/>CARPETA_TEMPORALES '.CARPETA_TEMPORALES;
//echo '<br/>DIRECTORIO_ARCHIVOS_RELATIVA '.DIRECTORIO_ARCHIVOS_RELATIVA;
//echo '<br/>DIRECTORIO_ARCHIVOS_ABSOLUTA '.DIRECTORIO_ARCHIVOS_ABSOLUTA;
//echo '<br/>DIRECTORIO_LOGS '.DIRECTORIO_LOGS;

?>