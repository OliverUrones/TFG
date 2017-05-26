<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controladores\busqueda;

use app\Api;
use app\modelos\usuariosModelo\usuariosModelo;
use app\modelos\busquedaModelo\busquedaModelo;

/**
 * Clase controlador para la gestión de las acciones relacionadas con las búsquedas de archivos
 * Esta clase usa los modelos de usuarios y búsqueda
 *
 * @author oliver
 */
class busqueda extends Api\Api {

    /**
     * Método que ejecuta una búsqueda de archivos a través de una cadena de texto recibida.
     * 
     * Este método se ejecuta exclusivamente por POST
     * @param array $parametros Array asociativo con el token de usuario registrado en caso de haberlo
     */
    public function archivos($parametros=NULL) {
        //echo "Estoy en el método archivos() de la clase buscar";
        //Puede venir el token del usuario
        //var_dump($parametros);
        $this->DamePeticion();
        if($this->peticion === "POST") {
            if(isset($parametros['token'])) {
                if(strlen($parametros['token']) === 14) {
                    $modeloUsuario = new usuariosModelo();
                    //Si el token es válido...
                    if($modeloUsuario->compruebaValidezToken($parametros['token'])) {
                        //...recupero los datos del usuario
                        $usuario = $modeloUsuario->dameUsuarioToken($parametros['token']);

                        //Construyo la cadena JSON
                        $usuario = $this->construyeJSON($usuario);
                        //var_dump($usuario);
                        extract($usuario);
                        
                    }
                }
            }
            //var_dump($_POST);
            if(isset($_POST['busqueda']) && !empty($_POST['busqueda'])) {
                $modeloBusqueda = new busquedaModelo();
                $resultado = $modeloBusqueda->busca($_POST['busqueda']);
                //var_dump($resultado);
                $resultado = $this->construyeJSON($resultado);

                //var_dump($resultado);

                extract($resultado);
            }

            //Redirección a la vista... y mensaje para comprobación de correo para la activación de la cuenta
            $ruta_vista_resultado = VISTAS .'busquedas/resultado.php' ;
            require_once $ruta_vista_resultado;
        }
    }
}
