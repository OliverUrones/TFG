<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Api;

/**
 * Description of Api
 *
 * @author oliver
 */
class Api {
    public $peticion = NULL;
    private $clase = NULL;      /*Elegir clase por defecto*/
    private $metodo = NULL;     /*Elegir método por defecto*/
    private $parametros = NULL; /*Parámetros provenientes de los formularios*/
    private $tipo = "text/html";
    //private $tipo = "application/json";
    private $codEstado = 200;
    private $ruta_controlador = '/controladores/';
    private $espacio_nombres = '\\app\\controladores\\';
    
    /*Constructor*/
    public function Api($params = array()) {
        $this->DamePeticion();
        //var_dump($_SERVER['REQUEST_URI']);
        //echo $this->peticion;
        $this->TratarURL();
        $this->EstablecerCabeceras();
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
            $parametros = explode("/", $url['query']);
            /*Extraigo la clase del array de parámetros*/
            $this->clase = array_shift($parametros);
            /*Extraigo el método del array de parámetros*/
            $this->metodo = array_shift($parametros);
            
//            echo '<br/>'.$this->clase;
//            echo '<br/>'.$this->metodo;
            
            
            /*Si todavía quedan elementos en el array..*/
            if(count($parametros) > 0) {
                /*..vienen más parámetros a parte de la clase y el método. Los argumentos del método a invocar */
                for ($i = 0; $i < count($parametros); $i++) {
                    $this->parametros[$i] = $parametros[$i];
                    $j++;
                }
            }
        } else
        {
            /**
             * Si no viene la clave query la petición se realizará a
             * la clase home y al método index()
             */
            $this->clase = 'home';
            $this->metodo = 'index';
            
//            echo '<br/>'.$this->clase;
//            echo '<br/>'.$this->metodo;
        }
    }
    
    /**
     * Función que establece la petición de acceso al servicio
     */
    public function DamePeticion() {
        
        if(isset($_SERVER['REQUEST_METHOD'])) {
            $this->peticion = $_SERVER['REQUEST_METHOD'];
        }
    }
    
    /**
     * Método que establece las cabeceras del servicio
     */
    public function EstablecerCabeceras() {
        header("HTTP/1.1 " . $this->codEstado . " " . $this->GetCodEstado());  
        header("Content-Type:" . $this->tipo . ';charset=utf-8');
     }
     
     /**
      * Método que devuelve el código del estado de la petición
      * @return string  Mensaje correspondiente al código del estado de la petición
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
       $ruta_controlador = __DIR__.$this->ruta_controlador.$this->clase.'.php';
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
               $controlador = $this->espacio_nombres.$this->clase.'\\'.$this->clase;
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
                       echo "No existe el método ".$this->metodo." de la clase ".$this->clase;
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
}
