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
use app\modelos\usuariosModelo\usuariosModelo;

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
    
    /**
     * Función que convierte los archivos que se suben tratados con NotheSrink.
     * @param type $parametros
     */
    public function convertir($parametros=NULL) {
        //Habría que comprobar si hay usuario logueado o no!!

        //Incluyo las otras partes del layout
        //Tendría que incluir las categorías aquí también y en cada uno de los métodos
        $ruta_vista_login = VISTAS . 'usuarios/login.php';
        require_once $ruta_vista_login;
        
        //Recoge el tipo de petición realizada
        $this->DamePeticion();
        
        //Viene por GET
        if($this->peticion === "GET")
        {
            //var_dump($parametros);
            if(isset($parametros['token'])) {
                if(strlen($parametros['token']) === 14) {
                    $modeloUsuario = new usuariosModelo();
                    //Si el token es válido...
                    if($modeloUsuario->compruebaValidezToken($parametros['token'])) {
                        //...recupero los datos del usuario
                        $usuario = $modeloUsuario->dameUsuarioToken($parametros['token']);

                        //Construyo la cadena JSON
                        $usuario = $this->construyeJSON($usuario);
                        //var_dump($usuario);
                        extract($usuario);
                    }
                }
            }
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
                    $images = '';
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
                            //var_dump($origen);
                            //var_dump($destino);
                            //Construyo la cadena de parámetros con el nombre de los archivos
                            //Quedará algo como /var/www/html/app/temp/archivo1 /var/www/html/app/temp/archivo2 ...
                            $images = $destino.' '.$images;
                            //var_dump($images);
                            //echo "<br/>Se ha movido el archivo subido correctamente.";
                        } else {
                            //echo "<br/>NO se ha movido el archivo subido.";
                        }
                    }
                    //Una vez que se han procesado todos los archivos, se procedería a llamar al script noteshrink.py
                    //echo $images;
                    //var_dump($_POST);
                    //Se construye la cadena con los argumentos que se le pasarán posteriormente al script
                    //Será de la forma: /var/www/html/app/temp/archivo1 [/var/www/html/app/temp/archivo2] -b salida.png -o salida.pdf -s 20 -v 25 -n 8 -p 5 -w -S -K
                    $argumentos = $this->procesarParametros($images, $_POST);
                    //echo $argumentos.'<br/';
                    $salida = $this->ejecutarNoteshrink($argumentos);
                    if($salida !== NULL) {
                        //Se ha ejecutado el script noteshrink.py correctamente
                        //Se debería gestionar los archivos que ha generado el script
                        //Primero borraré los temporales haciendo referencia a la salida: opened ... ruta/archivo/temporal
                        //var_dump($salida);
                        $this->borrarTemporales($salida);
                        
                        
                    } else {
                        //El script noteshrink.py ha tirado algún error
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
     * Función que borrará los archivos temporales que se han subido al servidor en la carpeta temp de la aplicación
     * @param array $salida Array con las líneas de salida del script NoteShrink.py
     */
    private function borrarTemporales($salida) {
        //Los temporales se almacenan en el string que empieza por "opened"
        //echo '<br/>Hola'.strpos($salida[0], 'opened');
        foreach ($salida as $key => $value) {
            $posicion = strpos($value, 'opened ');
            if($posicion !== false)
            {
                //echo "key ".$key.' -- '.$value.'<br/>';
                $ruta = explode(' ', $value);
                unlink($ruta[1]);
            } else {
                
            }
        }
    }

        /**
     * Función que llama al script NoteShrink.py para tratar los archivos
     * @param string $argumentos Los arqumentos del script
     * @return boolean False si ha habido algún error en la ejecución.
     * @return array Array con las líneas de salida de la ejecución del script
     */
    private function ejecutarNoteshrink($argumentos) {
        if(isset($argumentos)) {
            //var_dump(exec('whoami'));
            //var_dump($argumentos);
            $comando = '2>&1 app/noteshrink/./noteshrink.py '.$argumentos;
            //var_dump($comando);
            //echo exec('pwd').'<br/>';
            //var_dump($comando);
            exec($comando, $salida, $valor_retorno);
            //var_dump($salida);
            foreach ($salida as $key => $value) {
                echo $key.' '.$value.'<br/>';
            }
        }
        if($valor_retorno === 0) {
            return $salida;
        } else {
            return null;
        }
    }

        /**
     * Función que comprueba que el tipo de archivo es PNG o JPG
     * @param array $tipos Array con los tipos de los archivos subidos "image/jpeg" o "image/png"
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
    
    /**
     * Función que devuelve una cadena con los parámetros necesarios para el funcionamiento del script noteshrink.py
     * Ejemplo: imágen1 [imágen2] -b ruta_a_carpeta_temporal/salida.png -o ruta_a_carpeta_temporal/salida.pdf ...
     * @param string $imagenes Cadena con las rutas completas a los archivos jpg/png que se van a procesar
     * @param array $params Valores recibidos desde el formulario en el array $_POST
     * @return string $cadena Devuelve la cadena de los argumentos construida
     */
    private function procesarParametros($imagenes, $params) {
        $cadena = $imagenes;
        //var_dump($params);
        
        if(is_array($params))
        {
            //Le pongo la extensión .pdf al archivo de salida que genera el algoritmo y le añado la ruta
            if(isset($params['-o']))
            {
                $params['-o'] = CARPETA_TEMPORALES.SEPARADOR.$params['-o'].'.pdf';
                //var_dump($params);
            }
            
            //Estalbezco la ruta de la carpeta temporal donde se van a guardar las imágenes .png mejoradas
            if(isset($params['-b']))
            {
                $params['-b'] = CARPETA_TEMPORALES.SEPARADOR.$params['-b'];
                //var_dump($params);
            }
            foreach ($params as $opcion => $value) {
                if($opcion === '-w' || $opcion === '-S' || $opcion === '-K')
                {
                    $cadena = $cadena.$opcion.' ';
                } else {
                    $cadena = $cadena.$opcion.' '.$value.' ';
                }
            }
            //var_dump($cadena);
            return $cadena;
        }
    }
}
