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
        //Incluyo las otras partes del layout
        //Tendría que incluir las categorías aquí también y en cada uno de los métodos
        $ruta_vista_login = VISTAS . 'usuarios/login.php';
        require_once $ruta_vista_login;
        
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
            $registro = $usuariosModelo->altaUsuario();
            
            //Paso los datos a la vista
            extract($registro);
            
            //Redirección a la vista... y mensaje para comprobación de correo para la activación de la cuenta
            $ruta_vista_alta = VISTAS .'usuarios/alta.php' ;
            require_once $ruta_vista_alta;
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
        //echo "Estoy en la clase usuarios en el método login()";
        //Incluyo las otras partes del layout
        //Tendría que incluir las categorías aquí también y en cada uno de los métodos
        $ruta_vista_login = VISTAS . 'usuarios/login.php';
        require_once $ruta_vista_login;
        
        //Recoge el tipo de petición realizada
        $this->DamePeticion();
        
        //Si viene por POST
        if($this->peticion === "POST")
        {
            //Se crea un objeto del modelo usuarios
            $usuariosModelo = new usuariosModelo();
            
            //Se llama al método del modelo usuarios que añade un usuario a la base de datos
            $usuario = $usuariosModelo->dameUsuario();
            //var_dump($usuario);
            
            //Función extract() para pasar los datos a la vista
            extract($usuario);
            
            //Redirección a la vista... y mensaje del estado del login
            //$ruta_vista_alta = VISTAS .'usuarios/alta.php' ;
            //require_once $ruta_vista_alta;
        }
    }
    
    public function activar($id) {
        //echo "Se va a activar la cuenta con id = ".$id[0];
        //Recoge el tipo de petición realizada
        $this->DamePeticion();
        
        //Si viene por GET...
        if($this->peticion === "GET") {
            //Compruebo que sólo viene un parámetro por la url
            if(count($id) == 1){
                //Se crea un objeto del modelo usuarios
                $usuariosModelo = new usuariosModelo();

                //Se llama al método del modelo usuarios que activa una cuenta que devuele el JSON con el mensaje y el estado de la petición
                $estado_activacion = $usuariosModelo->activarCuenta($id);
                
                //Paso el JSON a la vista
                extract($estado_activacion);
                
                //Cargo la vista de la activación de la cuenta para mostrar el mensaje
                $ruta_vista_estado_activacion = VISTAS . 'usuarios/estado_activacion.php';
                require_once $ruta_vista_estado_activacion;
            }
        }
    }
}