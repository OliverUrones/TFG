<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modelos\usuariosModelo;
require_once ADODB;
require_once APLICACION.'modelos'.SEPARADOR.'envioEmailModelo.php';

/**
 * Description of usuariosModelo
 *
 * @author oliver
 */
class usuariosModelo {
    
    private $tabla = 'usuarios';
    private $conexion = NULL;
    public $usuario_id = NULL;
    public $rol_id = 2;
    public $email = NULL;
    public $password = NULL;
    public $nombre = NULL;
    public $apellidos = NULL;
    public $token = NULL;
    public $validez_token = NULL;
    public $fecha_creacion = NULL;
    public $estado = 0;


    /**
     * Constructor de defecto que recoge los datos de $_POST y los guarda en los atributos
     */
    public function __construct() {
        if(isset($_POST['usuario_id'])) {
            $this->usuario_id = $_POST['usuario_id'];
        }
        if(isset($_POST['rol_id'])) {
            $this->rol_id = $_POST['rol_id'];
        }
        if(isset($_POST['email'])) {
            $this->email = $_POST['email'];
        }
        if(isset($_POST['password'])) {
            $this->password = $_POST['password'];
        }
        if(isset($_POST['nombre'])) {
            $this->nombre = $_POST['nombre'];
        }
        if(isset($_POST['apellidos'])) {
            $this->apellidos = $_POST['apellidos'];
        }
        if(isset($_POST['token'])) {
            $this->token = $_POST['token'];
        }
        if(isset($_POST['validez_token'])) {
            $this->validez_token = $_POST['validez_token'];
        }
        if(isset($_POST['fecha_creacion'])) {
            $this->fecha_creacion = $_POST['fecha_creacion'];
        }
        if(isset($_POST['estado'])) {
            $this->estado = $_POST['estado'];
        }
    }

    /**
     * Función que introduce un usuario en la base de datos
     */
    public function altaUsuario() {
        //Establezco la fecha de creación con la fecha actual en formato año-mes-día hora:minutos:segundos
        $this->fecha_creacion = date('y-m-d h:m:s');
        
        //Llamo a la función para conectarse a la base de datos
        $this->__conexion();
        
        //Compruebo si el correo del usuario que se va a crear no existe..
        if(!$this->__existe($this->email))
        {
            //..si no existe es un usuario no registrado
            //Genero el hash de la contraseña
            $this->__creaHash($this->password);
            
            //Consulta de inserción de un usuario a la base de datos
            $sql = "INSERT INTO `usuarios` (`rol_id`, `email`, `password`, `nombre`, `apellidos`, `token`, `fecha_creacion`, `estado` )"
                    . " VALUES (".$this->rol_id.", '".$this->email."', '".$this->password."', '". utf8_decode($this->nombre)."', '". utf8_decode($this->apellidos)."', '"
                    .$this->token."', '".$this->fecha_creacion."', ".$this->estado.");";
            $recordSet = $this->conexion->execute($sql);
            $sql = $this->conexion->getInsertSql($this->tabla, $_POST);
            
            //Recupero el id del usuario recién registrado para mandarle luego el correo de activación
            $this->usuario_id = $this->__dameId($this->email);
            
            //Envio correo para activar cuenta
            $mail = new \app\modelos\envioEmailModelo\envioEmailModelo();
            $mail->activarCuenta($this->usuario_id, $this->email, $this->nombre, $this->apellidos);
            //$this->__enviarEmail();
        }else
        {
            //..si existe es que el usuario ya está en la base de datos
            echo 'Mensaje de que el correo ya existe';
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
    
    /**
     * Función que comprueba si un usuario existe mediante su correo electrónico
     * @param string $email email del usuario a comprobar
     * @return boolean true si existe; false si no existe
     */
    private function __existe($email) {
        
        //Consulta para seleccionar el correo de un usuario
        $sql = "SELECT email FROM `usuarios` WHERE email='".$email."';";
        
        //Intenta obtener una fila de la consulta
        $columna = $this->conexion->getRow($sql);
        //var_dump($columna);
        
        //Si hay 0 elementos en el array..
        if(count($columna) == 0)
        {
            //..no existe el usuario con el email
            return false;
        } else
        {
            //..sino, si existe
            return true;
        }
    }
    
    /**
     * Función que genera el hash de la contraseña
     * Se usará el algoritmo CRYPT_BLOWFISH con la constante PASSWORD_BCRYPT de php
     * @param string $password Contraseña que introduce el usuario
     */
    private function __creaHash($password) {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }
    
    private function __dameId($email) {
        
        //Consulta para seleccionar el identificador del usuario
        $sql = "SELECT usuario_id FROM `usuarios` WHERE email='".$email."';";
        
        //Intenta obtener una fila de la consulta
        $columna = $this->conexion->getRow($sql);
        
        //Si hay 0 elementos en el array..
        if(count($columna) == 0)
        {
            //..no existe el usuario con el email
            return false;
        } else
        {
            //..sino, si existe
            //Y devuelvo el id del usuario
            return $columna['usuario_id'];
        }
        
        return false;
    }
}
