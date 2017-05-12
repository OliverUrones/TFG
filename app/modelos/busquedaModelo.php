<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modelos\busquedaModelo;
require_once dirname(__DIR__).DIRECTORY_SEPARATOR.'adodb5/adodb.inc.php';

use app\modelos\categoriasModelo\categoriasModelo;

/**
 * Description of busquedaModelo
 *
 * @author oliver
 */
class busquedaModelo {
    private $tabla = 'archivos';
    private $conexion = NULL;
    public $archivo_id = NULL;
    public $nombre_archivo = NULL;
    public $enlace_descarga = NULL;
    public $ambito = NULL;
    public $etiquetas = NULL;
    public $nombre_categoria = NULL;
    
    public function busca($cadena) {
        $this->__conexion();
        //var_dump($cadena);
        //$this->__hayCategorias($cadena);
        return $this->__dameResultado($cadena);
    }
    
    private function __dameResultado($cadena) {
//        Ejemplo de consulta con MATCH () AGAINST()
//        SELECT archivos.archivo_id, archivos.nombre, archivos.etiquetas, archivos.enlace_descarga, categorias.nombre, (MATCH (archivos.nombre, archivos.etiquetas) AGAINST ("programacion prueba informatica borrado ortografia") OR MATCH (categorias.nombre) AGAINST ("programacion prueba informatica borrado ortografia")) AS "coincidencia"
//        FROM archivos, categorias
//        WHERE archivos.ambito = 1
//        AND archivos.categoria_id = categorias.categoria_id
//        ORDER BY coincidencia DESC
        $sql = "SELECT archivos.archivo_id, archivos.nombre AS 'nombre_archivo', archivos.etiquetas, archivos.enlace_descarga, categorias.nombre AS 'categoria', (MATCH (archivos.nombre, archivos.etiquetas) AGAINST ('".$cadena."') OR MATCH (categorias.nombre) AGAINST ('".$cadena."')) AS 'coincidencia' "
                . "FROM archivos, categorias "
                . "WHERE archivos.ambito = 1 "
                . "AND archivos.categoria_id = categorias.categoria_id "
                . "AND (MATCH (archivos.nombre, archivos.etiquetas) AGAINST ('".utf8_encode($cadena)."') OR MATCH (categorias.nombre) AGAINST ('".utf8_encode($cadena)."')) = 1 "
                . "ORDER BY coincidencia DESC";
        //echo "<br/>".$sql;
        $recordset = $this->conexion->execute($sql)->getAssoc();
        
        //var_dump($recordset);
        if($recordset) {
            foreach ($recordset as $key => $value) {
                //echo '<br/>'.$key.' -- '.$value;
                foreach ($value as $columna => $valor) {
                    if(is_string($columna)) {
                        $resultado[$key][$columna] = $valor;
                    }
                }
            }
            $resultado['total'] = count($resultado);
            $resultado['cadena'] = $cadena;
            return $resultado;
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
