<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controladores\usuarios;

use app\Api;
use app\interfaz\Rest\Rest;

use app\modelos\usuariosModelo\usuariosModelo;
/**
 * Description of usuarios
 *
 * @author oliver
 */
class usuarios extends Api\Api implements Rest {

    /**
     * Función que da de alta un usuario
     */
    public function alta() {
        //Incluyo las otras partes del layout
        //Tendría que incluir las categorías aquí también y en cada uno de los métodos
//        $ruta_vista_login = VISTAS . 'usuarios/login.php';
//        require_once $ruta_vista_login;
        
        //Recoge el tipo de petición realizada
        $this->DamePeticion();
        
        //Si viene por GET...
        if($this->peticion === "GET")
        {
            //..muestra el forumulario de registro
            $ruta_vista = VISTAS .'usuarios/alta.php' ;
            require_once $ruta_vista;
        }
        
        //Si viene por POST
        if($this->peticion === "POST")
        {
            //Se crea un objeto del modelo usuarios
            $usuariosModelo = new usuariosModelo();
            
            //Se llama al método del modelo usuarios que añade un usuario a la base de datos
            $registro = $usuariosModelo->altaUsuario();
            
            $registro = $this->construyeJSON($registro);
            
            //Paso los datos a la vista
            extract($registro);
            
            //Redirección a la vista... y mensaje para comprobación de correo para la activación de la cuenta
            $ruta_vista_alta = VISTAS .'usuarios/alta.php' ;
            require_once $ruta_vista_alta;
        }
    }
    
    public function baja() {
        echo "Estoy en la clase usuarios en el métod baja()";
    }
    
    public function listar($parametros=NULL) {
        echo "Estoy en la clase usuarios en el método listar";
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
                            
                            $usuarios = $modeloUsuario->listadoUsuarios();
                            $usuarios = $this->construyeJSON($usuarios);
                            
                            extract($usuarios);
                            
                            //var_dump($usuarios);

                            $ruta_vista_admin_listado = VISTAS .'usuarios/admin_listado.php';
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
        echo "Estoy en la clase usuarios en el método ver() y el parámetro id es ".$id[0];
    }
    
    public function modificar() {
        echo "Estoy en la clase usuarios en el método modificar()";
    }
    
    /**
     * Función que devuelve los datos del perfil de un usuario
     * @param type $id
     */
    public function perfil($parametros=NULL) {
        if(is_array($parametros) && count($parametros) === 2){
            if(isset($parametros['id']) && isset($parametros['token']))
            {
                
                if(strlen($parametros['token']) === 14) {
                    //Creo un objeto usuario
                    $modeloUsuario = new usuariosModelo();
                    //Si el token es válido...
                    if($modeloUsuario->compruebaValidezToken($parametros['token'])) {
                        //...recupero los datos del usuario
                        $usuario = $modeloUsuario->dameUsuarioToken($parametros['token']);

                        //Construyo la cadena JSON
                        $usuario = $this->construyeJSON($usuario);
                        //Devuelvo lo datos del usuario a la vista
                        //var_dump($usuario);
                        extract($usuario);
                    }
                }
                
                $ruta_vista_perfil = VISTAS .'usuarios/perfil.php';
                require_once $ruta_vista_perfil;
            }
        }
        //Compruebo la validez del token del usuario con usuario_id = $id
    }
    
    public function admin() {
        //echo "Estoy en el método admin() de la clase usuarios";
        
        //Recojo el tipo de petición
        $this->DamePeticion();
        
        //Si viene por post...
        if($this->peticion === "POST")
        {
            //Creo un modelo usuarios;
            $usuarioModelo = new usuariosModelo();
            
            //Recupero los datos del usuario logueado
            $usuario = $usuarioModelo->dameUsuarioLogueado();
            //var_dump($usuario);
            
            //Si el usuaario logueado es de tipo administrador (rol_id = 1) ...
            if(isset($usuario['rol_id']) && $usuario['rol_id'] === '1' && $usuario['estado'] === '1')
            {
                //echo "Soy administrador";
                //Cargo la página inicial del back end
                $usuario = $this->construyeJSON($usuario);
                extract($usuario);
                $ruta_vista_admin_home = VISTAS.'admin_home.php';

                require_once $ruta_vista_admin_home;
            } else {
                //echo "NO soy administrador";
                //Recargo la página de index del directorio admin
                $usuario = $this->construyeJSON(array('estado' => '400 KO', 'Mensaje' => 'No está permitido el acceso a los usuarios que no son administradores.'));
                extract($usuario);
                
                $ruta_vista_login = VISTAS.'usuarios/admin_login.php';

                require_once $ruta_vista_login;
            }
        }
    }

    /**
     * Función para loguearse en la parte pública
     */
    public function login() {
        //echo "Estoy en la clase usuarios en el método login()";
        //Incluyo las otras partes del layout
        //Tendría que incluir las categorías aquí también y en cada uno de los métodos

        //Recoge el tipo de petición realizada
        $this->DamePeticion();
        
        //Viene por GET
        if($this->peticion === "GET")
        {
            //..muestra el forumulario de login
            $ruta_vista_login = VISTAS . 'usuarios/login.php';
            require_once $ruta_vista_login;
        }

        //Si viene por POST
        if($this->peticion === "POST")
        {
            //Se crea un objeto del modelo usuarios
            $usuariosModelo = new usuariosModelo();

            //Se llama al método del modelo usuarios recupera los datos del usuario a loguearse
            $usuario = $usuariosModelo->dameUsuarioLogueado();

            //var_dump($usuario);

            //Se convierte los datos a JSON
            $usuario = $this->construyeJSON($usuario);

            //Función extract() para pasar los datos a la vista
            extract($usuario);
            
            //Redirección a la vista... y mensaje del estado del login ************ OJO
            $ruta_vista_perfil = VISTAS .'usuarios/perfil.php';
            require_once $ruta_vista_perfil;
        }
    }
    
    /**
     * Función para cerrar sesión
     */
    public function logout($parametros = NULL) {
        
        //Recogo el tipo de petición realizada
        $this->DamePeticion();
        //si viene por GET...
        if($this->peticion === "GET") {
            //Compruebo si viene el id
            if(isset($parametros['id']))
            {
                var_dump($parametros);
                //Se crea un objeto del modelo usuarios
                $usuariosModelo = new usuariosModelo();
                $estado_peticion = $usuariosModelo->borraDatosSesion($parametros['id']);
                echo $estado_peticion['Mensaje'];
                
                //Requerir la vista correspondiente
            }
        }   
    }

    public function activar($parametros = NULL) {
        //echo "Se va a activar la cuenta con id = ".$id[0];
        //Incluyo las otras partes del layout
        //Tendría que incluir las categorías aquí también y en cada uno de los métodos
//        $ruta_vista_login = VISTAS . 'usuarios/login.php';
//        require_once $ruta_vista_login;
        
        //Recoge el tipo de petición realizada
        $this->DamePeticion();
        
        //Si viene por GET...
        if($this->peticion === "GET") {
            //Compruebo que sólo viene un parámetro por la url
            if(isset($parametros['id'])){
                //Se crea un objeto del modelo usuarios
                $usuariosModelo = new usuariosModelo();

                //Se llama al método del modelo usuarios que activa una cuenta que devuele el JSON con el mensaje y el estado de la petición
                $estado_activacion = $usuariosModelo->activarCuenta($parametros['id']);
                $estado_activacion = $this->construyeJSON($estado_activacion);
                //var_dump($estado_activacion);
                
                //Paso el JSON a la vista
                extract($estado_activacion);
                
                //Cargo la vista de la activación de la cuenta para mostrar el mensaje
                $ruta_vista_estado_activacion = VISTAS . 'usuarios/estado_activacion.php';
                require_once $ruta_vista_estado_activacion;
            }
        }
    }
}