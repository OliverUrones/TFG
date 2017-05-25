<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controladores\roles;

use app\Api\Api;
use app\interfaz\Rest\Rest;

use app\modelos\usuariosModelo\usuariosModelo;
use app\modelos\rolesModelo\rolesModelo;

/**
 * Description of roles
 *
 * @author oliver
 */
class roles extends Api implements Rest {
    
    /**
     * Método para añadir un nuevo rol al sistema
     */
    public function alta($parametros=NULL) {
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

                                $ruta_vista_admin_alta = VISTAS .'roles/admin_alta.php';
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

                                $modeloRoles = new rolesModelo();
                                $resultado = $modeloRoles->nuevoRol();
                                $resultado = $this->construyeJSON($resultado);
                                
                                extract($resultado);

                                //var_dump($usuarios);

                                $ruta_vista_admin_alta = VISTAS .'roles/admin_alta.php';
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
     * Método para dar de baja un rol desde la parte privada de la aplicación
     * @param type $parametros
     */
    public function baja($parametros=NULL) {
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

                                $modeloRol = new rolesModelo();
                                //$rolBorrar = $modeloUsuario->dameUsuarioId($parametros['id']);
                                $rolBorrar = $modeloRol->dameRolId($parametros['id']);
                                $rolBorrar = $this->construyeJSON($rolBorrar);

                                extract($rolBorrar);

                                //var_dump($usuarioBorrar);

                                $ruta_vista_admin_borrar = VISTAS .'roles/admin_borrar.php';
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

                                $modeloRol = new rolesModelo();
                                $borrado = $modeloRol->borraRolId();
                                $borrado = $this->construyeJSON($borrado);

                                //$borrado es la respuesta json para devolver a la vista el mensaje
                                extract($borrado);

                                //var_dump($usuarios);

                                $ruta_vista_admin_borrar = VISTAS .'roles/admin_borrar.php';
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
     * Método que modifica el rol
     * 
     * Si la petición se realiza por GET se comprueba que venga el id del rol a modificar y el token del administrador logueado para recuperar los datos
     * del rol a modificar y mostrarlos en el formulario de modificación
     * 
     * Si la petición se realiza por POST se comprueba que venga el token del administrador para que se pueda llamar al modelo que modifica el rol en la base de datos.
     * @param array $parametros Array asociativo con las claves de id del rol y token del administrador
     */
    public function modificar($parametros=NULL) {
        //var_dump($parametros);
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
                            $modeloRoles = new rolesModelo();
                            $rol = $modeloRoles->dameRolId($parametros['id']);
                            $rol = $this->construyeJSON($rol);
                            $admin = $modeloUsuario->dameUsuarioToken($parametros['token']);

                            //Construyo la cadena JSON
                            $admin = $this->construyeJSON($admin);
                            extract($rol);
                            //Devuelvo lo datos del usuario a la vista
                            extract($admin);

                            $ruta_vista_admin_modificar = VISTAS .'roles/admin_modificar.php';
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

                                $rol = new rolesModelo();
                                $rol = $rol->modificarRolId();
                                
                                //Añado los roles al usuario recuperado para mostrar el tipo del rol en vez de el id
                                $rol = $this->construyeJSON($rol);

                                //$borrado es la respuesta json para devolver a la vista el mensaje
                                extract($rol);

                                //var_dump($usuarios);

                                $ruta_vista_admin_modificar = VISTAS .'roles/admin_modificar.php';
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
     * Método para listar los roles que hay en el sistema desde la parte privada de la aplicación
     * @param type $parametros
     */
    public function listar($parametros=NULL) {
        //echo "Voy a listar los roles";
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
                            
                            $rolesModelo = new rolesModelo();
                            $roles = $rolesModelo->listadoRoles();
                            
                            $roles = $this->construyeJSON($roles);
                            
                            extract($roles);

                            //var_dump($usuarios);

                            $ruta_vista_admin_listado = VISTAS .'roles/admin_listado.php';
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
        
    }
}
