<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controladores\home;

use app\Api;
use app\modelos\usuariosModelo\usuariosModelo;

/**
 * Description of home
 *
 * @author oliver
 */
class home {
    
    /*Constructor*/
    public function home() {
    }
    
    /*Método de la petición por defecto*/
    public function index($parametros=NULL) {
        //echo "Estoy en el método index() de la clase home";
        //Incluir la ruta de las categorías.php
        $ruta_vista_home = VISTAS.'home.php';
        $ruta_vista_login = VISTAS.'usuarios/login.php';

        //Si vienen parámetros, compruebo que la longitud sea de 13 caracteres que es la longitud de un token
        if(strlen($parametros[0]) === 13) {
            //Si el token es válido...
            if($this->compruebaValidezToken($parametros[0])) {
                $modeloUsuario = new usuariosModelo();
                //...recupero los datos del usuario
                $usuario = $modeloUsuario->dameUsuarioToken($parametros[0]);
                //Devuelvo lo datos del usuario a la vista
                extract($usuario);
            }
        }
        
        
        require_once $ruta_vista_login;
        require_once $ruta_vista_home;
    }
    
    /**
     * Función que comprueba la validez de un token para comprobar si un usuario tiene una sesión abierta o no
     * @param string $token
     * @return boolean True si el token es válido False si no lo es
     */
    private function compruebaValidezToken($token) {
        $modeloUsuario = new usuariosModelo();
        $validezToken = $modeloUsuario->validezToken($token);
        $time = time();
        if($time > $validezToken) {
            //Token no válido
            return false;
        } else {
            //Token válido
            return true;
        }
    }
}