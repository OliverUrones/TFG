<?php

namespace app\controladores\logs;

use app\modelos\logsModelo\logsModelo;
/**
 * Clase controlador para los logs del sistema
 *
 * @author A. Oliver Urones García
 * @copyleft (cc) 2017, Oliver Urones
 * @license https://creativecommons.org/licenses/by-nc-sa/4.0/ Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0)
 * @version 1.0
 */
class logs {
    
    /**
     * Nombre del archivo de log que se va a crear o modificar
     * @var string 
     */
    public $archivo_log = NULL;
    
    /**
     * Instancia del modelo log iniciada a NULL;
     * @var Objeto logsModelo 
     */
    public $modelo_log = NULL;
    
    /**
     * Constructor por defecto que implementa las llamadas a las funciones para la lógica crear logs y/o añadir datos a éstos.
     * @param string $nombre_log Nombre del log que se va a crear o modificar.
     * @param array $fila_log Array asociativo con los datos que van a formar parte de una entrada o línea en el archivo log.
     */
    public function __construct($nombre_log, $fila_log) {
        $this->modelo_log = new logsModelo();
        //$modeloLog = new logsModelo();
        if($this->crearArchivo($nombre_log)) {
            $this->addLinea($this->archivo_log, $fila_log);
        }
    }
    
    /**
     * Método privado para añadir una línea a un log en concreto
     * @param string $nombre_log Nombre del log que se va a crear o modificar.
     * @param array $datos_linea Array asociativo con los datos que van a formar parte de una entrada o línea en el archivo log.
     */
    private function addLinea($nombre_log, $datos_linea) {
        $this->modelo_log->insertaDatos($nombre_log, $datos_linea);
    }

    /**
     * Método privado para comprobar si un archivo de log está ya creado o si hay que crearlo.
     * El método establece el atributo de la clase $this->archivo_log que será la ruta con el nombre del archivo
     * 
     * @return bool True en caso de éxito y False en caso de fallo;
     */
    private function crearArchivo($nombre_log) {
        //echo "Estoy en el crearArchivo() del controlador logs<br>";
        $this->archivo_log = $this->modelo_log->dameDatosArchivoLog($nombre_log);
        if($this->archivo_log != NULL) {
            return true;
        } else {
            return false;
        }
    }
}
