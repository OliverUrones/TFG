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
    public $token = 'NULL';
    public $validez_token = NULL;
    public $fecha_creacion = NULL;
    public $estado = 0;


    /**
     * Constructor de defecto que recoge los datos de $_POST y los guarda en los atributos
     */
    public function __construct() {
        
        //Llamo a la función para conectarse a la base de datos
        $this->__conexion();
        
        if(isset($_POST['usuario_id'])) {
            $this->usuario_id = $this->conexion->qStr($_POST['usuario_id']);
        }
        if(isset($_POST['rol_id'])) {
            $this->rol_id = $this->conexion->qStr($_POST['rol_id']);
        }
        if(isset($_POST['email'])) {
            $this->email = $this->conexion->qStr($_POST['email']);
        }
        if(isset($_POST['password'])) {
            $this->password = $this->conexion->qStr($_POST['password']);
        }
        if(isset($_POST['nombre'])) {
            $this->nombre = $this->conexion->qStr($_POST['nombre']);
        }
        if(isset($_POST['apellidos'])) {
            $this->apellidos = $this->conexion->qStr($_POST['apellidos']);
        }
        if(isset($_POST['token'])) {
            $this->token = $this->conexion->qStr($_POST['token']);
        }
        if(isset($_POST['validez_token'])) {
            $this->validez_token = $this->conexion->qStr($_POST['validez_token']);
        }
        if(isset($_POST['fecha_creacion'])) {
            $this->fecha_creacion = $this->conexion->qStr($_POST['fecha_creacion']);
        }
        if(isset($_POST['estado'])) {
            $this->estado = $this->conexion->qStr($_POST['estado']);
        }
    }

    /**
     * Función que introduce un usuario en la base de datos
     */
    public function altaUsuario() {
        //Establezco la fecha de creación con la fecha actual en formato año-mes-día hora:minutos:segundos
        $this->fecha_creacion = $this->conexion->qStr(date('y-m-d h:m:s'));
        
        
        //Compruebo si el correo del usuario que se va a crear no existe..
        if(!$this->__existe($this->email))
        {
            //..si no existe es un usuario no registrado
            //Genero el hash de la contraseña
            $this->__creaHash($this->password);
            //Consulta de inserción de un usuario a la base de datos
            $sql = "INSERT INTO `usuarios` (`rol_id`, `email`, `password`, `nombre`, `apellidos`, `token`, `fecha_creacion`, `estado` )"
                    . " VALUES (".$this->rol_id.", ".$this->email.", '".$this->password."', ". utf8_decode($this->nombre).", ". utf8_decode($this->apellidos).", "
                    .$this->token.", ".$this->fecha_creacion.", ".$this->estado.");";
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
        $this->conexion->debug = true;
    }
    
    /**
     * Función que comprueba si un usuario existe mediante su correo electrónico
     * @param string $email email del usuario a comprobar
     * @return boolean true si existe; false si no existe
     */
    private function __existe($email) {
        
        //Consulta para seleccionar el correo de un usuario
        $sql = "SELECT email FROM `usuarios` WHERE email=".$email.";";
        
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
     * Función que comprueba el estado de una cuetna asociada a un email. estado=1 --> activada; estado=0 --> desactivada
     * @param string $email
     * @return boolean True si la cuenta está activada | False si no está activada
     */
    private function __cuentaActivada($email) {
        //Consulta para comprobar que la cuenta asociada a un email está activada
        $sql = "SELECT estado FROM `usuarios` WHERE estado=1 AND email=".$email.";";
        
        //Intenta obtener una fila de la consulta
        $columna = $this->conexion->getRow($sql);
        //var_dump($columna);
        if(is_array($columna) && $columna['estado'] == 1)
        {
            //La cuenta está activada
            return true;
        } else {
            //La cuenta no está activada
            return false;
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
    
    /**
     * Función que devuelve el id de un usuario cuyo email exista o falso en caso contrario
     * @param type $email
     * @return boolean
     */
    private function __dameId($email) {
        
        //Consulta para seleccionar el identificador del usuario
        $sql = "SELECT usuario_id FROM `usuarios` WHERE email=".$email.";";
        
        //Intenta obtener una fila de la consulta
        $columna = $this->conexion->getRow($sql);
        
        //Si hay 0 elementos en el array..
        if(count($columna) == 0)
        {
            //..no existe el usuario con el email
            return false;
        } else
        {
            //..sino, sí existe
            //Y devuelvo el id del usuario
            return $columna['usuario_id'];
        }
        
        return false;
    }
    
    /**
     * Función que activa una cuenta en la base de datos.
     * @param string $id Id de la cuenta a activar
     */
    public function activarCuenta($id) {
        //Consulta para cambiar activar una cuenta
        $sql = "UPDATE `usuarios` SET `estado` = '1' WHERE `usuarios`.`estado` = 0 AND `usuarios`.`usuario_id` = ".$id[0].";";
        
        //Ejecución de la consulta
        $resultado = $this->conexion->execute($sql);
        
        //Cargar la vista con el mensaje correspondiente
    }
    
    /**
     * Función que devuelve los datos de un usuario logeado en formato JSON
     * @return JSON Datos de un usuario logeado en formato JSON
     */
    public function dameUsuario() {
        //var_dump($_POST);
        //Si existe el email que le viene...
        if($this->__existe($this->email))
        {
            //echo "Existe el email";
            //Compruebo si la cuenta está activada
            if($this->__cuentaActivada($this->email))
            {
                //Extraigo de la base de datos el hash correspondiente a ese email
                $hash = $this->__damePass($this->email);
                //Compruebo el hash extraído con la contraseña introducida del usuario...
                if(password_verify($this->password, $hash))
                {
                    //Si password_verify devuelve true el hash coincide y el usuario accede
                    //Recupero el id del usuario
                    $id = $this->__dameId($this->email);
                    
                    //Establezco la validez del token en segundos para 10 Minutos
                    $time = time(); //Fecha actual del sistema en segundos
                    $this->validez_token = ($time+600); //Se suma 600segundos para 10 Minutos de validez del token a la fecha actual
                    //echo '<br/>time: '.$time;
                    //echo '<br/>validez_token: '.$this->validez_token;
                    
                    //Consulta para actualizar los campos token y validez_token en la base de datos en función del id del usuario
                    $sql = "UPDATE `usuarios` SET `token` = '". uniqid()."', `validez_token` = ".$this->validez_token."  WHERE `usuarios`.`usuario_id` = ".$id.";";
                    //echo '<br/>'.$sql;

                    //Si la consulta se ejecuta correctamente..
                    if($this->conexion->execute($sql))
                    {
                        //Consulta para recupear los datos del usuario
                        $sql = "SELECT * FROM `usuarios` WHERE `usuarios`.`usuario_id`=".$id.";";
                        $resultado = $this->conexion->getRow($sql);
                        //var_dump($usuario);
                        foreach ($resultado as $key => $value) {
                            if(is_string($key))
                            {
                                $usuario[$key] = $value;
                                //echo '<br/>resultado['.$key.'] = '.$value;
                            }
                        }
                        //var_dump($usuario);
                        $json = $this->__construyeJSON('200 OK', 'Usuario logeado correctamente', 'usuario', $usuario);
                        return $json;
                    } else {
                        echo "Error al actualizar el token y la validez";
                    }
                } else {
                    //Si password_verify devuelve false; el hash no coincide y el usuario no accede
                    echo "Compruebe la contraseña";
                }
            } else {
                echo "La cuenta no está activada";
            }
        } else {
            //Sino es que el email no existe
            echo "No existe el email";
        }
    }
    
    /**
     * Función que devuelve el hash de una contraseña de usuario almacenada en la base de datos buscándolo por email
     * @param string $email Email del usuario registrado
     * @return boolean False Si el usuario no existe
     * @return string El hash del usuario si existe
     */
    private function __damePass($email) {
        //Consulta para seleccionar el password de un usuario
        $sql = "SELECT password FROM `usuarios` WHERE email=".$email.";";
        
        //Intenta obtener una fila de la consulta
        $columna = $this->conexion->getRow($sql);
        
        //Si hay 0 elementos en el array..
        if(count($columna) == 0)
        {
            //..no existe el usuario con el email
            return false;
        } else {
            //..sino, sí existe
            //Y devuelvo el password del usuario
            return $columna['password'];
        }
    }
    
    /**
     * Función que codifica en JSON los datos recibidos como parámetros
     * @param string $estado Estado de la petición
     * @param string $mensaje Mensaje de la petición
     * @param string $clave_datos Clave para el acceso a los datos en el JSON
     * @param array $datos Datos en forma de array asociativo
     * @return JSON Datos en JSON
     */
    private function __construyeJSON($estado, $mensaje, $clave_datos, $datos) {
        return json_encode(array('estado' => $estado, 'Mensaje' => $mensaje, $clave_datos => $datos));
        //var_dump($JSON);
    }
}
