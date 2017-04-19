<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controladores\roles;

use app\Api\Api;
use app\interfaz\Rest\Rest;

use app\modelos\usuariosModelo\usuariosModelo;
use app\modelos\rolesModelo\rolesModelo;

/**
 * Description of roles
 *
 * @author oliver
 */
class roles extends Api implements Rest {
    
    public function alta() {
        
    }
    
    public function baja() {
        
    }
    
    public function modificar($parametros=NULL) {
        var_dump($parametros);
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
                            $modeloRoles = new rolesModelo();
                            $rol = $modeloRoles->dameRolId($parametros['id']);
                            $rol = $this->construyeJSON($rol);
                            $admin = $modeloUsuario->dameUsuarioToken($parametros['token']);

                            //Construyo la cadena JSON
                            $admin = $this->construyeJSON($admin);
                            extract($rol);
                            //Devuelvo lo datos del usuario a la vista
                            extract($admin);

                            $ruta_vista_admin_modificar = VISTAS .'roles/admin_modificar.php';
                            require_once $ruta_vista_admin_modificar;
                        }
                    }

                }
            }
        }
    }
    
    public function listar($parametros=NULL) {
        //echo "Voy a listar los roles";
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
                            
                            $rolesModelo = new rolesModelo();
                            $roles = $rolesModelo->listadoRoles();
                            
                            $roles = $this->construyeJSON($roles);
                            
                            extract($roles);

                            //var_dump($usuarios);

                            $ruta_vista_admin_listado = VISTAS .'roles/admin_listado.php';
                            require_once $ruta_vista_admin_listado;
                        } else {
                            //No tiene permiso
                        }
                    }
                }
            }
        }
    }
    
    public function ver($id) {
        
    }
}
