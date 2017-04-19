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
        var_dump($rol);
        return $rol;
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
