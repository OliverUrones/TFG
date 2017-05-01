<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modelos\rolesModelo;
require_once dirname(__DIR__).DIRECTORY_SEPARATOR.'adodb5/adodb.inc.php';


/**
 * Description of rolesModelo
 *
 * @author oliver
 */
class rolesModelo {
    private $tabla = 'roles';
    private $conexion = NULL;
    public $rol_id = NULL;
    public $tipo = NULL;
    
    public function __construct() {
        //Llamo a la función para conectarse a la base de datos
        $this->__conexion();
        
        if(isset($_POST['rol_id'])){
            $this->rol_id = $this->conexion->qStr($_POST['rol_id']);
        }
        if(isset($_POST['tipo'])){
            $this->tipo = $this->conexion->qStr($_POST['tipo']);
        }
    }
    
    /**
     * Método que añade un nuevo rol a la base de datos
     * @return array $resultado Array asociativo con el estado de la petición y el mensaje correspondiente de ésta
     */
    public function nuevoRol() {
        $sql = "INSERT INTO `roles` (`rol_id`, `tipo`) VALUES (NULL, ".$this->tipo.");";
        
        $recordSet = $this->conexion->execute($sql);
        
        if(!$recordSet) {
            $resultado = array('estado_p' => '400 KO', 'Mensaje' => 'No se ha podido guardar el nuevo rol.');
        } else {
            $resultado = array('estado_p' => '200 OK', 'Mensaje' => 'Rol guardado correctamente.');
        }
        
        return $resultado;
    }
    
    /**
     * Método para borrar un rol de la base de datos a través de su id
     * @return array $resultado Array asociativo con el estado de la petición y el mensaje correspondiente de ésta.
     */
    public function borraRolId() {
        $sql = "DELETE FROM roles WHERE rol_id=".$this->rol_id.";";
        //var_dump($sql);
        $recordSet = $this->conexion->execute($sql);
        var_dump($recordSet);
        //Comprobar mejor el recordSet
        if($recordSet) {
            //El usuario se ha borrado
            $resultado = array('estado_p' => '200 OK', 'Mensaje' => 'El rol se ha borrado correctamente.');
        } else {
            //El usuario no se ha borrado
            $resultado = array('estado_p' => '400 KO', 'Mensaje' => 'El rol no se ha podido borrar.');
        }
        
        return $resultado;
    }

    /**
     * Método que devuelve el listado de roles de la base de datos
     * @return array $roles Array asociativo con los datos de los roles
     */
    public function listadoRoles() {
        $sql = "SELECT * FROM `roles`;";
        
        $recordset = $this->conexion->execute($sql);
        //var_dump($recordset);
        if($recordset) {
            foreach ($recordset as $key => $value) {
                //echo '<br/>'.$key.' -- '.$value;
                foreach ($value as $columna => $valor) {
                    //var_dump($columna);
                    if(is_string($columna)) {
                        $roles[$key][$columna] = $valor;
                    }
                }
            }
            //var_dump($roles);
            return $roles;
        }
    }
    
    public function dameRolId($id) {
        $sql = "SELECT * FROM roles WHERE rol_id='".$id."';";
        
        $resultado = $this->conexion->getRow($sql);
        //var_dump($resultado);
        foreach ($resultado as $key => $value) {
            if(is_string($key))
            {
                $rol[$key] = utf8_decode($value);
                //echo '<br/>resultado['.$key.'] = '.$value;
            }
        }
        //Añado las claves de estado y Mensaje y devuelvo el usuario logueado con el estado de la petición
        $rol['estado_p'] = '200 OK';
        $rol['Mensaje'] = 'Rol recuperado correctamente';
        //var_dump($rol);
        return $rol;
    }
    
    public function modificarRolId() {
        $sql = "UPDATE `roles` SET tipo=".$this->tipo." WHERE rol_id=".$this->rol_id.";";
        var_dump($sql);
        $resultado = $this->conexion->execute($sql);

        if(!$resultado)
        {
            return array('estado' => '400 KO', 'Mensaje' => 'Error al modificar el rol.');
        }else
        {
            $rol = $this->dameRolId(str_replace("'", "", $this->rol_id));
            $rol['estado_p'] = '200 OK';
            $rol['Mensaje'] = 'Rol modificado correctamente';
            $rol['accion'] = 'modificar';
            var_dump($rol);
            return $rol;
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
