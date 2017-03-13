<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controladores\home;

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
    public function index() {
        //echo "Estoy en el método index() de la clase home";
        //Incluir la ruta de las categorías.php
        $ruta_vista_home = VISTAS.'home.php';
        $ruta_vista_login = VISTAS.'usuarios/login.php';

        require_once $ruta_vista_login;
        require_once $ruta_vista_home;
    }
}
