<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modelos\usuariosModelo;

/**
 * Description of usuariosModelo
 *
 * @author oliver
 */
class usuariosModelo {
    
    var $usuario_id = NULL;
    var $rol_id = NULL;
    var $email = NULL;
    var $password = NULL;
    var $nombre = NULL;
    var $apellidos = NULL;
    var $token = NULL;
    var $fecha_creacion = NULL;
    var $estado = NULL;


    public function altaUsuario($post = array()) {
        echo "Estoy en la clase usuariosModelo y se ejecuta el método altaUsuario()";
        
    }
}
