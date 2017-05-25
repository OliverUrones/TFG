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
     * Método que crea una nueva categoría en la base de datos
     * @return array $resultado Array asociativo con el estado de la petición y el mensaje correspondiente de ésta
     */
    public function nuevaCategoria() {
        if(strcmp($this->categoria_padre, '\'\'')===0){
            $this->categoria_padre = 'NULL';
        }
        $sql = "INSERT INTO `categorias` (`categoria_id`, `nombre`, `categoria_padre`) VALUES (NULL, ". utf8_encode($this->nombre).", ".$this->categoria_padre.")";
        
        $recordSet = $this->conexion->execute($sql);
        
        if(!$recordSet) {
            $resultado = array('estado_p' => '400 KO', 'Mensaje' => 'No se ha podido guardar la categoría.');
        } else {
            $resultado = array('estado_p' => '200 OK', 'Mensaje' => 'Categoría guardada correctamente.');
        }
        
        return $resultado;
    }

    /**
     * Método que devuelve todas las categorías
     * @return array $categorias Array asociativo con las categorías devueltas
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
    
    /**
     * Método que devuelve los datos e una categoría a través de su id
     * @param int $id Identificador de la categoría.
     * @return array $cateogira Array asociativo con los datos de la categoría, el estado de la petición y el mensaje correspondiente de ésta
     */
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
    
    /**
     * Borra una categoría a través de su ID viniendo por POST
     * @return array $resultado Array asociativo con el estado de la petición y el mensaje de ésta
     */
    public function borraCategoriaId() {
        $sql = "DELETE FROM categorias WHERE categoria_id=".$this->categoria_id.";";
        //var_dump($sql);
        $recordSet = $this->conexion->execute($sql);
        //var_dump($recordSet);
        //Comprobar mejor el recordSet
        if($recordSet) {
            //El usuario se ha borrado
            $resultado = array('estado_p' => '200 OK', 'Mensaje' => 'La categoria se ha borrado correctamente.');
        } else {
            //El usuario no se ha borrado
            $resultado = array('estado_p' => '400 KO', 'Mensaje' => 'La categoria no se ha podido borrar.');
        }
        return $resultado;
    }

        public function modificarCategoriaId() {
        if(strcmp($this->categoria_padre, '\'\'')===0){
            $this->categoria_padre = 'NULL';
        }
        $sql = "UPDATE `categorias` SET nombre=". utf8_encode($this->nombre).", categoria_padre=".$this->categoria_padre." WHERE categoria_id = ".$this->categoria_id.";";
        //var_dump($sql);
        
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
