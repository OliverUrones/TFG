<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modelos\archivosModelo;
require_once ADODB;

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
     * Método que devuelve los archivos y el nombre de la categoría a la que pertenecen de un usuario en concreto, a través del id
     * @param type $id
     * @return type
     */
    public function dameArchivos($id) {
        $sql = "SELECT `archivos`.*, `categorias`.`nombre` AS 'nombre_categoria' FROM `archivos`, `categorias` WHERE `archivos`.`usuario_id` = '".$id."' AND `categorias`.`categoria_id`=`archivos`.`categoria_id`;";
        $recordset = $this->conexion->execute($sql)->getAssoc();
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
        $this->conexion->debug = true;
    }
}
