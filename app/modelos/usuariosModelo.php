<?php

namespace app\modelos\usuariosModelo;
//require_once ADODB;
//require_once ADODB_ADMIN;
require_once APLICACION.'modelos'.SEPARADOR.'envioEmailModelo.php';

/**
 * Clase modelo para la gestión de los datos de los usuarios en la base de datos
 *
 * @author A. Oliver Urones García
 * @copyleft (cc) 2017, Oliver Urones
 * @license https://creativecommons.org/licenses/by-nc-sa/4.0/ Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0)
 * @version 1.0
 */
class usuariosModelo {
    /**
     * Atributo con el nombre de la tabla en la base de datos
     * @var string
     */
    private $tabla = 'usuarios';
    /**
     * Atributo con la conexión a la base de datos
     * @var Objeto ADODB 
     */
    private $conexion = NULL;
    /**
     * Atributo identificador del usuario en la base de datos
     * @var int
     */
    public $usuario_id = NULL;
    /**
     * Atributo identificador del rol del usuario en la base de datos
     * @var int
     */
    public $rol_id = 2;
    /**
     * Atributo del email del usuario en la base de datos
     * @var string 
     */
    public $email = NULL;
    /**
     * Atributo de la contraseña del usuario
     * @var string
     */
    public $password = NULL;
    /**
     * Atributo del nombre del usuario en la base de datos
     * @var string
     */
    public $nombre = NULL;
    /**
     * Atributo de los apellidos del usuario en la base de datos
     * @var string
     */
    public $apellidos = NULL;
    /**
     * Atributo del token del usuario en la base de datos
     * @var string
     */
    public $token = 'NULL';
    /**
     * Atributo de la validez del token del usuario en la base de datos
     * @var int
     */
    public $validez_token = NULL;
    /**
     * Atributo de la fecha de creación del usuario en la base de datos
     * @var string
     */
    public $fecha_creacion = NULL;
    /**
     * Atributo que representa el estado de la cuenta del usuario en la base de datos.
     * 1 para activada; 0 para desactivada
     * @var int
     */
    public $estado = 0;


    /**
     * Constructor por defecto de la clase en donde se realiza la llamada al método privado __conexion() para realizar la conexión a la base de datos
     * Se establecen los atributos de la clase cuando éstos viene a través de una petición POST
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
        if(isset($_POST['email_login'])) {
            $this->email = $this->conexion->qStr($_POST['email_login']);
        }
        if(isset($_POST['password'])) {
            $this->password = $this->conexion->qStr($_POST['password']);
        }
        if(isset($_POST['password_login'])) {
            $this->password = $this->conexion->qStr($_POST['password_login']);
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
     * Método que devuelve el listado de todos los usuarios que se encuentran registrados en el sistema
     * 
     * La llamada a este método se realiza desde la parte privada de la aplicación
     * @return array $usuarios Array asociativo con los datos del listado de usuarios
     */
    public function listadoUsuarios() {
        $sql = "SELECT `usuarios`.*, `roles`.tipo FROM `usuarios`, `roles` WHERE `usuarios`.rol_id = `roles`.rol_id;";
        
        $recordset = $this->conexion->execute($sql)->getAssoc();
        
        //var_dump($recordset);
        if($recordset) {
            foreach ($recordset as $key => $value) {
                //echo '<br/>'.$key.' -- '.$value;
                foreach ($value as $columna => $valor) {
                    if(is_string($columna)) {
                        $usuarios[$key][$columna] = $valor;
                    }
                }
            }
            //var_dump($archivos);
            return $usuarios;
        }
        
    }
    /**
     * Método que introduce un usuario en la base de datos realizando la llamada desde la parte privada.
     * 
     * En este método no se mandará un correo de activación de cuenta al email correspondiente ya que se realiza el alta desde la parte privada 
     * y se deberá especificar en la vista si la cuenta se crea activada o desdactivada.
     * @return array $resultado Array asociativo del estado de la petición y su mensaje con las claves estado_p y Mensaje
     */
    public function altaUsuario() {
        //Establezco la fecha de creación con la fecha actual en formato año-mes-día hora:minutos:segundos
        $this->fecha_creacion = $this->conexion->qStr(date('y-m-d h:m:s'));
        
        if(!$this->__existe($this->email))
        {
            //..si no existe es un usuario no registrado
            //Genero el hash de la contraseña
            $this->__creaHash($this->password);
            //Consulta de inserción de un usuario a la base de datos
            $sql = "INSERT INTO `usuarios` (`rol_id`, `email`, `password`, `nombre`, `apellidos`, `token`, `fecha_creacion`, `estado` )"
                    . " VALUES (".$this->rol_id.", ".$this->email.", '".$this->password."', ". utf8_encode($this->nombre).", ". utf8_encode($this->apellidos).", "
                    .$this->token.", ".$this->fecha_creacion.", ".$this->estado.");";
            $recordSet = $this->conexion->execute($sql);
            $sql = $this->conexion->getInsertSql($this->tabla, $_POST);
            
            $resultado = array('estado_p' => '200 OK', 'Mensaje' => 'Usuario dado de alta correctamente.');
            //$json = $this->__construyeJSON('200 KO', 'Usuario añadido correctamente. Compruebe su correo para realizar la activación de la cuenta');
        }else
        {
            //..si existe es que el usuario ya está en la base de datos
            //echo 'Mensaje de que el correo ya existe';
            $resultado = array('estado_p' => '400 KO', 'Mensaje' => 'El correo introducido ya existe');
            //$json = $this->__construyeJSON('400 KO', 'El correo introducido ya existe', NULL, NULL);
        }        
            return $resultado;
    }

    /**
     * Método que introduce un usuario en la base de datos realizando la llamada desde la parte pública
     * @return array Array asociativo con el estado de la peticion y el mensaje correspondiente
     */
    public function registroUsuario() {
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
                    . " VALUES (".$this->rol_id.", ".$this->email.", '".$this->password."', ". utf8_encode($this->nombre).", ". utf8_encode($this->apellidos).", "
                    .$this->token.", ".$this->fecha_creacion.", ".$this->estado.");";
            $recordSet = $this->conexion->execute($sql);
            $sql = $this->conexion->getInsertSql($this->tabla, $_POST);
            
            //Recupero el id del usuario recién registrado para mandarle luego el correo de activación
            $this->usuario_id = $this->__dameId($this->email);
            
            //Envio correo para activar cuenta
            $mail = new \app\modelos\envioEmailModelo\envioEmailModelo();
            $mail->activarCuenta($this->usuario_id, $this->email, $this->nombre, $this->apellidos);
            //$this->__enviarEmail();
            $resultado = array('estado' => '200 OK', 'Mensaje' => 'Usuario añadido correctamente. Compruebe su correo para realizar la activación de la cuenta');
            //$json = $this->__construyeJSON('200 KO', 'Usuario añadido correctamente. Compruebe su correo para realizar la activación de la cuenta');
        }else
        {
            //..si existe es que el usuario ya está en la base de datos
            //echo 'Mensaje de que el correo ya existe';
            $resultado = array('estado' => '400 KO', 'Mensaje' => 'El correo introducido ya existe');
            //$json = $this->__construyeJSON('400 KO', 'El correo introducido ya existe', NULL, NULL);
        }        
            return $resultado;
    }
    
    /**
     * Método para que se borre un registro de usuario de la base de datos a través de Ajax
     * 
     * Se llamará a este método cuando un usuario quiera eliminar su cuenta
     * @param int $id Identificador del usuario cuya cuenta se va a eliminar
     * @return array $resultado Array con el resultado de la acción.
     */
    public function borraUsuarioIdAjax($id) {
        $this->__conexion();
        $sql = "DELETE FROM usuarios WHERE usuario_id=".$id.";";
        //var_dump($sql);
        $recordSet = $this->conexion->execute($sql);
        //var_dump($recordSet);
        //Comprobar mejor el recordSet
        if($recordSet) {
            //El usuario se ha borrado
            $resultado = array('estado_p' => '200 OK', 'Mensaje' => 'El usuario se ha borrado correctamente.');
        } else {
            //El usuario no se ha borrado
            $resultado = array('estado_p' => '400 KO', 'Mensaje' => 'El usuario no se ha podido borrar.');
        }
        
        return $resultado;
    }


    /**
     * Borra un usuario de la base de datos mediante su id viniendo por formulario POST
     * 
     * Se llamará a este método cuando se quiera borrar un usuario desde la parte privada
     * @return array Array asociativo con el estado de la petición y el mensaje correspondiente
     */
    public function borraUsuarioId() {
        $sql = "DELETE FROM usuarios WHERE usuario_id=".$this->usuario_id.";";
        //var_dump($sql);
        $recordSet = $this->conexion->execute($sql);
        //var_dump($recordSet);
        //Comprobar mejor el recordSet
        if($recordSet) {
            //El usuario se ha borrado
            $resultado = array('estado_p' => '200 OK', 'Mensaje' => 'El usuario se ha borrado correctamente.');
        } else {
            //El usuario no se ha borrado
            $resultado = array('estado_p' => '400 KO', 'Mensaje' => 'El usuario no se ha podido borrar.');
        }
        
        return $resultado;
    }
    
    /**
     * Método que modifica los datos del propio usuario logueado en la base de datos
     * 
     * Se llamará a este método cuando un usuario quiera cambiar sus propios datos
     * @return array $usuario Devuele el estado de la petición, el mensaje de ésta y los datos del usuario modificado en caso de éxito 
     */
    public function modificaDatosUsuarioId() {
        $sql = "UPDATE `usuarios` SET rol_id=".$this->rol_id.", nombre=". utf8_encode($this->nombre).", apellidos=". utf8_encode($this->apellidos)." WHERE usuario_id=".$this->usuario_id.";";
        
        //var_dump($sql);
        //Ejecución de la consulta
        $resultado = $this->conexion->execute($sql);

        if(!$resultado)
        {
            return array('estado_p' => '400 KO', 'Mensaje' => 'Error al modificar la cuenta.');
        }else
        {
            $usuario = $this->dameUsuarioId(str_replace("'", "", $this->usuario_id));
            $usuario['estado_p'] = '200 OK';
            $usuario['Mensaje'] = 'Usuario modificado correctamente';
            $usuario['accion'] = 'modificar';
            return $usuario;
        }
    }

    /**
     * Método que modifica los datos de un usuario desde la parte de administración
     * 
     * Se llamará a este método cuando se quiera modificar los datos de un usuario desde la parte privada
     * @return array Los datos del usuario que se acaba de modificar con el estado, el mensaje y la acción que se ha realizado
     */
    public function modificaUsuarioId() {
        $sql = "UPDATE `usuarios` SET rol_id=".$this->rol_id.", nombre=". utf8_encode($this->nombre).", apellidos=". utf8_encode($this->apellidos).", estado=".$this->estado." WHERE usuario_id=".$this->usuario_id.";";
        
        //var_dump($sql);
        //Ejecución de la consulta
        $resultado = $this->conexion->execute($sql);

        if(!$resultado)
        {
            return array('estado' => '400 KO', 'Mensaje' => 'Error al modificar la cuenta.');
        }else
        {
            $usuario = $this->dameUsuarioId(str_replace("'", "", $this->usuario_id));
            $usuario['estado_p'] = '200 OK';
            $usuario['Mensaje'] = 'Usuario modificado correctamente';
            $usuario['accion'] = 'modificar';
            return $usuario;
        }
    }
    
    /**
     * Método que actualiza la contraseña de un usuario
     * 
     * Se llamará a este método cuando un usuario quiera cambiar su contraseña actual
     * @return array Array asociativo con el estado de la petición y el mensaje correspondiente
     */
    public function cambiaPass() {
        $this->__creaHash($this->password);

        $sql = "UPDATE `usuarios` SET password='".$this->password."' WHERE usuario_id=".$this->usuario_id.";";
        
        $resultado = $this->conexion->execute($sql);
        
        if(!$resultado) {
            return array('estado_p' => '400 KO', 'Mensaje' => 'Error al cambiar la contraseña');
        } else {
            return array('estado_p' => '200 OK', 'Mensaje' => 'Contraseña cambiada correctamente');
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
        //$this->conexion->debug = true;
    }
    
    /**
     * Método para restablecer la contraseña de un usuario que se le ha olvidado
     * 
     * Si no viene el $id identificador del usuario se le mandará un correo al email proporcionado en el formulario y devolverá la respuesta del envío del email
     * @param int $id Identificador del usuario. Puede ser NULL
     * @return array Array asociativo con el estado de la petición y el mensaje correspondiente.
     */
    public function restablecerPass($id=NULL) {
        if(!isset($id)) {
            //echo "No viene el id";
            //Si no viene el $id como parámetro se le envía el correo al usuario
            if($this->__existe($this->email)) {
                //echo "el email ".$this->email." existe";
                $this->usuario_id = $this->__dameId($this->email);
                //Envio correo para activar cuenta
                $mail = new \app\modelos\envioEmailModelo\envioEmailModelo();
                if($mail->recordarPass($this->usuario_id, $this->email)) {
                    //El mensaje se ha enviado
                    return array('estado_p' => '200 OK', 'Mensaje' => 'Revise su correo para restablecer su contraseña');
                } else {
                    //No se ha enviado el mensaje
                    return array('estado_p' => '400 KO', 'Mensaje' => 'No se ha podido envíar el mensaje a su correo, por favor, inténtelo más tarde.');
                }
            } else {
                //El email no existe, mostrar mensaje de error correspondiente
                //echo "el email ".$this->email." NO existe";
                return array('estado_p' => '400 KO', 'Mensaje' => 'El email introducido no existe.');
            }
        } else {
            //Si viene el $id como parámetro, el correo ya ha sido envíado al usuario y éste a pulsado en el enlace
            return $this->cambiaPass();
        }
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
     * Función que comprueba el estado de una cuenta asociada a un email. estado=1 --> activada; estado=0 --> desactivada
     * @param string $email Email de usuario para comprobar si su cuenta está activada o no
     * @return boolean True si la cuenta está activada | False si no está activada
     */
    private function __cuentaActivada($email) {
        //Consulta para comprobar que la cuenta asociada a un email está activada
        $sql = "SELECT estado FROM `usuarios` WHERE estado=1 AND email=".$email.";";
        
        //Intenta obtener una fila de la consulta
        $columna = $this->conexion->getRow($sql);
        //var_dump($columna);
        if(isset($columna['estado']) && is_array($columna) && $columna['estado'] == 1)
        {
            //La cuenta está activada
            return true;
        } else {
            //La cuenta no está activada
            return false;
        }
    }


    /**
     * Método privado que establece el atributo password de la clase
     * 
     * Genera el hash encriptado de la contraseña
     * Se usará el algoritmo CRYPT_BLOWFISH con la constante PASSWORD_BCRYPT de php
     * @param string $password Contraseña que introduce el usuario
     */
    private function __creaHash($password) {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }
    
    /**
     * Método privado que devuelve el identificador de usuario si el email existe o falso en caso contrario
     * @param type $email
     * @return array|boolean $columna Array asociativo con el identificador del usuario en caso de éxtio o false en caso de fallo
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
     * Método que activa una cuenta en la base de datos.
     * 
     * Este método se ejecuta cuando el usuario recibe el email de activación de cuenta
     * @param string $id Identificador de la cuenta a activar
     * @return array Array asociativo con el estado de la petición y el mensaje correspondiente
     */
    public function activarCuenta($id) {
        //Comprueba el estado de la cuenta con id $id
        //Si este estado ya es 1; la cuenta ya está activada
        $estado = $this->__dameEstado($id);
        if($estado == 1){
            return array('estado' => '400 KO', 'Mensaje' => 'La cuenta ya está activada');
        } elseif ($estado === NULL) {
            return array('estado' => '400 KO', 'Mensaje' => 'No existe la cuenta');
        }else {
            //sino, se procede a activar la cuenta
            //Consulta para cambiar activar una cuenta
            $sql = "UPDATE `usuarios` SET `estado` = '1' WHERE `usuarios`.`estado` = 0 AND `usuarios`.`usuario_id` = ".$id.";";

            //Ejecución de la consulta
            $resultado = $this->conexion->execute($sql);

            if(!$resultado)
            {
                return array('estado' => '400 KO', 'Mensaje' => 'Error al activar la cuenta');
            }else
            {
                return array('estado' => '200 OK', 'Mensaje' => 'Cuenta activada correctamente');
            }
        }
    }
    
    /**
     * Método que devuelve el estado de una cuenta de usuario a través del identificador de usuario
     * @param int $id Identificador de la cuenta del usuario a comprobar el estado
     * @return int Devuelve el estado actual de la cuenta de usuario en caso de éxito o null en caso de fallo
     */
    function __dameEstado($id) {
        $sql = "SELECT `estado` FROM `usuarios` WHERE `usuario_id`=".$id.";";
        $resultado = $this->conexion->getRow($sql);
        if(!$resultado){
            return NULL;
        } else {
            return $resultado['estado'];
        }
    }


    /**
     * Método que establece el token y su validez a la hora de loguearse y devuelve el usuario logueado y el estado de la petición
     * @return array Devuelve un array asociativo con el estado de la petición, un mensaje y el usuario en caso de logueo exitoso
     */
    public function dameUsuarioLogueado() {
        //Si existe el email que le viene...
        if($this->__existe($this->email))
        {
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
                    
                    //Consulta para actualizar los campos token y validez_token en la base de datos en función del id del usuario
                    //uniqid() generará un id único con 13 caracteres al que se le añadirá la t delante para indicar que es el token
                    $token = 't'.uniqid();
                    $sql = "UPDATE `usuarios` SET `token` = '". $token ."', `validez_token` = ".$this->validez_token."  WHERE `usuarios`.`usuario_id` = ".$id.";";

                    //Si la consulta se ejecuta correctamente..
                    if($this->conexion->execute($sql))
                    {
                        //Consulta para recupear los datos del usuario
                        $sql = "SELECT * FROM `usuarios` WHERE `usuarios`.`usuario_id`=".$id.";";
                        $resultado = $this->conexion->getRow($sql);

                        //Recorro el array asociativo...
                        foreach ($resultado as $key => $value) {
                            //...para dejar las claves que sean string
                            if(is_string($key))
                            {
                                //Decodifico los valores del array con utf8
                                $usuario[$key] = utf8_decode($value);
                            }
                        }
                        
                        //Añado las claves de estado y Mensaje y devuelvo el usuario logueado con el estado de la petición
                        $usuario['estado_p'] = '200 OK';
                        $usuario['Mensaje'] = 'Usuario logeado correctamente';
                        return $usuario;
                    } else {
                        //echo "Error al actualizar el token y la validez";
                        $resultado = array('estado' => '400 KO', 'Mensaje' => 'Error al actualizar el token y la validez');
                        return $resultado;
                    }
                } else {
                    //Si password_verify devuelve false; el hash no coincide y el usuario no accede
                    $resultado = array('estado_p' => '400 KO', 'Mensaje' => 'Compruebe la contraseña');
                    return $resultado;
                }
            } else {
                $resultado = array('estado_p' => '400 KO', 'Mensaje' => 'La cuenta no está activada');
                return $resultado;
            }
        } else {
            //Sino es que el email no existe
            $resultado = array('estado_p' => '400 KO', 'Mensaje' => 'No existe el email');
            return $resultado;
        }
    }
    
    /**
     * Método que devuelve el hash de una contraseña de usuario almacenada en la base de datos buscándolo por email
     * @param string $email Email del usuario registrado
     * @return boolean False Si el usuario no existe
     * @return array $columna Array asociativo con el hash del usuario si existe
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
     * Método privado que devuelve la validez de un token
     * @param string $token Token a comprobar su validez
     * @return array $columna Array asociativo con la validez del token
     * @return bool False en caso de fallo
     */
    private function __validezToken($token) {
        //Consulta para seleccionar validez_token de un usuario
        $sql = "SELECT validez_token FROM `usuarios` WHERE token='".$token."';";
        
        //Intenta obtener una fila de la consulta
        $columna = $this->conexion->getRow($sql);
        
        if(isset($columna['validez_token'])) {
            return $columna['validez_token'];
        } else {
            return false;
        }
    }
    
    /**
     * Método que comprueba la validez de un token para comprobar si un usuario tiene una sesión abierta o no
     * @param string $token Token del usuario a comprobar la sesión
     * @return boolean True si el token es válido False si no lo es
     */
    public function compruebaValidezToken($token) {
        $validezToken = $this->__validezToken($token);
        $time = time();
        if($time > $validezToken) {
            //Token no válido
            //echo "token no válido";
            return false;
        } else {
            //Token válido
            //echo "token válido";
            return true;
        }
    }
    
    /**
     * Métod que devuelve los datos del usuario a través de un token
     * @param string $token Token del usuario a recuperar los datos
     * @return array $usuario Array asociativo con los datos del usuario, el estado de la petición y el mensaje correspondiente
     */
    public function dameUsuarioToken($token) {
        $sql = "SELECT * FROM `usuarios` WHERE token='".$token."'";
        
        $resultado = $this->conexion->getRow($sql);
        //var_dump($usuario);
        foreach ($resultado as $key => $value) {
            if(is_string($key))
            {
                $usuario[$key] = utf8_decode($value);
                //echo '<br/>resultado['.$key.'] = '.$value;
            }
        }
        //Añado las claves de estado y Mensaje y devuelvo el usuario logueado con el estado de la petición
        $usuario['estado_p'] = '200 OK';
        $usuario['Mensaje'] = 'Sesión establecida correctamente';
        return $usuario;
    }
    
    /**
     * Método que devuelve los datos del usuario a traves del id
     * @param int $id Identificador del usuario a recuperar los datos
     * @return array $usuario Array asociativo con los datos del usuario recuperado
     */
    public function dameUsuarioId($id) {
        $sql = "SELECT * FROM `usuarios` WHERE usuario_id='".$id."'";
        
        $resultado = $this->conexion->getRow($sql);
        //var_dump($resultado);
        foreach ($resultado as $key => $value) {
            if(is_string($key))
            {
                $usuario[$key] = utf8_decode($value);
                //echo '<br/>resultado['.$key.'] = '.$value;
            }
        }
        //Añado las claves de estado y Mensaje y devuelvo el usuario logueado con el estado de la petición
        $usuario['estado_p'] = '200 OK';
        $usuario['Mensaje'] = 'Usuario recuperado correctamente';
        return $usuario;
    }

    /**
     * Método que actualiza el campo token y validez_token a NULL para cerrar la sesión de un usuario
     * @param int $id Identificador del usuario
     * @return array Array asociativo con el estado de la petición y el mensaje correspondiente
     */
    public function borraDatosSesion($id) {
        //Consulta para poner quitar el token y la validez
        $sql = "UPDATE `usuarios` SET `token` = NULL, `validez_token` = NULL WHERE `usuarios`.`usuario_id` = ".$id.";";
        
        if($this->conexion->execute($sql)) {
            return array('estado_p' => '200 OK', 'Mensaje' => 'Sesión cerrada correctamente');
        } else {
            return array('estado_p' => '400 OK', 'Mensaje' => 'Ha habido un problema al cerrar la sesión');
        }

    }
}
