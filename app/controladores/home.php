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

/**
 * Description of home
 *
 * @author oliver
 */
class home extends Api\Api {
    
    /*Constructor*/
    public function home() {
    }
    
    /*Método de la petición por defecto*/
    public function index($parametros=NULL) {
        //echo "Estoy en el método index() de la clase home";
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
    
    public function admin($parametros=NULL) {
        echo "Estoy en el método admin() de la clase home";
    }
}