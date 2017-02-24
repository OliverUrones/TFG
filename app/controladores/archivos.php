<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controladores\archivos;

use app\Api\Api;
use app\interfaz\Rest\Rest;

//use modelo archivos

/**
 * Description of archivos
 *
 * @author oliver
 */
class archivos extends Api implements Rest {

    /*POST*/
    public function alta() {
        
    }
    
    public function baja() {
        
    }
    
    public function modificar() {
        
    }    
    /*GET*/
    public function listar() {
        
    }
    public function ver($id) {
        
    }
    
    public function convertir() {
        //echo "Class archivos -- Método convertir()";
        //Incluyo las otras partes del layout
        //Tendría que incluir las categorías aquí también y en cada uno de los métodos
        $ruta_vista_login = VISTAS . 'usuarios/login.php';
        require_once $ruta_vista_login;
        
        //Recoge el tipo de petición realizada
        $this->DamePeticion();
        
        if($this->peticion === "GET")
        {
            //..muestra el forumulario de registro
            $ruta_vista = VISTAS .'archivos/convertir.php' ;
            require_once $ruta_vista;
        }
    }
}
