<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\interfaz\Rest;

/**
 *
 * @author oliver
 */
interface Rest {
    
    /*POST*/
    public function alta();
    
    public function baja();
    
    public function modificar();
    
    /*GET*/
    public function listar();
    public function ver($id);
}
