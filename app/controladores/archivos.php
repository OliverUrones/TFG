<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controladores\archivos;

use app\Api\Api;
use app\interfaz\Rest\Rest;

//use modelo archivos

/**
 * Description of archivos
 *
 * @author oliver
 */
class archivos extends Api implements Rest {

    /*POST*/
    public function alta() {
        
    }
    
    public function baja() {
        
    }
    
    public function modificar() {
        
    }    
    /*GET*/
    public function listar() {
        
    }
    public function ver($id) {
        
    }
    
    public function convertir() {
        //echo "Class archivos -- Método convertir()";
        //Incluyo las otras partes del layout
        //Tendría que incluir las categorías aquí también y en cada uno de los métodos
        $ruta_vista_login = VISTAS . 'usuarios/login.php';
        require_once $ruta_vista_login;
        
        //Recoge el tipo de petición realizada
        $this->DamePeticion();
        
        //Viene por GET
        if($this->peticion === "GET")
        {
            //..muestra el forumulario de registro
            $ruta_vista = VISTAS .'archivos/convertir.php' ;
            require_once $ruta_vista;
        }
        
        //Viene por POST
        if($this->peticion === "POST")
        {
            //var_dump($_POST);
            //var_dump($_FILES);
//            echo "<br/>Nombre: ".print_r($_FILES['archivos']['name']);
//            echo "<br/>Tipo: ".print_r($_FILES['archivos']['type']);
//            echo "<br/>tmp_name: ".print_r($_FILES['archivos']['tmp_name']);
//            echo "<br/>error: ".print_r($_FILES['archivos']['error']);
//            echo "<br/>size: ".print_r($_FILES['archivos']['size']);
//            echo "<br/>Total: ".count($_FILES['archivos']['tmp_name']);
//            echo CARPETA_TEMPORALES;
            //Si existe la clave type del array de ficheros subidos...
            if(isset($_FILES['archivos']['type']))
            {
                //..Se recoge los tipos de los ficheros subidos
                $tipo_archivo = $_FILES['archivos']['type'];
                //print_r($tipo_archivo);
                //Se comprueba los tipos recogidos con el formato requerido
                if($this->comprobarTiposArchivos($tipo_archivo))
                {
                    //Para cada nombre temporal del archivo subido..
                    foreach ($_FILES['archivos']['tmp_name'] as $key => $value) {
                        //Se recoge la ruta de origen
                        $origen = $_FILES['archivos']['tmp_name'][$key];
                        //Se extrae el nombre temporal que se le asigna
                        $nombre_temp = explode("/", $value);
                        $nombre_temp = $nombre_temp[2];
                        //echo $nombre_temp;
                        //El destino será en la carpeta temp/$nombre_temp extraído
                        $destino = CARPETA_TEMPORALES . SEPARADOR . $nombre_temp;
                        //echo "<p>".$destino."</p>";
                        //Si se ha movido con éxtio...
                        if(move_uploaded_file($origen, $destino))
                        {
                            //...Se procedería a llamar al script noteshrink.py
                            echo "<br/>Se ha movido el archivo subido correctamente.";
                        } else {
                            echo "<br/>NO se ha movido el archivo subido.";
                        }
                    }
                } else 
                {
                    echo "El formato requerido no coincide.";
                }
            } else {
                //Mensaje de error no se han subido los ficheros correctamente
                echo 'Error al subir los ficheros';
            }
        }
    }
    
    /**
     * Función que comprueba que el tipo de archivo es PNG o JPG
     * @param array $tipos Array con los tipos de los archivos subidos "image/jpeg" o image/png
     * @return boolean True | False Devuelve falso si se ha subido un archivo que no es jpeg o png y true en caso contrario
     */
    private function comprobarTiposArchivos($tipos) {
        if(is_array($tipos)) {
            foreach ($tipos as $key => $value) {
                if($value === 'image/jpeg' || $value === 'image/png')
                {
                } else
                {
                    //echo "La imagen NO es jpeg o png<br/>";
                    return false;
                }
            }
        } else {
            return false;
        }
        return true;
    }
}
