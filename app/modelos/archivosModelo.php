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
    public $ambito = NULL;
    public $etiquetas = NULL;
    
    /**
     * Constructor de la clase por defecto donde se establecen los valores de los atributos cuando vienen por POST
     */
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
        if(isset($_POST['ambito'])){
            $this->ambito = $this->conexion->qStr($_POST['ambito']);
        }
        if(isset($_POST['etiquetas'])){
            $this->etiquetas = $this->conexion->qStr($_POST['etiquetas']);
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
            $sql = "INSERT INTO `archivos` (`usuario_id`, `categoria_id`, `nombre`, `enlace_descarga`, `ambito`, `etiquetas`)"
                    . " VALUES (".$this->usuario_id.", ".$this->categoria_id.", ".utf8_encode($this->nombre).", '".$this->enlace_descarga."', ".$this->ambito.", ".utf8_encode($this->etiquetas).");";
            //var_dump($sql);
            //La ejecuto
            $recordSet = $this->conexion->execute($sql);

            //Si $recorSet es distinto de falso la consulta se ha ejecutado con éxtio
            if($recordSet !== false) {
                //Mensaje correspondiente
                //var_dump($recordSet);
                return array('estado' => '200 OK', 'Mensaje' => 'El archivo se ha añadido al repositorio correctamente.');
            } else {
                //Menaje correspondiente
                //var_dump($recordSet);
                return array('estado' => '400 KO', 'Mensaje' => 'No se ha podido añadir el archivo al repositorio.');
            }
        }
    }
    
    /**
     * Método privado que mueve el archivo pdf del directorio temporal al directorio de archivos
     * @param type $params
     */
    private function __mueveArchivo($params) {
        if(isset($params['archivo'])) {
            $fecha = date("-d-m-Y-H-i-s");
            
            $old_name = CARPETA_TEMPORALES.$params['directorio_id'].SEPARADOR.$params['archivo'];
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
        if(isset($params['ambito'])) {
            $this->ambito = $this->conexion->qStr($params['ambito']);
        }
        if(isset($params['etiquetas'])) {
            $this->etiquetas = $this->conexion->qStr($params['etiquetas']);
        }
    }

    /**
     * Método que devuelve los archivos y el nombre de la categoría a la que pertenecen de un usuario en concreto, a través del id del usuario
     * @param type $id
     * @return type
     */
    public function dameArchivos($id) {
        $sql = "SELECT `archivos`.*, `categorias`.`nombre` AS 'nombre_categoria' "
                . "FROM `archivos`, `categorias` "
                . "WHERE `archivos`.`usuario_id` = '".$id."' "
                . "AND `categorias`.`categoria_id`=`archivos`.`categoria_id`;";
//        $sql2 = "SELECT valoracion.valoracion_id, valoracion.usuario_id, valoracion.archivo_id, valoracion.puntuacion, archivos.archivo_id, archivos.usuario_id, archivos.categoria_id, archivos.nombre, archivos.enlace_descarga, usuarios.usuario_id FROM valoracion, archivos, usuarios
//WHERE valoracion.usuario_id = archivos.usuario_id
//AND usuarios.usuario_id = valoracion.usuario_id
//GROUP by archivos.archivo_id"
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
    
    /**
     * Método que devuelve los datos de un archivo a través de su id
     * @param int $id ID del archivo a recuperar los datos
     * @return array Datos del archivo buscado y el estado de la petición y el mensaje de ésta.
     */
    public function dameArchivoId($id) {
        $sql = "SELECT `archivos`.*, `usuarios`.nombre AS 'nombre_usuario', `categorias`.nombre AS 'nombre_categoria' "
                . "FROM `usuarios`, `archivos`, `categorias` "
                . "WHERE `usuarios`.usuario_id = `archivos`.usuario_id "
                . "AND `categorias`.categoria_id = `archivos`.categoria_id "
                . "AND `archivos`.archivo_id = ".$id.";";
        //var_dump($sql);
        $resultado = $this->conexion->getRow($sql);
        //var_dump($resultado);
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

    /**
     * Método que devuelve todos los archivos de la base de datos junto al usuario y la categoría a la que pertenecen ordenados por el id del archivo
     * @return array $archivos Array asociativio con el listado de los archivos recuperados de la base de datos
     */
    public function listadoArchivos() {
        $sql = "SELECT `archivos`.*, `usuarios`.nombre AS 'nombre_usuario', `categorias`.nombre AS 'nombre_categoria' "
                . "FROM `usuarios`, `archivos`, `categorias` "
                . "WHERE `usuarios`.usuario_id = `archivos`.usuario_id "
                . "AND `categorias`.categoria_id = `archivos`.categoria_id "
                . "ORDER BY `archivos`.archivo_id;";
        //var_dump($sql);
        $recordset = $this->conexion->execute($sql)->getAssoc();
        
        //var_dump($recordset);
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
        }        
    }
    
    /**
     * Método que modifica los datos de un archivo a través de su ID.
     * @return array $archivo Datos del archivo modificado junto con el estado de la petición, el mensaje y la acción que se ha realizado
     */
    public function modificaArchivoId() {
        //var_dump($_POST);
        $sql = "UPDATE `archivos` SET nombre=".utf8_encode($this->nombre).", categoria_id=".$this->categoria_id.", ambito=".$this->ambito." WHERE archivo_id=".$this->archivo_id.";";
        //var_dump($sql);
        $resultado = $this->conexion->execute($sql);

        if(!$resultado)
        {
            return array('estado' => '400 KO', 'Mensaje' => 'Error al activar la cuenta');
        }else
        {
            $archivo = $this->dameArchivoId(str_replace("'", "", $this->archivo_id));
            $archivo['estado_p'] = '200 OK';
            $archivo['Mensaje'] = 'Archivo modificado correctamente';
            $archivo['accion'] = 'modificar';
            //var_dump($archivo);
            return $archivo;
        }
    }
    
    /**
     * Borra un archivo a través del id viniendo por get. Para la parte pública
     * @param type $id
     * @return type
     */
    public function borraArchivo($id) {
        $sql = "DELETE FROM archivos WHERE archivo_id='".$id."';";
        
        $resultado = $this->conexion->execute($sql);
        
        if(!$resultado) {
            return array('estado_p' => '400 KO', 'Mensaje' => "Error al borrar el archivo");
        } else {
            return array('estado_p' => '200 OK', 'Mensaje' => "Archivo borrado correctamente");
        }
    }
    
    /**
     * Borra un archivo a través del id. Para la parte privada
     * @return array Array asociativo con el estado de la peticón y el mensaje
     */
    public function borraArchivoId() {
        $sql = "DELETE FROM archivos WHERE archivo_id=".$this->archivo_id.";";
        var_dump($sql);
        $resultado = $this->conexion->execute($sql);
        
        if(!$resultado) {
            return array('estado_p' => '400 KO', 'Mensaje' => "Error al borrar el archivo");
        } else {
            return array('estado_p' => '200 OK', 'Mensaje' => "Archivo borrado correctamente");
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
        //Si está activado en la peticiones por Ajax da error en la respuesta
        //$this->conexion->debug = true;
    }
}
