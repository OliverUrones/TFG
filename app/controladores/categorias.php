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
    
    public function modificar($parametros=NULL) {
        $this->DamePeticion();
        if($this->peticion === "GET") {
            if(is_array($parametros) && count($parametros) === 2){
                if(isset($parametros['id']) && isset($parametros['token']))
                {

                    if(strlen($parametros['token']) === 14) {
                        //Creo un objeto usuario
                        //var_dump($parametros);
                        $modeloUsuario = new usuariosModelo();
                        //Si el token es válido...
                        if($modeloUsuario->compruebaValidezToken($parametros['token'])) {
                            //...recupero los datos del usuario
                            $modeloCategoria = new categoriasModelo();
                            $categoria = $modeloCategoria->dameCategoriaId($parametros['id']);
                            $categoria['categorias'] = $modeloCategoria->dameCategorias();
                            $categoria = $this->construyeJSON($categoria);
                            $admin = $modeloUsuario->dameUsuarioToken($parametros['token']);

                            //Construyo la cadena JSON
                            $admin = $this->construyeJSON($admin);
                            extract($categoria);
                            //Devuelvo lo datos del usuario a la vista
                            extract($admin);

                            $ruta_vista_admin_modificar = VISTAS .'categorias/admin_modificar.php';
                            require_once $ruta_vista_admin_modificar;
                        }
                    }

                }
            }
        }
        
        if($this->peticion === "POST") {
            //Si viene la modificación por formulario
            echo "La petición de modificar viene por POST";
            var_dump($_POST);
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
                                
                                $modeloCategoria = new categoriasModelo();
                                $categoria = $modeloCategoria->modificarCategoriaId();
                                
                                $categorias = $modeloCategoria->dameCategorias();
                                $categoria['categorias'] = $categorias;
                                $categoria = $this->construyeJSON($categoria);
                                
                                extract($categoria);
                                var_dump($categoria);
                                
                                $ruta_vista_admin_modificar = VISTAS .'categorias/admin_modificar.php';
                                require_once $ruta_vista_admin_modificar;
                            }
                        }
                    }
                }
            }
        }
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
