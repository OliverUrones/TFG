<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modelos\busquedaModelo;
require_once dirname(__DIR__).DIRECTORY_SEPARATOR.'adodb5/adodb.inc.php';

use app\modelos\categoriasModelo\categoriasModelo;

/**
 * Description of busquedaModelo
 *
 * @author oliver
 */
class busquedaModelo {
    private $tabla = 'archivos';
    private $conexion = NULL;
    public $archivo_id = NULL;
    public $nombre_archivo = NULL;
    public $enlace_descarga = NULL;
    public $ambito = NULL;
    public $etiquetas = NULL;
    public $nombre_categoria = NULL;
    
    public function busca($cadena) {
        //var_dump($cadena);
        $this->__hayCategorias($cadena);
    }
    
    private function __hayCategorias($cadena) {
        //Genero un array con la cadena de búsqueda que le paso como parámetro
        $array_cadena = explode(" ", $cadena);
        var_dump($array_cadena);
        //Hay que comprobar si en el array generado hay alguna categoría para ello primer
        //tengo que recuperar las categorías almacenadas en la base de datos.
        $modeloCategorias = new categoriasModelo();
        $categorias = $modeloCategorias->dameCategorias();
        //var_dump($categorias);
        foreach ($array_cadena as $key => $value) {
                echo '<br/>'.$value;
            foreach ($categorias as $clave_categoria => $categoria) {
                echo '<br/>'.$categoria['nombre'];
                if(strtolower($value) == strtolower($categoria['nombre'])) {
                    echo '<br/>'.$value.' = '.$categoria['nombre'];
                }
            }
        }
    }
}
