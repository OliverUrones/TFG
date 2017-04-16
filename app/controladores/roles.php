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
    
    public function modificar() {
        
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
                        $usuario = $modeloUsuario->dameUsuarioToken($parametros['token']);
                        
                        if(isset($usuario['rol_id']) && $usuario['rol_id'] === '1' && $usuario['estado'] === '1')
                        {

                            //Construyo la cadena JSON
                            $usuario = $this->construyeJSON($usuario);
                            //Devuelvo lo datos del usuario a la vista
                            //var_dump($usuario);
                            extract($usuario);
                            
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
