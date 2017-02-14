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
class usuarios extends Api\Api implements Rest {

    /**
     * Función que da de alta un usuario
     */
    public function alta() {
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
            $usuariosModelo->altaUsuario();
            
            //Enviar correo para activar cuenta
            
            //Redirección a la vista... y mensaje para comprobación de correo para la activación de la cuenta
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