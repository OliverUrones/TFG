<?php

namespace app\modelos\categoriasModelo;
require_once dirname(__DIR__).DIRECTORY_SEPARATOR.'adodb5/adodb.inc.php';
//require_once ADODB;

/**
 * Clase modelo para la gestión de los datos de las categorías en la base de datos
 *
 * @author A. Oliver Urones García
 * @copyleft (cc) 2017, Oliver Urones
 * @license https://creativecommons.org/licenses/by-nc-sa/4.0/ Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0)
 * @version 1.0
 */
class categoriasModelo {
    /**
     * Atributo con el nombre de la tabla en la base de datos
     * @var string
     */
    private $tabla = 'categorias';
    /**
     * Atributo con la conexión a la base de datos
     * @var Objeto ADODB 
     */
    private $conexion = NULL;
    /**
     * Atributo identificador de la categoría en la base de datos
     * @var int
     */
    public $categoria_id = NULL;
    /**
     * Atributo con el nombre 
     * @var string
     */
    public $nombre = NULL;
    /**
     * Atributo identificador de la categoría padre en la base de datos
     * @var int
     */
    public $categoria_padre = NULL;
    
    /**
     * Constructor por defecto de la clase en donde se realiza la llamada al método privado __conexión para realizar la conexión a la base de datos
     * Se establecen los atributos de la clase cuando éstos viene a través de una petición POST
     */
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
     * Método que devuelve todas las categorías de la base de datos
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
                    $categorias[$key][$columna] = utf8_decode($valor);
                }
            }
        }
        //var_dump($categorias);
        return $categorias;
    }
    
    /**
     * Método que devuelve los datos de una categoría a través de su identificador
     * @param int $id Identificador de la categoría.
     * @return array $categoria Array asociativo con los datos de la categoría, el estado de la petición y el mensaje correspondiente de ésta
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
     * Método que borra una categoría a través de su identificador viniendo por POST
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

    /**
     * Método que modifica los datos de una categoría a través de su identificador en la base de datos
     * @return array $categoria Array asociativo con los datos del estado de la petición, el mensaje informativo y los datos de la categoría modificada en caso de éxito
     */
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
     * Método privado para realizar la conexión a la base de datos.
     * 
     * Establece el atributo conexión de la clase como un objeto ADODB
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
