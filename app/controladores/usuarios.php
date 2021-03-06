<?php

namespace app\controladores\usuarios;

use app\Api;
use app\interfaz\Rest\Rest;

use app\modelos\usuariosModelo\usuariosModelo;
use app\modelos\rolesModelo\rolesModelo;
use app\modelos\archivosModelo\archivosModelo;
use app\controladores\logs\logs;
use app\controladores\archivos\archivos;
/**
 * Clase controlador para la gestión de las acciones relacionadas con los usuarios
 * Esta clase usa los modelos de usuarios, roles y archivos.
 * También usa los controladores logs y archivos.
 *
 * @author A. Oliver Urones García
 * @copyleft (cc) 2017, Oliver Urones
 * @license https://creativecommons.org/licenses/by-nc-sa/4.0/ Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0)
 * @version 1.0
 */
class usuarios extends Api\Api implements Rest {

    /**
     * Método para el registro de usuarios desde la parte pública.
     * 
     * Si la petición viene por GET: Se muestra la vista con el formulario de alta
     * Si la petición viene por POST: Se muestra el resultado del alta del nuevo usuario
     * @param type $parametros
     */
    public function alta($parametros=NULL) {
        //Incluyo las otras partes del layout
        //Tendría que incluir las categorías aquí también y en cada uno de los métodos
//        $ruta_vista_login = VISTAS . 'usuarios/login.php';
//        require_once $ruta_vista_login;
        
        //Si viene el directorio de una conversión anterior lo borro
        if(isset($parametros['directorio'])) {
            //var_dump($parametros['directorio']);
            $controladorArchivos = new archivos();
            $controladorArchivos->borrarDirectorioId($parametros['directorio']);
        }
        //Recoge el tipo de petición realizada
        $this->DamePeticion();
        
        //Si viene por GET...
        if($this->peticion === "GET")
        {
            //..muestra el forumulario de registro
            $ruta_vista = VISTAS .'usuarios/alta.php' ;
            require_once $ruta_vista;
        }
        
        //Si viene por POST
        if($this->peticion === "POST")
        {
            //Se crea un objeto del modelo usuarios
            $usuariosModelo = new usuariosModelo();
            
            //Se llama al método del modelo usuarios que añade un usuario a la base de datos
            $registro = $usuariosModelo->registroUsuario();
            
            $registro = $this->construyeJSON($registro);
            
            //Paso los datos a la vista
            extract($registro);
            
            //Redirección a la vista... y mensaje para comprobación de correo para la activación de la cuenta
            $ruta_vista_alta = VISTAS .'usuarios/alta.php' ;
            require_once $ruta_vista_alta;
        }
    }
    
    /**
     * Método para dar de baja una cuenta de usuario a través del propio perfil del usuario.
     * 
     * Esta petición se realiza por POST a través de Ajax
     * @param array $parametros Array asociatio con el id del usuario a borrar y su token
     */
    public function bajaCuenta($parametros=NULL) {
        $json = file_get_contents('php://input');
        //var_dump($json);
        $parametros = json_decode($json, true);
        $error_json = json_last_error_msg();
        
        if(isset($parametros) && count($parametros) === 2) {
            if(isset($parametros['id']) && isset($parametros['token'])) {
                if(strlen($parametros['token']) === 14) {
                    $modeloUsuario = new usuariosModelo();
                    if($modeloUsuario->compruebaValidezToken($parametros['token'])) {
                        $modeloArchivos = new archivosModelo();
                        if($modeloArchivos->borraTodosArchivosPorIdUsuario($parametros['id'])) {
                            $respuesta = $modeloUsuario->borraUsuarioIdAjax($parametros['id']);
                            $respuesta = $this->construyeJSON($respuesta);
                            $this->tipo = "application/json";
                            $this->EstablecerCabeceras();
                            echo $respuesta;
                        } else {
                            $respuesta = $this->construyeJSON(array('estado_p' => '400 KO', 'Mensaje' => 'No se ha podido borrar su cuenta, por favor intentelo mas tarde'));
                            $this->tipo = "application/json";
                            $this->EstablecerCabeceras();
                            echo $respuesta;
                        }
                    } else {
                        $respuesta = $this->construyeJSON(array('estado_p' => '400 KO', 'Mensaje' => 'La sesión ha caducado'));
                        $this->tipo = "application/json";
                        $this->EstablecerCabeceras();
                        echo $respuesta;
                    }
                }
            }
        }
    }

    /**
     * Método para dar de baja a un usuario desde la parte privada
     * 
     * Si la petición viene por GET: Se recuperarán los datos del usuario en cuestión para visualizarlos
     * Si la petición viene por POST: Se borrará el usuario de la base de datos
     * @param array $parametros Array asociativo con el id y el token
     */
    public function baja($parametros=NULL) {
        //echo "Estoy en la clase usuarios en el métod baja()";
        $this->DamePeticion();
        
        if($this->peticion === "GET") {
            //echo "Vengo por GET";
            //var_dump($parametros);
            if(is_array($parametros)){
                if(isset($parametros['token']) && isset($parametros['id']))
                {
                    if(strlen($parametros['token']) === 14) {
                        //Creo un objeto usuario
                        $modeloUsuario = new usuariosModelo();
                        //Si el token es válido...
                        if($modeloUsuario->compruebaValidezToken($parametros['token'])) {
                            //...recupero los datos del usuario
                            $admin = $modeloUsuario->dameUsuarioToken($parametros['token']);

                            if(isset($admin['rol_id']) && $admin['rol_id'] === '1' && $admin['estado'] === '1')
                            {

                                //Construyo la cadena JSON
                                $admin = $this->construyeJSON($admin);
                                //Devuelvo lo datos del usuario a la vista
                                //var_dump($usuario);
                                extract($usuario);

                                $usuarioBorrar = $modeloUsuario->dameUsuarioId($parametros['id']);
                                $usuarioBorrar = $this->construyeJSON($usuarioBorrar);

                                extract($usuarioBorrar);

                                //var_dump($usuarioBorrar);

                                $ruta_vista_admin_borrar = VISTAS .'usuarios/admin_borrar.php';
                                require_once $ruta_vista_admin_borrar;
                            } else {
                                //No tiene permiso
                            }
                        } else {
                            $error = $this->construyeJSON(array('estado_p' => '400 KO', 'Mensaje' => 'La sesión ha caducado.'));
                            extract($error);
                            
                            $ruta_vista_admin_login = VISTAS.'usuarios/admin_login.php';
                            require_once $ruta_vista_admin_login;
                        }
                    }
                }
            }
        }
        
        if($this->peticion === "POST") {
            //echo "Vengo por POST";
            //var_dump($parametros);
            if(is_array($parametros)){
                if(isset($parametros['token']))
                {
                    if(strlen($parametros['token']) === 14) {
                        //Creo un objeto usuario
                        $modeloUsuario = new usuariosModelo();
                        //Si el token es válido...
                        if($modeloUsuario->compruebaValidezToken($parametros['token'])) {
                            //...recupero los datos del usuario
                            $admin = $modeloUsuario->dameUsuarioToken($parametros['token']);

                            if(isset($admin['rol_id']) && $admin['rol_id'] === '1' && $admin['estado'] === '1')
                            {

                                //Construyo la cadena JSON
                                $admin = $this->construyeJSON($admin);
                                //Devuelvo lo datos del usuario a la vista
                                //var_dump($usuario);
                                extract($admin);

                                $borrado = $modeloUsuario->borraUsuarioId();
                                $borrado = $this->construyeJSON($borrado);

                                //$borrado es la respuesta json para devolver a la vista el mensaje
                                extract($borrado);

                                //var_dump($usuarios);

                                $ruta_vista_admin_borrar = VISTAS .'usuarios/admin_borrar.php';
                                require_once $ruta_vista_admin_borrar;
                            } else {
                                //No tiene permiso
                            }
                        } else {
                            $error = $this->construyeJSON(array('estado_p' => '400 KO', 'Mensaje' => 'La sesión ha caducado.'));
                            extract($error);
                            
                            $ruta_vista_admin_login = VISTAS.'usuarios/admin_login.php';
                            require_once $ruta_vista_admin_login;
                        }
                    }
                }
            }
        }
    }
    
    /**
     * Método que da de alta un usuario desde la parte de administración
     * 
     * Si la petición viene por GET: Se mostrará el formulario de alta y se le incluirán a la vista los datos del administrador y los roles del sistema en formato JSON.
     * Si la petición viene por POST: Se procesara el alta del nuevo usuario en la base de datos y se le incluirán a la vista los datos del administrador y el resultado de la operación en formato JSON.
     * @param array $parametros Array asociativo con el token del usuario administrador
     */
    public function altaAdmin($parametros=NULL) {
        $this->DamePeticion();
        if($this->peticion === "GET") {
            if(is_array($parametros)) {
                if(isset($parametros['token'])) {
                    if(strlen($parametros['token']) === 14) {
                        //Creo un objeto usuario
                        $modeloUsuario = new usuariosModelo();
                        //Si el token es válido...
                        if($modeloUsuario->compruebaValidezToken($parametros['token'])) {
                            //...recupero los datos del usuario
                            $admin = $modeloUsuario->dameUsuarioToken($parametros['token']);
                            if(isset($admin['rol_id']) && $admin['rol_id'] === '1' && $admin['estado'] === '1') {
                                //Construyo la cadena JSON
                                $admin = $this->construyeJSON($admin);
                                //Devuelvo lo datos del usuario a la vista
                                //var_dump($usuario);
                                extract($admin);
                                
                                $modeloRoles = new rolesModelo();
                                $roles = $modeloRoles->listadoRoles();
                                $roles = $this->construyeJSON($roles);
                                
                                extract($roles);

                                //var_dump($usuarios);

                                $ruta_vista_admin_listado = VISTAS .'usuarios/admin_alta.php';
                                require_once $ruta_vista_admin_listado;
                            } else {
                                //No tiene permiso
                            }
                        } else {
                            $error = $this->construyeJSON(array('estado_p' => '400 KO', 'Mensaje' => 'La sesión ha caducado.'));
                            extract($error);
                            
                            $ruta_vista_admin_login = VISTAS.'usuarios/admin_login.php';
                            require_once $ruta_vista_admin_login;
                        }
                    }
                }
            }
        }
        
        if($this->peticion === "POST") {
            if(is_array($parametros)){
                if(isset($parametros['token']))
                {
                    if(strlen($parametros['token']) === 14) {
                        //Creo un objeto usuario
                        $modeloUsuario = new usuariosModelo();
                        //Si el token es válido...
                        if($modeloUsuario->compruebaValidezToken($parametros['token'])) {
                            //...recupero los datos del usuario
                            $admin = $modeloUsuario->dameUsuarioToken($parametros['token']);

                            if(isset($admin['rol_id']) && $admin['rol_id'] === '1' && $admin['estado'] === '1')
                            {

                                //Construyo la cadena JSON
                                $admin = $this->construyeJSON($admin);
                                //Devuelvo lo datos del usuario a la vista
                                //var_dump($usuario);
                                extract($admin);

                                $resultado = $modeloUsuario->altaUsuario();
                                $resultado = $this->construyeJSON($resultado);

                                extract($resultado);

                                //var_dump($usuarios);

                                $ruta_vista_admin_alta = VISTAS .'usuarios/admin_alta.php';
                                require_once $ruta_vista_admin_alta;
                            } else {
                                //No tiene permiso
                            }
                        } else {
                            $error = $this->construyeJSON(array('estado_p' => '400 KO', 'Mensaje' => 'La sesión ha caducado.'));
                            extract($error);
                            
                            $ruta_vista_admin_login = VISTAS.'usuarios/admin_login.php';
                            require_once $ruta_vista_admin_login;
                        }
                    }
                }
            }
        }
    }

    /**
     * Método para listar los usuarios de la aplicación desde la parte privada
     * 
     * Este método se ejecuta por GET exclusivamente y recupera el listado de todos los usuarios en el sistema para visualizarlos
     * @param array $parametros Array asocitivo con el token del usuario administrador conectado
     */
    public function listar($parametros=NULL) {
        //echo "Estoy en la clase usuarios en el método listar";
        if(is_array($parametros)){
            if(isset($parametros['token']))
            {
                if(strlen($parametros['token']) === 14) {
                    //Creo un objeto usuario
                    $modeloUsuario = new usuariosModelo();
                    //Si el token es válido...
                    if($modeloUsuario->compruebaValidezToken($parametros['token'])) {
                        //...recupero los datos del usuario
                        $admin = $modeloUsuario->dameUsuarioToken($parametros['token']);
                        
                        if(isset($admin['rol_id']) && $admin['rol_id'] === '1' && $admin['estado'] === '1')
                        {

                            //Construyo la cadena JSON
                            $admin = $this->construyeJSON($admin);
                            //Devuelvo lo datos del usuario a la vista
                            //var_dump($usuario);
                            extract($admin);
                            
                            $usuarios = $modeloUsuario->listadoUsuarios();
                            $usuarios = $this->construyeJSON($usuarios);
                            
                            extract($usuarios);
                            
                            //var_dump($usuarios);

                            $ruta_vista_admin_listado = VISTAS .'usuarios/admin_listado.php';
                            require_once $ruta_vista_admin_listado;
                        } else {
                            //No tiene permiso
                        }
                    } else {
                        $error = $this->construyeJSON(array('estado_p' => '400 KO', 'Mensaje' => 'La sesión ha caducado.'));
                        extract($error);

                        $ruta_vista_admin_login = VISTAS.'usuarios/admin_login.php';
                        require_once $ruta_vista_admin_login;
                    }
                }
            }
        }
    }

    /**
     * Método creado en caso de que se quiera ver los datos de un usuario en concreto para la parte privada.
     * 
     * No está implementado, en caso de que se quiera implementar se deberá implementar.
     * Este método es sobrecargado desde la clase interfaz Rest
     * @param type $id
     */
    public function ver() {
        //echo "Estoy en la clase usuarios en el método ver() y el parámetro id es ".$id[0];
    }
    
    /**
     * Método para modificar un usuario para la parte de administración.
     * 
     * Si la petición viene por GET: Se muestran los datos en el formulario de modificación.
     * Si la petición viene por POST: Se modificará el usuario en la base de datos.
     * Devuelve a la vista los datos del usuario que se va a modificar o que se ha modificado y los datos del administrador conectado.
     * @param array $parametros Array asociativo con el id del usuario a modificar y el token del administrador conectado que va a modificar el usuario.
     * 
     */
    public function modificar($parametros=NULL) {
        //echo "Estoy en la clase usuarios en el método modificar()";
        $this->DamePeticion();
        if($this->peticion === "GET") {
            if(is_array($parametros) && count($parametros) === 2){
                if(isset($parametros['id']) && isset($parametros['token']))
                {
                    if(strlen($parametros['token']) === 14) {
                        //Creo un objeto usuario
                        //var_dump($parametros);
                        $modeloUsuario = new usuariosModelo();
                        //Si el token es válido...
                        if($modeloUsuario->compruebaValidezToken($parametros['token'])) {
                            //...recupero los datos del usuario
                            $usuario = $modeloUsuario->dameUsuarioId($parametros['id']);
                            
                            //Recupero los roles
                            $roles = new rolesModelo();
                            $roles = $roles->listadoRoles();
                            
                            //Añado los roles al usuario recuperado para mostrar el tipo del rol en vez de el id
                            $usuario['roles'] = $roles;
                            $usuario = $this->construyeJSON($usuario);
                            $admin = $modeloUsuario->dameUsuarioToken($parametros['token']);

                            //Construyo la cadena JSON
                            $admin = $this->construyeJSON($admin);
                            extract($usuario);
                            //Devuelvo lo datos del usuario a la vista
                            extract($admin);

                            $ruta_vista_admin_modificar = VISTAS .'usuarios/admin_modificar.php';
                            require_once $ruta_vista_admin_modificar;
                        } else {
                            $error = $this->construyeJSON(array('estado_p' => '400 KO', 'Mensaje' => 'La sesión ha caducado.'));
                            extract($error);
                            
                            $ruta_vista_admin_login = VISTAS.'usuarios/admin_login.php';
                            require_once $ruta_vista_admin_login;
                        }
                    }

                }
            }
        }
        
        if($this->peticion === "POST") {
            //Si viene la modificación por formulario
            //echo "La petición de modificar viene por POST";
            //var_dump($_POST);
            if(is_array($parametros)){
                if(isset($parametros['token']))
                {
                    if(strlen($parametros['token']) === 14) {
                        //Creo un objeto usuario
                        $modeloUsuario = new usuariosModelo();
                        //Si el token es válido...
                        if($modeloUsuario->compruebaValidezToken($parametros['token'])) {
                            //...recupero los datos del usuario
                            $admin = $modeloUsuario->dameUsuarioToken($parametros['token']);

                            if(isset($admin['rol_id']) && $admin['rol_id'] === '1' && $admin['estado'] === '1')
                            {

                                //Construyo la cadena JSON
                                $admin = $this->construyeJSON($admin);
                                //Devuelvo lo datos del usuario a la vista
                                //var_dump($usuario);
                                extract($admin);

                                $usuario = $modeloUsuario->modificaUsuarioId();
                                
                                //Recupero los roles
                                $roles = new rolesModelo();
                                $roles = $roles->listadoRoles();
                                
                                //Añado los roles al usuario recuperado para mostrar el tipo del rol en vez de el id
                                $usuario['roles'] = $roles;
                                $usuario = $this->construyeJSON($usuario);

                                //$borrado es la respuesta json para devolver a la vista el mensaje
                                extract($usuario);

                                //var_dump($usuarios);

                                $ruta_vista_admin_modificar = VISTAS .'usuarios/admin_modificar.php';
                                require_once $ruta_vista_admin_modificar;
                            } else {
                                //No tiene permiso
                            }
                        } else {
                            $error = $this->construyeJSON(array('estado_p' => '400 KO', 'Mensaje' => 'La sesión ha caducado.'));
                            extract($error);
                            
                            $ruta_vista_admin_login = VISTAS.'usuarios/admin_login.php';
                            require_once $ruta_vista_admin_login;
                        }
                    }
                }
            }
        }
    }
    
    /**
     * Método para que un usuario cambie su contraseña desde el perfil del usuario.
     * 
     * Si la petición viene por GET: Se muestra el formulario para el cambio de contraseña
     * Si la petición viene por POST: Se modificará la contraseña del usuario que ha solicitado el cambio.
     * @param array $parametros Array asociativo con las claves del id y token del usuario que realiza el cambio de contraseña
     */
    public function cambiarPass($parametros=NULL) {
        $this->DamePeticion();
        if($this->peticion === 'GET') {
            if(is_array($parametros) && count($parametros) === 2) {
                if(isset($parametros['id']) && isset($parametros['token'])) {
                    if(strlen($parametros['token']) === 14) {
                        $modeloUsuario = new usuariosModelo();
                        if($modeloUsuario->compruebaValidezToken($parametros['token'])) {
                            $usuario = $modeloUsuario->dameUsuarioId($parametros['id']);

                            $usuario = $this->construyeJSON($usuario);

                            extract($usuario);

                            $ruta_vista_modificar_pass = VISTAS . 'usuarios/cambiarPass.php';
                            require_once $ruta_vista_modificar_pass;
                        } else {
                            $error = $this->construyeJSON(array('estado_p' => '400 KO', 'Mensaje' => 'La sesión ha caducado.'));
                            extract($error);

                            $ruta_vista_login = VISTAS.'usuarios/login.php';
                            require_once $ruta_vista_login;
                        }
                    }
                }
            }
        }
        
        if($this->peticion === 'POST') {
            if(is_array($parametros) && count($parametros) === 2) {
                if(isset($parametros['id']) && isset($parametros['token'])) {
                    if(strlen($parametros['token']) === 14) {
                        $modeloUsuario = new usuariosModelo();
                        if($modeloUsuario->compruebaValidezToken($parametros['token'])) {
                            $respuesta = $modeloUsuario->cambiaPass();
                            $respuesta = $this->construyeJSON($respuesta);
                            
                            extract($respuesta);
                            
                            $usuario = $modeloUsuario->dameUsuarioId($parametros['id']);
                            $usuario = $this->construyeJSON($usuario);

                            extract($usuario);
                            
                            $ruta_vista_modificar_pass = VISTAS . 'usuarios/cambiarPass.php';
                            require_once $ruta_vista_modificar_pass;
                            
                        } else {
                            $error = $this->construyeJSON(array('estado_p' => '400 KO', 'Mensaje' => 'La sesión ha caducado.'));
                            extract($error);

                            $ruta_vista_login = VISTAS.'usuarios/login.php';
                            require_once $ruta_vista_login;
                        }
                    }
                }
            }
        }
    }

    /**
     * Método para editar los datos del propio usuario logueado
     * 
     * Si la petición viene por GET: Se muestra el formulario para la modificación de los datos
     * Si la petición viene por POST: Se modifican los datos del usuario
     * @param array $parametros Array asociativo con las claves id y token del usuario logueado
     */
    public function modificarDatos($parametros=NULL) {
        $this->DamePeticion();
        if($this->peticion === "GET") {
            if(is_array($parametros) && count($parametros) === 2){
                if(isset($parametros['id']) && isset($parametros['token']))
                {
                    if(strlen($parametros['token']) === 14) {
                        //Creo un objeto usuario
                        //var_dump($parametros);
                        $modeloUsuario = new usuariosModelo();
                        //Si el token es válido...
                        if($modeloUsuario->compruebaValidezToken($parametros['token'])) {
                            //...recupero los datos del usuario
                            $usuario = $modeloUsuario->dameUsuarioId($parametros['id']);
                                                        
                            $usuario = $this->construyeJSON($usuario);

                            extract($usuario);

                            $ruta_vista_modificar = VISTAS .'usuarios/modificar.php';
                            require_once $ruta_vista_modificar;
                        } else {
                            $error = $this->construyeJSON(array('estado_p' => '400 KO', 'Mensaje' => 'La sesión ha caducado.'));
                            extract($error);
                            
                            $ruta_vista_login = VISTAS.'usuarios/login.php';
                            require_once $ruta_vista_login;
                        }
                    }

                }
            }
        }
        
        if($this->peticion === "POST") {
            //var_dump($_POST);
            if(is_array($parametros)){
                if(isset($parametros['token']))
                {
                    if(isset($parametros['id']) && isset($parametros['token']) && strlen($parametros['token']) === 14) {
                        //Creo un objeto usuario
                        $modeloUsuario = new usuariosModelo();
                        //Si el token es válido...
                        if($modeloUsuario->compruebaValidezToken($parametros['token'])) {
                            //...recupero los datos del usuario
                            $usuario = $modeloUsuario->modificaDatosUsuarioId();

                            $usuario = $this->construyeJSON($usuario);

                            //$borrado es la respuesta json para devolver a la vista el mensaje
                            extract($usuario);

                            //var_dump($usuarios);

                            $ruta_vista_modificar = VISTAS .'usuarios/modificar.php';
                            require_once $ruta_vista_modificar;
                        } else {
                            $error = $this->construyeJSON(array('estado_p' => '400 KO', 'Mensaje' => 'La sesión ha caducado.'));
                            extract($error);
                            
                            $ruta_vista_login = VISTAS.'usuarios/login.php';
                            require_once $ruta_vista_login;
                        }
                    }
                }
            }
        }
    }

    /**
     * Función que devuelve los datos del perfil de un usuario
     * 
     * Este método se ejecuta sólo por GET
     * @param array $parametros Array asociativo con las clave id y token del usuario a modificar y directorio para el borrado del directorio temporal de una conversión de archivo anterior.
     */
    public function perfil($parametros=NULL) {
        //Si viene el directorio de una conversión anterior lo borro
            //var_dump($parametros);
        if(isset($parametros['directorio'])) {
            $controladorArchivos = new archivos();
            $controladorArchivos->borrarDirectorioId($parametros['directorio']);
        }
        $this->DamePeticion();
        if($this->peticion === "GET") {
            if(is_array($parametros) && (count($parametros) === 2 || count($parametros) === 3)){
                if(isset($parametros['id']) && isset($parametros['token']))
                {
                    if(strlen($parametros['token']) === 14) {
                        //Creo un objeto usuario
                        $modeloUsuario = new usuariosModelo();
                        //Si el token es válido...
                        if($modeloUsuario->compruebaValidezToken($parametros['token'])) {
                            //...recupero los datos del usuario
                            $usuario = $modeloUsuario->dameUsuarioToken($parametros['token']);

                            //Construyo la cadena JSON
                            $usuario = $this->construyeJSON($usuario);
                            //Devuelvo lo datos del usuario a la vista
                            //var_dump($usuario);
                            extract($usuario);
                            
                            $ruta_vista_perfil = VISTAS .'usuarios/perfil.php';
                            require_once $ruta_vista_perfil;
                        } else {
                            $error = $this->construyeJSON(array('estado_p' => '400 KO', 'Mensaje' => 'La sesión ha caducado.'));
                            extract($error);
                            
                            $ruta_vista_login = VISTAS.'usuarios/login.php';
                            require_once $ruta_vista_login;
                        }
                    }

                }
            }
        }
        //Compruebo la validez del token del usuario con usuario_id = $id
    }
    
    /**
     * Método para el acceso de usuarios con rol administardor en la parte privada
     * 
     * Este método se ejecuta sólo por POST 
     */
    public function admin() {
        //echo "Estoy en el método admin() de la clase usuarios";
        
        //Recojo el tipo de petición
        $this->DamePeticion();
        
        //Si viene por post...
        if($this->peticion === "POST")
        {
            //Creo un modelo usuarios;
            $usuarioModelo = new usuariosModelo();
            
            //Recupero los datos del usuario logueado
            $admin = $usuarioModelo->dameUsuarioLogueado();
            //var_dump($usuario);
            
            //Si el usuario logueado es de tipo administrador (rol_id = 1) ...
            if(isset($admin['rol_id']) && $admin['rol_id'] === '1' && $admin['estado'] === '1')
            {
                //echo "Soy administrador";
                //Cargo la página inicial del back end
                $admin = $this->construyeJSON($admin);
                extract($admin);
                $ruta_vista_admin_home = VISTAS.'admin_home.php';

                require_once $ruta_vista_admin_home;
            } else {
                //echo "NO soy administrador";
                //Recargo la página de index del directorio admin
                $error = $this->construyeJSON(array('estado_p' => '400 KO', 'Mensaje' => 'Compruebe el usuario y/o la contraseña. No está permitido el acceso a los usuarios que no son administradores.'));
                extract($error);
                
                $ruta_vista_login = VISTAS.'usuarios/admin_login.php';

                require_once $ruta_vista_login;
            }
        }
    }

    /**
     * Método que realiza el ingreso a la aplicación desde la parte pública.
     * 
     * Si la petición viene por GET: Se muestra el formulario de acceso.
     * Si la petición viene por POST: Se ejecutará el intento de ingreso
     * @param array $parametros Array asociativo con la clave directorio para el borrado del directorio temporar de una conversión anterior
     */
    public function login($parametros=NULL) {
        //echo "Estoy en la clase usuarios en el método login()";
        
        //Si viene el directorio de una conversión anterior lo borro
        if(isset($parametros['directorio'])) {
            //var_dump($parametros['directorio']);
            $controladorArchivos = new archivos();
            $controladorArchivos->borrarDirectorioId($parametros['directorio']);
        }
        //Incluyo las otras partes del layout
        //Tendría que incluir las categorías aquí también y en cada uno de los métodos

        //Recoge el tipo de petición realizada
        $this->DamePeticion();
        
        //Viene por GET
        if($this->peticion === "GET")
        {
            //..muestra el forumulario de login
            $ruta_vista_login = VISTAS . 'usuarios/login.php';
            require_once $ruta_vista_login;
        }

        //Si viene por POST
        if($this->peticion === "POST")
        {
            //Se crea un objeto del modelo usuarios
            $usuariosModelo = new usuariosModelo();

            //Se llama al método del modelo usuarios recupera los datos del usuario a loguearse
            $usuario = $usuariosModelo->dameUsuarioLogueado();
            
            if($usuario['estado_p'] === '400 KO') {
                //Redirijo al login de nuevo
                $linea_log = [
                                "fecha" => '['.date("d-m-Y H:i:s").']',
                                "ip" => '[IP: '.$_SERVER['REMOTE_ADDR'].']',
                                "accion" => '[ACCION: '.'login'.']',
                                "estado" => '[ESTADO: '.$usuario['estado_p'].']',
                                "mensaje" => '[MENSAJE: '.$usuario['Mensaje'].']'
                            ];
                $logControlador = new logs('usuarios', $linea_log);
                //Se convierte los datos a JSON
                $usuario = $this->construyeJSON($usuario);

                //Función extract() para pasar los datos a la vista
                extract($usuario);
                
                //..muestra el forumulario de login
                $ruta_vista_login = VISTAS . 'usuarios/login.php';
                require_once $ruta_vista_login;
            } else {
                //Login correcto
                $linea_log = [
                                "fecha" => '['.date("d-m-Y H:i:s").']',
                                "ip" => '[IP: '.$_SERVER['REMOTE_ADDR'].']',
                                "accion" => '[ACCION: '.'login'.']',
                                "estado" => '[ESTADO: '.$usuario['estado_p'].']',
                                "mensaje" => '[MENSAJE: '.$usuario['Mensaje'].']'
                            ];
                $logControlador = new logs('usuarios', $linea_log);
                //Se convierte los datos a JSON
                $usuario = $this->construyeJSON($usuario);

                //Función extract() para pasar los datos a la vista
                extract($usuario);
                
                //Redirección a la vista... y mensaje del estado del login ************ OJO
                $ruta_vista_perfil = VISTAS .'usuarios/perfil.php';
                require_once $ruta_vista_perfil;
            }
            

            //var_dump($usuario);

            
        }
    }
    
    /**
     * Método para cerrar la sesión de un usuario en la parte pública.
     * 
     * Este método se ejecuta por GET exclusivamente
     * @param array $parametros Array asociativo con el id del usuario que cierra la sesión y directorio para el borrado del directorio temporar de conversión
     */
    public function logout($parametros = NULL) {
        //Si viene el directorio de una conversión anterior lo borro
            //var_dump($parametros);
        if(isset($parametros['directorio'])) {
            $controladorArchivos = new archivos();
            $controladorArchivos->borrarDirectorioId($parametros['directorio']);
        }
        //Recogo el tipo de petición realizada
        $this->DamePeticion();
        //si viene por GET...
        if($this->peticion === "GET") {
            //Compruebo si viene el id
            if(isset($parametros['id']))
            {
                //var_dump($parametros);
                //Se crea un objeto del modelo usuarios
                $usuariosModelo = new usuariosModelo();
                $estado_peticion = $usuariosModelo->borraDatosSesion($parametros['id']);
                //echo $estado_peticion['Mensaje'];
                $estado_peticion = $this->construyeJSON($estado_peticion);
                extract($estado_peticion);
                $linea_log = [
                            "fecha" => '['.date("d-m-Y H:i:s").']',
                            "ip" => '[IP: '.$_SERVER['REMOTE_ADDR'].']',
                            "accion" => '[ACCION: '.'logout'.']',
                            "estado" => '[ESTADO: '.$estado_peticion['estado_p'].']',
                            "mensaje" => '[MENSAJE: '.$estado_peticion['Mensaje'].']'
                        ];
                $logControlador = new logs('usuarios', $linea_log);
                
                //Requerir la vista correspondiente
                $ruta_vista_logout = VISTAS .'usuarios/logout.php';
                require_once $ruta_vista_logout;
            }
        }   
    }
    
    /**
     * Método para cerrar la sesión de un usuario administrado en la parte privada.
     * 
     * Este método se ejecuta por GET exclusivamente
     * @param array $parametros Array asociativo con la clave id del usuario administrador
     */
    public function adminLogout($parametros=NULL) {
        //Recogo el tipo de petición realizada
        $this->DamePeticion();
        //si viene por GET...
        if($this->peticion === "GET") {
            //Compruebo si viene el id
            if(isset($parametros['id']))
            {
                //var_dump($parametros);
                //Se crea un objeto del modelo usuarios
                $usuariosModelo = new usuariosModelo();
                $estado_peticion = $usuariosModelo->borraDatosSesion($parametros['id']);
                $estado_peticion = $this->construyeJSON($estado_peticion);
                //echo $estado_peticion['Mensaje'];
                extract($estado_peticion);
                //Requerir la vista correspondiente
                $ruta_vista_admin_logout = VISTAS .'usuarios/admin_logout.php';
                require_once $ruta_vista_admin_logout;
            }
        }
    }

    /**
     * Método para activar la cuenta de un nuevo usuario registrado
     * 
     * Este método se ejecuta exclusivamente por GET y a través del enlace que se le envia al email del usuario recién registrado
     * @param array $parametros Array asociativo con el id del usuario a activar la cuenta
     */
    public function activar($parametros = NULL) {
        //echo "Se va a activar la cuenta con id = ".$id[0];
        //Incluyo las otras partes del layout
        //Tendría que incluir las categorías aquí también y en cada uno de los métodos
//        $ruta_vista_login = VISTAS . 'usuarios/login.php';
//        require_once $ruta_vista_login;
        
        //Recoge el tipo de petición realizada
        $this->DamePeticion();
        
        //Si viene por GET...
        if($this->peticion === "GET") {
            //Compruebo que sólo viene un parámetro por la url
            if(isset($parametros['id'])){
                //Se crea un objeto del modelo usuarios
                $usuariosModelo = new usuariosModelo();

                //Se llama al método del modelo usuarios que activa una cuenta que devuele el JSON con el mensaje y el estado de la petición
                $estado_activacion = $usuariosModelo->activarCuenta($parametros['id']);
                $estado_activacion = $this->construyeJSON($estado_activacion);
                //var_dump($estado_activacion);
                
                //Paso el JSON a la vista
                extract($estado_activacion);
                
                //Cargo la vista de la activación de la cuenta para mostrar el mensaje
                $ruta_vista_estado_activacion = VISTAS . 'usuarios/estado_activacion.php';
                require_once $ruta_vista_estado_activacion;
            }
        }
    }
    
    /**
     * Método que controla el envío del formulario para cuando un usuario olvida su contraseña
     * 
     * Si la petición viene por GET: se muestra el formulario para enviar el email
     * Si la petición viene por POST: se llama al método restablecerPass() de la clase modeloUsuarios para enviar el email al usuario
     */
    public function recordar() {
        //echo "Estoy en el método recordar() del controlador usuarios";
        $this->DamePeticion();
        
        if($this->peticion === 'GET') {
            $ruta_vista_recordar = VISTAS . 'usuarios/recordar.php';
            require_once $ruta_vista_recordar;
        }
        
        if($this->peticion === 'POST') {
            $modeloUsuarios = new usuariosModelo();
            $respuesta = $modeloUsuarios->restablecerPass();
            $respuesta = $this->construyeJSON($respuesta);
            
            extract($respuesta);
            
            $ruta_vista_recordar = VISTAS . 'usuarios/recordar.php';
            require_once $ruta_vista_recordar;
        }
    }
    
    /**
     * Método que se ejecuta cuando se le manda el correo al usuario que ha olvidado la contraseña
     * 
     * Si la petición viene por GET: se le muestra el formulario para introducir la nueva contraseña
     * Si la petición viene por POST: se llama al método restablecerPass del modelo usuarios para establecer el cambio en la base de datos
     * @param array $parametros Array asociativo con el id del usuario.
     */
    public function restablecer($parametros=NULL) {
        $this->DamePeticion();
        if($this->peticion === 'GET' && isset($parametros['id'])) {
            //Si la petición viene por GET el usuario ha pinchado en el enlace que se le ha enviado al correo
            $usuario_id = $this->construyeJSON($parametros);
            extract($usuario_id);
            $ruta_vista_restablecer = VISTAS . 'usuarios/restablecer.php';
            require_once $ruta_vista_restablecer;
        }
        
        if($this->peticion === 'POST') {
            $modeloUsuarios = new usuariosModelo();
            $respuesta = $modeloUsuarios->restablecerPass($parametros['id']);
            $respuesta = $this->construyeJSON($respuesta);
            
            extract($respuesta);
            
            $ruta_vista_restablecer = VISTAS . 'usuarios/restablecer.php';
            require_once $ruta_vista_restablecer;
        }
    }
}
