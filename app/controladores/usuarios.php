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
/**
 * Description of usuarios
 *
 * @author oliver
 */
class usuarios extends Api\Api implements Rest /*Esto no funciona*/ {

    var $nombre_usuario = 'usuario_prueba';

    public function alta() {
        //echo "Estoy en la clase usuarios en el método alta()";
        $this->DamePeticion();
        if($this->peticion === "GET")
        {
            $ruta_vista = VISTAS .'usuarios/alta.php' ;
            require_once $ruta_vista;
//        $usuariosModelo = new usuariosModelo();
//        $usuariosModelo->altaUsuario();
        }
        if($this->peticion === "POST")
        {
            //echo "Viene por POST";
            //var_dump($_POST);            
            $ruta_vista = VISTAS .'usuarios/alta.php' ;
            require_once $ruta_vista;
        }
    }
    
    public function baja() {
        echo "Estoy en la clase usuarios en el métod baja()";
    }
    
    public function listar() {
        echo "Estoy en la clase usuarios en el método listar";
    }

    public function ver($id) {
        echo "Estoy en la clase usuarios en el método ver() y el parámetro id es ".$id[0];
    }
    
    public function modificar() {
        echo "Estoy en la clase usuarios en el método modificar()";
    }
    
    public function login() {
        echo "Estoy en la clase usuarios en el método login()";
    }
    
}