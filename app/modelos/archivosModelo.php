<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modelos\archivosModelo;
require_once dirname(__DIR__).DIRECTORY_SEPARATOR.'adodb5/adodb.inc.php';
//require_once ADODB;

/**
 * Description of archivosModelo
 *
 * @author oliver
 */
class archivosModelo {
    private $tabla = 'archivos';
    private $conexion = NULL;
    public $archivo_id = NULL;
    public $usuario_id = NULL;
    public $categoria_id = NULL;
    public $nombre = NULL;
    public $enlace_descarga = NULL;    
    
    public function __construct() {
        //Llamo a la función para conectarse a la base de datos
        $this->__conexion();
        
        if(isset($_POST['archivo_id'])){
            $this->archivo_id = $this->conexion->qStr($_POST['archivo_id']);
        }
        if(isset($_POST['usuario_id'])){
            $this->usuario_id = $this->conexion->qStr($_POST['usuario_id']);
        }
        if(isset($_POST['categoria_id'])){
            $this->categoria_id = $this->conexion->qStr($_POST['categoria_id']);
        }
        if(isset($_POST['nombre'])){
            $this->nombre = $this->conexion->qStr($_POST['nombre']);
        }
        if(isset($_POST['enlace-descarga'])){
            $this->enlace_descarga = $this->conexion->qStr($_POST['enlace_descarga']);
        }
    }
    
    /**
     * Método que guarda un archivo en la base de datos. Los parámetros son de una llamada Ajax
     * @param array $params
     */
    public function subeArchivo($params) {
        //Establezco los atributos de la clase
        $this->__settersPorAjax($params);
        if($this->__mueveArchivo($params)) {
            //Construyo la consulta de inserción
            $sql = "INSERT INTO `archivos` (`usuario_id`, `categoria_id`, `nombre`, `enlace_descarga`)"
                    . " VALUES (".$this->usuario_id.", ".$this->categoria_id.", ".$this->nombre.", '".$this->enlace_descarga."');";
            //var_dump($sql);
            //La ejecuto
            $recordSet = $this->conexion->execute($sql);

            //Si $recorSet es distinto de falso la consulta se ha ejecutado con éxtio
            if($recordSet !== false) {
                //Mensaje correspondiente
                //var_dump('200 OK');
                return array('estado' => '200 OK', 'Mensaje' => 'El archivo se ha añadido al repositorio correctamente.');
            } else {
                //Menaje correspondiente
                //var_dump('400 KO');
                return array('estado' => '400 KO', 'Mensaje' => 'No se ha podido añadir el archivo al repositorio.');
            }
        }
    }
    
    /**
     * 
     * @param type $params
     */
    private function __mueveArchivo($params) {
        if(isset($params['archivo'])) {
            $fecha = date("-d-m-Y-H-i-s");
            
            $old_name = CARPETA_TEMPORALES.$params['archivo'];
            $new_name = DIRECTORIO_ARCHIVOS_ABSOLUTA.$params['nombre_archivo'].$fecha.'.pdf';
            
            if(rename($old_name, $new_name)) {
                $this->enlace_descarga = $params['nombre_archivo'].$fecha.'.pdf';
            } else {
                return false;
            }
        } else {
            return false;
        }
        return true;
    }

        /**
     * Función que sirve para establecer los valores de los atributos de la clase para añadir un archivo a la base de datos.
     * @param type $params
     */
    private function __settersPorAjax($params) {
        if(isset($params['usuario_id'])) {
            $this->usuario_id = $this->conexion->qStr($params['usuario_id']);
        }
        if(isset($params['nombre_archivo'])) {
            $this->nombre = $this->conexion->qStr($params['nombre_archivo']);
        }
        if(isset($params['categoria_id'])) {
            $this->categoria_id = $this->conexion->qStr($params['categoria_id']);
        }
    }

    /**
     * Método que devuelve los archivos y el nombre de la categoría a la que pertenecen de un usuario en concreto, a través del id
     * @param type $id
     * @return type
     */
    public function dameArchivos($id) {
        $sql = "SELECT `archivos`.*, `categorias`.`nombre` AS 'nombre_categoria' FROM `archivos`, `categorias` WHERE `archivos`.`usuario_id` = '".$id."' AND `categorias`.`categoria_id`=`archivos`.`categoria_id`;";
        $recordset = $this->conexion->execute($sql)->getAssoc();
        if($recordset) {
            foreach ($recordset as $key => $value) {
                //echo '<br/>'.$key.' -- '.$value;
                foreach ($value as $columna => $valor) {
                    if(is_string($columna)) {
                        $archivos[$key][$columna] = $valor;
                    }
                }
            }
            //var_dump($archivos);
            return $archivos;
        } else {
            return array("estado" => '200 OK', "Mensaje" => "No tiene archivos guardados");
        }
    }
    
    public function dameArchivoId($id) {
        $sql = "SELECT `archivos`.*, `usuarios`.nombre AS 'nombre_usuario', `categorias`.nombre AS 'nombre_categoria' "
                . "FROM `usuarios`, `archivos`, `categorias` "
                . "WHERE `usuarios`.usuario_id = `archivos`.usuario_id "
                . "AND `categorias`.categoria_id = `archivos`.categoria_id "
                . "AND `archivos`.archivo_id = ".$id.";";
        var_dump($sql);
        $resultado = $this->conexion->getRow($sql);
        var_dump($resultado);
        foreach ($resultado as $key => $value) {
            if(is_string($key))
            {
                $archivo[$key] = utf8_decode($value);
                //echo '<br/>resultado['.$key.'] = '.$value;
            }
        }
        //Añado las claves de estado y Mensaje y devuelvo el usuario logueado con el estado de la petición
        $archivo['estado_p'] = '200 OK';
        $archivo['Mensaje'] = 'Datos del archivo recuperado correctamente';
        return $archivo;
    }

        public function listadoArchivos() {
        $sql = "SELECT `archivos`.*, `usuarios`.nombre AS 'nombre_usuario', `categorias`.nombre AS 'nombre_categoria' "
                . "FROM `usuarios`, `archivos`, `categorias` "
                . "WHERE `usuarios`.usuario_id = `archivos`.usuario_id "
                . "AND `categorias`.categoria_id = `archivos`.categoria_id;";
        //var_dump($sql);
        $recordset = $this->conexion->execute($sql)->getAssoc();
        
        //var_dump($recordset);
        if($recordset) {
            foreach ($recordset as $key => $value) {
                //echo '<br/>'.$key.' -- '.$value;
                foreach ($value as $columna => $valor) {
                    if(is_string($columna)) {
                        $usuarios[$key][$columna] = $valor;
                    }
                }
            }
            //var_dump($archivos);
            return $usuarios;
        }        
    }

    /**
     * Función que conecta con la base de datos
     */
    private function __conexion() {
        
        //Datos de la conexión host, usuario, contraseña y base de datos
        $host = '127.0.0.1';
        $usuario = 'root';
        $pass = 'toor';
        $db = 'repositorio';
        
        //Creación del objeto ADODB para conectarse a través del drives mysqli
        $this->conexion = NewADOConnection('mysqli');
        
        //Se establece la conexión con los datos
        $this->conexion->connect($host, $usuario, $pass, $db);
        
        //Para debuggear ADODB
        //$this->conexion->debug = true;
    }
}
