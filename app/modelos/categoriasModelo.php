<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modelos\categoriasModelo;
require_once dirname(__DIR__).DIRECTORY_SEPARATOR.'adodb5/adodb.inc.php';
//require_once ADODB;

/**
 * Description of categoriasModelo
 *
 * @author oliver
 */
class categoriasModelo {
    private $tabla = 'categorias';
    private $conexion = NULL;
    public $categoria_id = NULL;
    public $nombre = NULL;
    public $categoria_padre = NULL;
    
    public function __construct() {
        //Llamo a la función para conectarse a la base de datos
        $this->__conexion();
        
        if(isset($_POST['categoria_id'])){
            $this->categoria_id = $this->conexion->qStr($_POST['categoria_id']);
        }
        if(isset($_POST['nombre'])){
            $this->nombre = $this->conexion->qStr($_POST['nombre']);
        }
        if(isset($_POST['categoria_padre'])){
            $this->categoria_padre = $this->conexion->qStr($_POST['categoria_padre']);
        }
    }
    
    /**
     * Método que devuelve las categorías
     * @return array Array asociativo con las categorías devueltas
     */
    public function dameCategorias() {
        //$sql = "SELECT * FROM categorias";
        $sql = "SELECT c1.categoria_id, c1.nombre, c1.categoria_padre, c2.nombre AS padre FROM categorias AS c1 LEFT OUTER JOIN categorias AS c2 ON c1.categoria_padre =c2.categoria_id";
        $recordset = $this->conexion->execute($sql)->getAssoc();
        foreach ($recordset as $key => $value) {
            //echo '<br/>'.$key.' -- '.$value;
            foreach ($value as $columna => $valor) {
                if(is_string($columna)) {
                    $categorias[$key][$columna] = $valor;
                }
            }
        }
        //var_dump($categorias);
        return $categorias;
    }
    
    public function dameCategoriaId($id) {
        $sql = "SELECT c1.categoria_id, c1.nombre, c1.categoria_padre, c2.nombre AS padre FROM categorias AS c1 LEFT OUTER JOIN categorias AS c2 ON c1.categoria_padre =c2.categoria_id WHERE c1.categoria_id=".$id.";";
        
        $resultado = $this->conexion->getRow($sql);
        //var_dump($resultado);
        foreach ($resultado as $key => $value) {
            if(is_string($key))
            {
                $categoria[$key] = utf8_decode($value);
                //echo '<br/>resultado['.$key.'] = '.$value;
            }
        }
        //Añado las claves de estado y Mensaje y devuelvo el usuario logueado con el estado de la petición
        $categoria['estado_p'] = '200 OK';
        $categoria['Mensaje'] = 'Categoria recuperada correctamente';
        //var_dump($categoria);
        return $categoria;
    }
    
    public function modificarCategoriaId() {
        if(strcmp($this->categoria_padre, '\'\'')===0){
            $this->categoria_padre = 'NULL';
        }
        $sql = "UPDATE `categorias` SET nombre=".$this->nombre.", categoria_padre=".$this->categoria_padre." WHERE categoria_id = ".$this->categoria_id.";";
        var_dump($sql);
        
        $resultado = $this->conexion->execute($sql);

        if(!$resultado)
        {
            return array('estado' => '400 KO', 'Mensaje' => 'Error al modificar la categoria');
        }else
        {
            $categoria = $this->dameCategoriaId(str_replace("'", "", $this->categoria_id));
            $categoria['estado_p'] = '200 OK';
            $categoria['Mensaje'] = 'Categoria modificada correctamente';
            $categoria['accion'] = 'modificar';
            return $categoria;
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
        //CUIDADO!!! Las peticiones ajax con angularjs no devuelven datos si el debug de la conexión está activado.
        //$this->conexion->debug = true;
    }
}
