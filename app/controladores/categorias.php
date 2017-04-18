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
use app\modelos\usuariosModelo\usuariosModelo;
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
    
    public function listar($parametros=NULL) {
        if(is_array($parametros)){
            if(isset($parametros['token']))
            {
                if(strlen($parametros['token']) === 14) {
                    //Creo un objeto usuario
                    $modeloUsuario = new usuariosModelo();
                    //Si el token es válido...
                    if($modeloUsuario->compruebaValidezToken($parametros['token'])) {
                        //...recupero los datos del usuario
                        $admin = $modeloUsuario->dameUsuarioToken($parametros['token']);
                        
                        if(isset($admin['rol_id']) && $admin['rol_id'] === '1' && $admin['estado'] === '1')
                        {

                            //Construyo la cadena JSON
                            $admin = $this->construyeJSON($admin);
                            //Devuelvo lo datos del usuario a la vista
                            //var_dump($usuario);
                            extract($admin);
                            
                            $modeloCategorias = new categoriasModelo();
                            $categorias = $modeloCategorias->dameCategorias();
                            $categorias = $this->construyeJSON($categorias);
                            
                            extract($categorias);
                            
                            //var_dump($usuarios);

                            $ruta_vista_admin_listado = VISTAS .'categorias/admin_listado.php';
                            require_once $ruta_vista_admin_listado;
                        } else {
                            //No tiene permiso
                        }
                    }
                }
            }
        }
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
