<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modelos\logsModelo;

/**
 * Modelo de la clase logs para los datos principales que contendrá el archivo de logs del sistema.
 *
 * @author Oliver Urones García
 */
class logsModelo {
    //Atributos de la clase logsModelo
    /**
     * Ruta a la carpeta de los logs.
     * @var string 
     */
    private $ruta = NULL;
    
    /**
     * Constructor de la clase por defecto que establece los artributos de ruta, nombre, fecha e IP.
     */
    public function __construct() {
        //echo "Estoy en el __construct() de logsModelo";
        
//        echo '<br/>Ruta: '.$this->ruta;
//        echo '<br/>Nombre del archivo log: '.$this->nombre;
//        echo '<br/>Fecha de la acción a registrar : '.$this->fecha;
//        echo '<br/>IP desde la que se realiza la acción : '.$this->IP;
    }
    
    public function insertaDatos($nombre_log, $datos) {
        if($archivo = fopen($this->ruta.$this->nombre, "a")) {
            //echo '<br/>Se ha creado el fichero '. $this->ruta.$this->nombre."";
            $linea = implode(" ", $datos);
            $linea .= "\n";
            if(fwrite($archivo, $linea)!= false) {
                //echo "Línea añadida correctamente";
            }
            fclose($archivo);
        }
    }

    /**
     * Función que devuelve la ruta del archivo log
     * 
     * Se comprueba si la $this->ruta es un archivo y si existe $this->nombre (el log) si no existe lo crea.
     * @param string $nombre_log Cadena con el nombre del log que se usara para crear el archivo.
     * @return string $ruta_archivo Devuelve la ruta con el nombre del archivo /ruta/al/log.txt.
     */
    public function dameDatosArchivoLog($nombre_log) {
        //echo "<br>Estoy en dameDatosArchivoLog() de logsModelo";
        $this->ruta = DIRECTORIO_LOGS;
        $this->nombre = date("m-Y-").$nombre_log.".log.txt";
        //Compruebo si la ruta al directorio de logs es realmente un directorio
        if(is_dir($this->ruta)) {
            //echo '<br/>'.$this->ruta." Es un directorio";
            //Si lo es...compruebo si existe el fichero log
            if(file_exists($this->nombre)) {
                //echo '<br/>'.$this->nombre." existe.";
                //Si existe devuelvo la ruta con el nombre del fichero ruta/$nombre
                $ruta_archivo = $this->ruta.$this->nombre;
                return $ruta_archivo;
            } else {
                //echo '<br/>'.$this->nombre." NO existe.";
                //Si no existe lo creo
                if($archivo = fopen($this->ruta.$this->nombre, "a")) {
                    //echo '<br/>Se ha creado el fichero '. $this->ruta.$this->nombre."";
                    fclose($archivo);
                    $ruta_archivo = $this->ruta.$this->nombre;
                    return $ruta_archivo;
                }
            }
        }
    }
}
