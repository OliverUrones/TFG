<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controladores\home;

use app\Api;
use app\interfaz\Rest\Rest;

use app\modelos\usuariosModelo\usuariosModelo;
use app\controladores\archivos\archivos;

/**
 * Clase controlador que contiene los métodos por defecto que se ejecutarán al iniciar la aplicación
 *
 * @author A. Oliver Urones García
 * @copyleft (cc) 2017, Oliver Urones
 * @license https://creativecommons.org/licenses/by-nc-sa/4.0/ Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0)
 * @version 1.0
 */
class home extends Api\Api {
    
    /*Constructor*/
//    public function home() {
//    }
    
    /**
     * Método que ejecuta la petición por defecto.
     * 
     * Este método carga la vista inicial de la aplicación mandando los datos necesarios al archivo app/vistas/home.php
     * @param array $parametros Array con los parámetros de la petición si los hubiera.
     */
    public function index($parametros=NULL) {
        //echo "Estoy en el método index() de la clase home";
        //Si viene el directorio de una conversión anterior lo borro
        if(isset($parametros['directorio'])) {
            //var_dump($parametros['directorio']);
            $controladorArchivos = new archivos();
            $controladorArchivos->borrarDirectorioId($parametros['directorio']);
        }
        //Incluir la ruta de las categorías.php
        $ruta_vista_home = VISTAS.'home.php';
//        $ruta_vista_login = VISTAS.'usuarios/login.php';

        //Si vienen parámetros, compruebo que la longitud sea de 14 caracteres que es la longitud de un token
        if(isset($parametros['token']))
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
                }
            }
        }
        
//        require_once $ruta_vista_login;
        require_once $ruta_vista_home;
    }
    
    /**
     * Método que ejecuta la petición por defecto para la parte privada.
     * 
     * Carga la vista del login para la parte privada
     * @param array $parametros Array con los parámetros de la petición si los hubiera.
     */
    public function admin($parametros=NULL) {
        //echo "Estoy en el método admin() de la clase home";
        
        $ruta_vista_login = VISTAS.'usuarios/admin_login.php';
        
        if(isset($parametros['token']))
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
                } else {
                    $error = $this->construyeJSON(array('estado_p' => '400 KO', 'Mensaje' => 'La sesión ha caducado.'));
                    extract($error);

                    require_once $ruta_vista_admin_login;
                }
            }
        } else {
            require_once $ruta_vista_login;
        }
    }
    
    /**
     * Método que ejecuta la petición para la parte privada.
     * 
     * Carga la vista admin_home.php para la parte privada que será la pantalla inicial después de haber iniciado sesión.
     * @param array $parametros Array asociativo con el token del usuario que está logueado
     */
    public function adminIndex($parametros=NULL) {
        $ruta_vista_home = VISTAS.'admin_home.php';
        
        //Si vienen parámetros, compruebo que la longitud sea de 14 caracteres que es la longitud de un token
        if(isset($parametros['token']))
        {
            if(strlen($parametros['token']) === 14) {
                //Creo un objeto usuario
                $modeloUsuario = new usuariosModelo();
                //Si el token es válido...
                if($modeloUsuario->compruebaValidezToken($parametros['token'])) {
                    //...recupero los datos del usuario
                    $admin = $modeloUsuario->dameUsuarioToken($parametros['token']);
                    
                    //Construyo la cadena JSON
                    $admin = $this->construyeJSON($admin);
                    //Devuelvo lo datos del usuario a la vista
                    //var_dump($usuario);
                    extract($admin);
                    require_once $ruta_vista_home;
                } else {
                    $error = $this->construyeJSON(array('estado_p' => '400 KO', 'Mensaje' => 'La sesión ha caducado.'));
                    extract($error);

                    $ruta_vista_admin_login = VISTAS.'usuarios/admin_login.php';
                    require_once $ruta_vista_admin_login;
                }
            }
        } else {
            $error = $this->construyeJSON(array('estado_p' => '400 KO', 'Mensaje' => 'No tiene permiso para ver esta página.'));
            extract($error);

            $ruta_vista_admin_login = VISTAS.'usuarios/admin_login.php';
            require_once $ruta_vista_admin_login;
        }
    }
}