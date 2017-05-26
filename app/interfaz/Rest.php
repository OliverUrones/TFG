<?php

namespace app\interfaz\Rest;

/**
 * Interfaz en la que se declaran los métodos principales de las operaciones a realizar
 * Se tendrán que definir e implementar los métodos en cada una de las clases donde se implemente la interfaz
 * 
 * @author oliver
 */
interface Rest {
    
    /**
     * Método para dar de alta un recurso
     */
    public function alta();
    
    /**
     * Método para dar de baja un recurso
     */
    public function baja();
    
    /**
     * Método para modificar un recurso
     */
    public function modificar();
    
    /**
     * Método para listar recursos
     */
    public function listar();
    
    /**
     * Método para ver un recurso
     */
    public function ver();
}
