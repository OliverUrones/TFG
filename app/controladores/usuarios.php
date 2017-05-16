<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controladores\usuarios;

use app\Api;
use app\interfaz\Rest\Rest;

use app\modelos\usuariosModelo\usuariosModelo;
use app\modelos\rolesModelo\rolesModelo;
use app\modelos\archivosModelo\archivosModelo;
use app\controladores\logs\logs;
use app\controladores\archivos\archivos;
/**
 * Description of usuarios
 *
 * @author oliver
 */
class usuarios extends Api\Api implements Rest {

    /**
     * Función que da de alta un usuario
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
     * @param array $parametros Array asociativo con el id y el token
     */
    public function baja($parametros=NULL) {
        echo "Estoy en la clase usuarios en el métod baja()";
        $this->DamePeticion();
        
        if($this->peticion === "GET") {
            echo "Vengo por GET";
            var_dump($parametros);
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
            echo "Vengo por POST";
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
     * Método que da de alata un usuario desde la parte de administración
     * 
     * Si la petición viene por GET se mostrará el formulario de alta y se le incluirán a la vista los datos del administrador y los roles del sistema en formato JSON.
     * Si la petición viene por POST se procesara el alta del nuevo usuario en la base de datos y se le incluirán a la vista los datos del administrador y el resultado de la operación en formato JSON.
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
     * @param type $parametros
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

    public function ver($id) {
        echo "Estoy en la clase usuarios en el método ver() y el parámetro id es ".$id[0];
    }
    
    /**
     * Método para modificar un usuario para la parte de administración.
     * Si la petición viene por GET se muestran los datos en el formulario de modificación.
     * Si la petición viene por POST se modificará el usuario en la base de datos.
     * Devuelve a la vista los datos del usuario que se va a modificar o que se ha modificado y los datos del administrador conectado.
     * @param array $parametros Con el id del usuario a modificar y el token del administrador conectado que va a modificar el usuario.
     * 
     */
    public function modificar($parametros=NULL) {
        echo "Estoy en la clase usuarios en el método modificar()";
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
            echo "La petición de modificar viene por POST";
            var_dump($_POST);
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
     * @param type $parametros
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
     * @param type $id
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
            
            //Si el usuaario logueado es de tipo administrador (rol_id = 1) ...
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
     * Función para loguearse en la parte pública
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
            
            $linea_log = [
                            "fecha" => '['.date("d-m-Y H:i:s").']',
                            "ip" => '[IP: '.$_SERVER['REMOTE_ADDR'].']',
                            "accion" => '[ACCION: '.'login'.']',
                            "estado" => '[ESTADO: '.$usuario['estado_p'].']',
                            "mensaje" => '[MENSAJE: '.$usuario['Mensaje'].']'
                        ];
            $logControlador = new logs('usuarios', $linea_log);

            //var_dump($usuario);

            //Se convierte los datos a JSON
            $usuario = $this->construyeJSON($usuario);

            //Función extract() para pasar los datos a la vista
            extract($usuario);
            
            //Redirección a la vista... y mensaje del estado del login ************ OJO
            $ruta_vista_perfil = VISTAS .'usuarios/perfil.php';
            require_once $ruta_vista_perfil;
        }
    }
    
    /**
     * Función para cerrar sesión
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
     * Función para cerrar la sesión de la parte privada de administración
     * @param array $parametros
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
}
