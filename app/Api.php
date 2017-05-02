<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Api;

/**
 * Clase para instanciar una petición al servidor.
 * Se recogerá el tipo de petición para acceder al servicio.
 * Se tratará la url para recoger el controlador, el método y los parámetros de la petición.
 * Se establecerán unas cabeceras iniciales pudiendo cambiar durante la ejecución de la petición.
 * Se ejecutará la petición al servicio con los parámetros recogidos.
 *
 * @author Oliver Urones García
 * @copyleft (cc) 2017, Oliver Urones
 * @license https://creativecommons.org/licenses/by-nc-sa/4.0/ Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0)
 * @version alfa
 * 
 */
class Api {
    
    /**
     * @var string $controlador Controlador a ejecutar. Por defecto es 'home'
     */
    private $controlador = 'home';      /*controlador por defecto*/

    /**
     * @var string $metodo Método a ejecutar. Por defecto es 'index'
     */
    private $metodo = 'index';     /*método por defecto*/
    
    /**
     * @var array $parametros Array asociativo con los parámetros adicionales procedentes de la url. Puede ser un id y/o un token
     */
    private $parametros = NULL; /*Parámetros provenientes de los formularios*/
    
    /**
     * @var string $peticion Método de petición para acceder al servicio (GET o POST)
     */
    protected $peticion = NULL;
    
    /**
     * @var string $tipo Content-Type de la cabecera
     */
    protected $tipo = "text/html";
    //private $tipo = "application/javascript";
    //private $tipo = "application/json";

    /**
     * @var int $codEstado Código de estado de la petición. (Lo mismo no hace falta)
     */
    protected $codEstado = 200;

    /**
     * @var string $ruta_controlador Cadena con la ruta relativa a la carpeta de controladores.
     */
    private $ruta_controlador = '/controladores/';
    
    /**
     * @var string $espacio_nombres Cadena con el espacio de nombres (namespace) de los controladores dentro de la aplicación
     */
    private $espacio_nombres = '\\app\\controladores\\';

    
    /**
     * Constructor de la clase Api.
     * Realiza la llamada para establecer el tipo de petición (GET o POST).
     * Tratar la url que le viene.
     * Establece una cabeceras iniciales de Content-Type como text/html
     * Y por último, ejecuta la petición.
     */
    public function Api() {
        $this->DamePeticion();
        //var_dump($_SERVER['REQUEST_URI']);
        //echo $this->peticion;
        $this->TratarURL();
        $this->EstablecerCabeceras(NULL);
        //var_dump($_POST);
        //var_dump(headers_list());
        //echo 'Petición: '.$this->peticion;
        //echo '<br/>Clase: '.$this->clase;
        //echo '<br/>Método: '.$this->metodo;
        $this->EjecutarPeticion();
    }
    
    /**
     * Método que trata la url del tipo "clase/método/argumentos" para obtener
     * los parámetros para realizar la llamada al servicio
     */
    private function TratarURL() {
        //Recogo la URI de la petición y la trato, de forma que queda un array con las claves "path" y "query"
        $url = parse_url(urldecode($_SERVER['REQUEST_URI']));
        //Primero se comprueba el path para ver si se está accediendo a la parte pública o a la parte privada
        if(!strpos($url['path'], 'admin'))
        {
            /**
             * Parte pública
             */
            
            /*Si viene la clave query..*/
            if(isset($url['query']))
            {
                /**
                 * Elimino la '/' de las posiciones primera y última de la query para que no haya problemas
                 * En caso de que se haga una petición a una url del tipo localhost/?$clase/$metodo/ sin que
                 * venga nada detrás de la última '/'
                 */
                $url['query'] = trim($url['query'], "/");
                /**
                 * ..quiere decir que vienen los parámetros de la llamada.
                 * Divido la cadena por / y los devuelvo
                 */
                //var_dump($url);
                $parametros = explode("/", $url['query']);
                /*Extraigo la clase del array de parámetros*/
                $this->controlador = array_shift($parametros);
                /*Extraigo el método del array de parámetros*/
                $this->metodo = array_shift($parametros);

    //            echo '<br/>'.$this->clase;
    //            echo '<br/>'.$this->metodo;

                //var_dump($parametros);
                /*Si todavía quedan elementos en el array., en concreto 2 o 3.*/
                if(count($parametros) > 0 && count($parametros) < 3) {
                    /*..vienen más parámetros a parte de la clase y el método. Los argumentos del método a invocar id y token*/
                    for ($i = 0; $i < count($parametros); $i++) {
                        //Compruebo si el primer caracter de la dentro del array de parámetros es t...
                        if(substr($parametros[$i], 0, 1) === 't') {
                            //...Si es 't' quiere decir que ese parámetro es el token
                            //echo substr($parametros[$i], 0, 1);
                            $this->parametros['token'] = $parametros[$i];
                        //Si el primer caracter no es "t" compruebo si es "d" del directorio temporal para la conversión
                        } elseif(substr($parametros[$i], 0, 1) === 'd') {
                            $this->parametros['directorio'] = $parametros[$i];
                        //Si el primer caracter no es "t" compruebo si es la extensión .pdf del archivo que se puede descargar
                        } elseif(substr($parametros[$i],-4) === '.pdf') {
                            //Esto es para cuando se realiza la descarga del archivo generado en convertir
                            //var_dump(substr($parametros[$i],-4));
                            $this->parametros['archivo'] = $parametros[$i];
                        } else {
                            //..sino será el id
                            $this->parametros['id'] = $parametros[$i];
                        }
                    }
                    //var_dump($this->parametros);
                }
            } else
            {
                /**
                 * Si no viene la clave query la petición se realizará a
                 * la clase home y al método index()
                 */
                $this->controlador = 'home';
                $this->metodo = 'index';

    //            echo '<br/>'.$this->clase;
    //            echo '<br/>'.$this->metodo;
            }
        } else {
            /**
             * Parte privada
             */
            
            /*Si viene la clave query..*/
            if(isset($url['query']))
            {
                /**
                 * Elimino la '/' de las posiciones primera y última de la query para que no haya problemas
                 * En caso de que se haga una petición a una url del tipo localhost/admin/?$clase/$metodo/ sin que
                 * venga nada detrás de la última '/'
                 */
                $url['query'] = trim($url['query'], "/");
                /**
                 * ..quiere decir que vienen los parámetros de la llamada.
                 * Divido la cadena por / y los devuelvo
                 */
                //var_dump($url);
                $parametros = explode("/", $url['query']);
                /*Extraigo la clase del array de parámetros*/
                $this->controlador = array_shift($parametros);
                /*Extraigo el método del array de parámetros*/
                $this->metodo = array_shift($parametros);

    //            echo '<br/>'.$this->clase;
    //            echo '<br/>'.$this->metodo;

                //var_dump($parametros);
                /*Si todavía quedan elementos en el array., en concreto 2 o 3.*/
                if(count($parametros) > 0 && count($parametros) < 3) {
                    /*..vienen más parámetros a parte de la clase y el método. Los argumentos del método a invocar id y token*/
                    for ($i = 0; $i < count($parametros); $i++) {
                        //Compruebo si el primer caracter de la dentro del array de parámetros es t...
                        if(substr($parametros[$i], 0, 1) === 't') {
                            //...Si es 't' quiere decir que ese parámetro es el token
                            //echo substr($parametros[$i], 0, 1);
                            $this->parametros['token'] = $parametros[$i];
                        //Si el primer caracter no es "t" compruebo si es la extensión .pdf del archivo que se puede descargar
                        } elseif(substr($parametros[$i],-4) === '.pdf') {
                            //Esto es para cuando se realiza la descarga del archivo generado en convertir
                            //var_dump(substr($parametros[$i],-4));
                            $this->parametros['archivo'] = $parametros[$i];
                        } else {
                            //..sino será el id
                            $this->parametros['id'] = $parametros[$i];
                        }
                    }
                    //var_dump($this->parametros);
                }
            } else
            {
                /**
                 * Si no viene la clave query la petición se realizará a
                 * la clase home y al método admin()
                 */
    
                $this->controlador = 'home';
                $this->metodo = 'admin';
//                echo '<br/>Controlador: '.$this->controlador;
//                echo '<br/>Método: '.$this->metodo;
            }
            
        }
    }
    
    /**
     * Método que establece el método de petición de acceso al servicio
     */
    protected function DamePeticion() {
        
        if(isset($_SERVER['REQUEST_METHOD'])) {
            $this->peticion = $_SERVER['REQUEST_METHOD'];
        }
    }
    
    /**
     * Método que establece las cabeceras del servicio
     * @param string|NULL $ruta Ruta del fichero para descargar.
     * @param string|NULL $nombre Nombre del fichero para descargar.
     */
    protected function EstablecerCabeceras($ruta=NULL, $nombre=NULL) {
        header("HTTP/1.1 " . $this->codEstado . " " . $this->GetCodEstado());  
        header("Content-Type:" . $this->tipo . ';charset=utf-8');
        //Si se le pasas como argumento un archivo...
        if(isset($ruta) && $ruta !== NULL) {
            //...Se establece Content-Disposition: attachment; filename=$filename para descargar el archivo
            header("Content-Disposition: attachment; filename=$nombre");
            readfile($ruta);
        }
     }
     
     /**
      * Método que devuelve el código del estado de la petición
      * @return string Mensaje correspondiente al código del estado de la petición
      */
    public function GetCodEstado() {  
        $estado = array(
            200 => 'OK',  
            201 => 'Created',  
            202 => 'Accepted',  
            204 => 'No Content',  
            301 => 'Moved Permanently',  
            302 => 'Found',  
            303 => 'See Other',  
            304 => 'Not Modified',  
            400 => 'Bad Request',  
            401 => 'Unauthorized',  
            403 => 'Forbidden',  
            404 => 'Not Found',  
            405 => 'Method Not Allowed',  
            500 => 'Internal Server Error');  
        
        $respuesta = ($estado[$this->codEstado]) ? $estado[$this->codEstado] : $estado[500];  
        
        return $respuesta;  
   }
   
   /**
    * Método que va a dirigir la petición a un método de una clase con unos argumentos, si los hubiera,
    * en función del método de la petición realizada (POST, GET)
    */
   private function EjecutarPeticion() {
       /*Construyo la ruta donde se encuentra el archivo de la clase a la que se va a llamar
        * añadiéndole la extensión .php
        */
       $ruta_controlador = __DIR__.$this->ruta_controlador.$this->controlador.'.php';
       /*Compruebo si el archivo existe*/
       if(file_exists($ruta_controlador)){
           /*Compruebo si el archivo se puede leer*/
           if(is_readable($ruta_controlador)) {
               /*Requiero el archivo de la clase*/
               require_once $ruta_controlador;
               /**
                * Construyo la cadena para el controlador. Se incluye el espacio de nombres 'namespace'
                * La cadena queda de la siguiente forma: \app\controladores\<<clase>>\<<clase>>
                */
               $controlador = $this->espacio_nombres.$this->controlador.'\\'.$this->controlador;
               /*Si existe la clase del controlador...*/
               if(class_exists($controlador, false)) {
                   /*...y si existe el método de ese controlador*/
                   if(method_exists($controlador, $this->metodo)) {
                        //echo "Existe el método ".$this->metodo."() de la clase ".$this->clase;
                        /*Instancio un objeto de la clase que contiene la variable $controlador*/
                        $objeto = new $controlador();
                        /*Si vienen más parámetros por la url...*/
                        if(isset($this->parametros))
                        {
                            /*...llamo al método del objeto instanciado y le paso los parámetros que vienen*/
                            call_user_func(array($objeto, $this->metodo), $this->parametros);
                        } else
                        {
                            /*...llamo al método del objeto instanciado sin parámetros*/
                            call_user_func(array($objeto, $this->metodo));
                        }
                   } else
                   {
                       echo "No existe el método ".$this->metodo." de la clase ".$this->controlador;
                   }
               } else
               {
                   echo "La clase ".$controlador." NO existe.";
               }
               
           }else
           {
               echo "El archivo del controlador no se puede leer";
           }
           
       }else
       {
           echo "El archivo del controlador ". $this->ruta_controlador." no existe";
       }
   }
   
   /**
     * Función que codifica en JSON los datos recibidos como parámetros
     * @param array $respuesta Estado de la petición y/o datos
     * @return string Cadena de respuesta en JSON
     */
   protected function construyeJSON($respuesta) {
        return json_encode($respuesta);
        //var_dump($JSON);
    }
}
