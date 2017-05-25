<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controladores\categorias;

use app\Api\Api;
use app\interfaz\Rest\Rest;

//Uso de los modelos
use app\modelos\usuariosModelo\usuariosModelo;
use app\modelos\categoriasModelo\categoriasModelo;

/**
 * Description of categorias
 *
 * @author oliver
 */
class categorias extends Api implements Rest {
    /**
     * Función para dar de alta una nueva categoría.
     * @param array $parametros Array asociativo con el token del administrador conectado
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
                                
                                $modeloCategorias = new categoriasModelo();
                                $listaCategorias = $modeloCategorias->dameCategorias();
                                $listaCategorias = $this->construyeJSON($listaCategorias);
                                
                                extract($listaCategorias);

                                $ruta_vista_admin_alta = VISTAS .'categorias/admin_alta.php';
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

                                $modeloCategorias = new categoriasModelo();
                                $resultado = $modeloCategorias->nuevaCategoria();
                                $resultado = $this->construyeJSON($resultado);
                                
                                extract($resultado);
                                
                                $ruta_vista_admin_alta = VISTAS .'categorias/admin_alta.php';
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
     * Función para dar de baja una categoría desde la parte de administración
     * @param array $parametros Array asociativo con el id de la categoría a dar de baja y el token del administrador conectado
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

                                $modeloCategoria = new categoriasModelo();
                                //$rolBorrar = $modeloUsuario->dameUsuarioId($parametros['id']);
                                $categoriaBorrar = $modeloCategoria->dameCategoriaId($parametros['id']);
                                $categoriaBorrar = $this->construyeJSON($categoriaBorrar);

                                extract($categoriaBorrar);

                                //var_dump($usuarioBorrar);

                                $ruta_vista_admin_borrar = VISTAS .'categorias/admin_borrar.php';
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

                               $modeloCategoria = new categoriasModelo();
                                //$rolBorrar = $modeloUsuario->dameUsuarioId($parametros['id']);
                                $borrado = $modeloCategoria->borraCategoriaId();
                                $borrado = $this->construyeJSON($borrado);

                                extract($borrado);

                                //var_dump($usuarios);

                                $ruta_vista_admin_borrar = VISTAS .'categorias/admin_borrar.php';
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
    
    public function modificar($parametros=NULL) {
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
                            $modeloCategoria = new categoriasModelo();
                            $categoria = $modeloCategoria->dameCategoriaId($parametros['id']);
                            $categoria['categorias'] = $modeloCategoria->dameCategorias();
                            $categoria = $this->construyeJSON($categoria);
                            $admin = $modeloUsuario->dameUsuarioToken($parametros['token']);

                            //Construyo la cadena JSON
                            $admin = $this->construyeJSON($admin);
                            extract($categoria);
                            //Devuelvo lo datos del usuario a la vista
                            extract($admin);

                            $ruta_vista_admin_modificar = VISTAS .'categorias/admin_modificar.php';
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
                                
                                $modeloCategoria = new categoriasModelo();
                                $categoria = $modeloCategoria->modificarCategoriaId();
                                
                                $categorias = $modeloCategoria->dameCategorias();
                                $categoria['categorias'] = $categorias;
                                $categoria = $this->construyeJSON($categoria);
                                
                                extract($categoria);
                                //var_dump($categoria);
                                
                                $ruta_vista_admin_modificar = VISTAS .'categorias/admin_modificar.php';
                                require_once $ruta_vista_admin_modificar;
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
     * Método para listar las categorías desde la parte privada
     * @param type $parametros
     */
    public function listar($parametros=NULL) {
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
                            
                            $modeloCategorias = new categoriasModelo();
                            $categorias = $modeloCategorias->dameCategorias();
                            $categorias = $this->construyeJSON($categorias);
                            
                            extract($categorias);
                            
                            //var_dump($usuarios);

                            $ruta_vista_admin_listado = VISTAS .'categorias/admin_listado.php';
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

    public function listarAjax($params=NULL) {
        $categorias = new categoriasModelo();
        $categorias = $categorias->dameCategorias();
        
        $categorias = $this->construyeJSON($categorias);
        $this->tipo = "application/json";
        $this->EstablecerCabeceras();
        echo $categorias;
    }
    
    public function ver($parametros=NULL) {
        
    }
}
