<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controladores\busqueda;

use app\Api;
use app\modelos\busquedaModelo\busquedaModelo;

/**
 * Description of buscar
 *
 * @author oliver
 */
class busqueda extends Api\Api {
    //put your code here
    
    public function archivos($parametros=NULL) {
        //echo "Estoy en el método archivos() de la clase buscar";
        //Puede venir el token del usuario
        //var_dump($parametros);
        var_dump($_POST);
        
        $modeloBusqueda = new busquedaModelo();
        $resultado = $modeloBusqueda->busca($_POST['busqueda']);
        var_dump($resultado);
        $resultado = $this->construyeJSON($resultado);

        //var_dump($resultado);
        
        extract($resultado);
        
        //Redirección a la vista... y mensaje para comprobación de correo para la activación de la cuenta
        $ruta_vista_resultado = VISTAS .'busquedas/resultado.php' ;
        require_once $ruta_vista_resultado;
    }
}
