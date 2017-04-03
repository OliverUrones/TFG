<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controladores\categorias;

use app\Api\Api;
use app\interfaz\Rest\Rest;

//Uso de los modelos
use app\modelos\categoriasModelo\categoriasModelo;

/**
 * Description of categorias
 *
 * @author oliver
 */
class categorias extends Api implements Rest {
    //put your code here
    public function alta() {
        
    }

    public function baja() {
        
    }
    
    public function modificar() {
        
    }
    
    public function listar() {
        
    }

    public function listarAjax($params=NULL) {
        $categorias = new categoriasModelo();
        $categorias = $categorias->dameCategorias();
        
        $categorias = $this->construyeJSON($categorias);
        $this->tipo = "application/json";
        $this->EstablecerCabeceras();
        echo $categorias;
    }
    
    public function ver($parametros=NULL) {
        
    }
}
