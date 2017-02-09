<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\inteface\Rest;

/**
 * Interfaz que implementa los métodos de las peticiones a los recursos
 * @author oliver
 */
interface Rest {
    
    /*POST*/
    public function Alta();
    
    /*DELETE*/
    public function Baja();
    
    /*GET*/
    public function Listar();
    public function Ver();
    
    /*PUT*/
    public function Modificar();
    
}
