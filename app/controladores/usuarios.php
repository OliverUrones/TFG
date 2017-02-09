<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//require_once '../modelos/usuariosModelo.php';

namespace app\controladores\usuarios;

/**
 * Description of usuarios
 *
 * @author oliver
 */
class usuarios {
    
    var $nombre_usuario = 'usuario_prueba';

    public function registro() {
        //echo "Estoy en la clase usuarios en el método registro()";
        $usuariosModelo = new \app\modelos\usuariosModelo\usuariosModelo();
        $usuariosModelo->altaUsuario();
        $ruta_vista = VISTAS .'usuarios/registro.php' ;
        require_once $ruta_vista;
    }
    
    public function login() {
        echo "Estoy en la clase usuarios en el método login()";
    }
    
    public function ver($id) {
        echo "Estoy en la clase usuarios en el método ver() y el parámetro id es ".$id[0];
    }
}
