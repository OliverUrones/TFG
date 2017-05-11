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
use app\modelos\archivosModelo\archivosModelo;
use app\modelos\categoriasModelo\categoriasModelo;
use app\controladores\logs\logs;

/**
 * Description of archivos
 *
 * @author oliver
 */
class archivos extends Api implements Rest {

    
    /**
     * Método que añade un archivo al repositorio desde la parte pública después de que un usuario logueado haya realizado una conversión
     * @param type $parametros
     */
    public function alta($parametros=NULL) {
        //echo "Estoy en el método alta del controlador archivos.";
        //var_dump($parametros);
        
        //Recojo los datos en formato JSON que mando desde el servidor a través de Ajax
        $json = file_get_contents('php://input');
        //var_dump($json);
        $obj = json_decode($json);
//        var_dump($obj);
//        var_dump($obj->usuario_id);
//        var_dump($obj->token);
//        var_dump($obj->archivo);
//        var_dump($obj->nombre);
//        var_dump($obj->categoria);
       
        //Opción para subir con autentificación previa de token
        //$parametros = ["token" => $obj->token, "usuario_id" => $obj->usuario_id, "archivo" => $obj->archivo, "nombre_archivo" => $obj->nombre, "categoria_id" => $obj->categoria];
        
        //Opción sin token para que el resultado se pueda subir igualmente.
        $parametros = ["directorio_id" => $obj->directorio_id, "usuario_id" => $obj->usuario_id, "archivo" => $obj->archivo, "nombre_archivo" => $obj->nombre, "categoria_id" => $obj->categoria, "ambito" => $obj->ambito, "etiquetas" => $obj->etiquetas];
        
        //var_dump($parametros);
        
        $archivosModel = new archivosModelo();
        $respuesta = $archivosModel->subeArchivo($parametros);
        
        $linea_log = [
                            "fecha" => '['.date("d-m-Y H:i:s").']',
                            "ip" => '[IP: '.$_SERVER['REMOTE_ADDR'].']',
                            "accion" => '[ACCION: '.'subir archivo'.']',
                            "nombre_archivo" => '[NOMBRE DEL ARCHIVO: '.$obj->nombre.']',
                            "archivo" => '[ARCHIVO: '.$obj->archivo.']',
                            "usuario_id" => '[ID USUARIO: '.$obj->usuario_id.']',
                            "estado" => '[ESTADO: '.$respuesta['estado'].']',
                            "mensaje" => '[MENSAJE: '.$respuesta['Mensaje'].']'
                        ];
        $logControlador = new logs('archivos', $linea_log);
        
        $respuesta = $this->construyeJSON($respuesta);
        
        //Borro el directorio
        $this->borrarDirectorioId($obj->directorio_id);
        
        $this->tipo = "application/json";
        $this->EstablecerCabeceras();
        //var_dump($respuesta);
        //Da problemas al enviar la respuesta JSON
        echo $respuesta;
        
    }
    
    /**
     * Función que borra archivos desde la parte pública del perfil de usuario a través de ajax
     * @param array $parametros Array asociativo que en este caso, al venir a través de Ajax, será nulo y se inicializarán con los valores recuperados de la cadena JSON a través de file_get_contents('php://input')
     */
    public function baja($parametros=NULL) {
        //echo "Método baja() de la parte pública";
        $json = file_get_contents('php://input');

        $obj = json_decode($json);
        $parametros = ['id' => $obj->archivo_id, 'token' => $obj->token];
        if(isset($parametros) && count($parametros) === 2) {
            if(isset($parametros['id']) && isset($parametros['token'])) {
                if(strlen($parametros['token']) === 14) {
                    $modeloUsuario = new usuariosModelo();
                    if($modeloUsuario->compruebaValidezToken($parametros['token'])) {
                        $modeloArchivos = new archivosModelo();
                        $respuesta = $modeloArchivos->borraArchivo($parametros['id']);
                        $respuesta = $this->construyeJSON($respuesta);
                        $this->tipo = "application/json";
                        $this->EstablecerCabeceras();
                        echo $respuesta;
                    }
                }
            }
        }
    }
    
    /**
     * Método para borrar archivos desde la parte privada de la aplicación
     * @param array $parametros Array asociativo que contiene el id del archivo y el token del administrador logueado
     */
    public function bajaAdmin($parametros=NULL) {
        //echo "Estoy en el controlador archivos en el método bajaAdmin()";
        $this->DamePeticion();
        if($this->peticion === "GET") {
            if(is_array($parametros) && count($parametros) === 2) {
                if(isset($parametros['id']) && isset($parametros['token'])) {
                    if(strlen($parametros['token']) === 14) {
                        $modeloUsuario = new usuariosModelo();
                        $admin = $modeloUsuario->dameUsuarioToken($parametros['token']);
                        
                        if($modeloUsuario->compruebaValidezToken($parametros['token'])) {
                            if(isset($admin['rol_id']) && $admin['rol_id'] === '1' && $admin['estado'] === '1') {
                                $modeloArchivos = new archivosModelo();
                                $archivoBorrar = $modeloArchivos->dameArchivoId($parametros['id']);
                                $archivoBorrar = $this->construyeJSON($archivoBorrar);
                                $admin = $this->construyeJSON($admin);

                                extract($admin);
                                extract($archivoBorrar);

                                $ruta_vista_admin_borrar = VISTAS.'archivos/admin_borrar.php';
                                require_once $ruta_vista_admin_borrar;
                            }
                        } else {
                            $error = $this->construyeJSON(array('estado_p' => '400 KO', 'Mensaje' => 'La sesión ha caducado.'));
                            extract($error);
                            
                            $ruta_vista_admin_login = VISTAS.'usuarios/admin_login.php';
                            require_once $ruta_vista_admin_login;
                        }
                    }
                }
            }
        }
        
        if($this->peticion === "POST") {
            echo "Vengo por POST";
            //var_dump($parametros);
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

                            if(isset($admin['rol_id']) && $admin['rol_id'] === '1' && $admin['estado'] === '1') {
                                //Construyo la cadena JSON
                                $admin = $this->construyeJSON($admin);
                                //Devuelvo lo datos del usuario a la vista
                                //var_dump($usuario);
                                extract($admin);
                                
                                $modeloArchivos = new archivosModelo();
                                $borrado = $modeloArchivos->borraArchivoId();
                                $borrado = $this->construyeJSON($borrado);

                                //$borrado es la respuesta json para devolver a la vista el mensaje
                                extract($borrado);

                                //var_dump($usuarios);

                                $ruta_vista_admin_borrar = VISTAS .'archivos/admin_borrar.php';
                                require_once $ruta_vista_admin_borrar;
                            } else {
                                //No tiene permiso
                            }
                        } else {
                            $error = $this->construyeJSON(array('estado_p' => '400 KO', 'Mensaje' => 'La sesión ha caducado.'));
                            extract($error);
                            
                            $ruta_vista_admin_login = VISTAS.'usuarios/admin_login.php';
                            require_once $ruta_vista_admin_login;
                        }
                    }
                }
            }
        }
    }
    
    /**
     * Método para modificar los datos de un archivo cuando un usuario está logueado desde la parte del perfil
     * @param array $parametros Array asociativo con el id del archivo y el token del usuario logueado
     */
    public function modificar($parametros=NULL) {
        echo "Estoy en el controlador archivos en el método modificar()";
        $this->DamePeticion();
        if($this->peticion === "GET") {
            if(is_array($parametros) && count($parametros) === 2){
                if(isset($parametros['id']) && isset($parametros['token'])) {

                    if(strlen($parametros['token']) === 14) {
                        //Creo un objeto usuario
                        //var_dump($parametros);
                        $modeloUsuario = new usuariosModelo();
                        //Si el token es válido...
                        if($modeloUsuario->compruebaValidezToken($parametros['token'])) {
                            //...recupero los datos del usuario
                            $modeloArchivos = new archivosModelo();
                            $modeloCategorias = new categoriasModelo();
                            $categorias = $modeloCategorias->dameCategorias();
                            $archivo = $modeloArchivos->dameArchivoId($parametros['id']);
                            $archivo['categorias'] = $categorias;
                            $archivo = $this->construyeJSON($archivo);
                            $usuario = $modeloUsuario->dameUsuarioToken($parametros['token']);

                            //Construyo la cadena JSON
                            $usuario = $this->construyeJSON($usuario);
                            extract($archivo);

                            //Devuelvo lo datos del usuario a la vista
                            extract($usuario);

                            $ruta_vista_admin_modificar = VISTAS .'archivos/modificar.php';
                            require_once $ruta_vista_admin_modificar;
                        } else {
                            $error = $this->construyeJSON(array('estado_p' => '400 KO', 'Mensaje' => 'La sesión ha caducado.'));
                            extract($error);
                            
                            $ruta_vista_login = VISTAS.'usuarios/login.php';
                            require_once $ruta_vista_login;
                        }
                    }

                }
            }
        }
        
        if($this->peticion === "POST") {
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

                            if($usuario['estado'] === '1') {

                                //Construyo la cadena JSON
                                $usuario = $this->construyeJSON($usuario);
                                //Devuelvo lo datos del usuario a la vista
                                //var_dump($usuario);
                                extract($usuario);

                                $modeloArchivo = new archivosModelo();
                                $archivo = $modeloArchivo->modificaArchivoId();
                                
                                //Recupero los categorias
                                $modeloCategorias = new categoriasModelo();
                                $categorias = $modeloCategorias->dameCategorias();
                                
                                //Añado las categorias al archivo recuperado para mostrar el tipo del rol en vez de el id
                                $archivo['categorias'] = $categorias;
                                $archivo = $this->construyeJSON($archivo);

                                //$borrado es la respuesta json para devolver a la vista el mensaje
                                extract($archivo);

                                //var_dump($archivo);

                                $ruta_vista_admin_modificar = VISTAS .'archivos/modificar.php';
                                require_once $ruta_vista_admin_modificar;
                            } else {
                                //No tiene permiso
                            }
                        } else {
                            $error = $this->construyeJSON(array('estado_p' => '400 KO', 'Mensaje' => 'La sesión ha caducado.'));
                            extract($error);
                            
                            $ruta_vista_login = VISTAS.'usuarios/login.php';
                            require_once $ruta_vista_login;
                        }
                    }
                }
            }
        }
    }

    /**
     * Método para modificar un archivo desde la parte privada de la aplicacición
     * @param array $parametros Array asociativo con el id del archivo y el token del administrador logueado
     */
    public function modificarAdmin($parametros=NULL) {
        echo "Estoy en la controlador archivos en el método modificarAdmin()";
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
                            $admin = $modeloUsuario->dameUsuarioToken($parametros['token']);
                            //...recupero los datos del usuario
                            if(isset($admin['rol_id']) && $admin['rol_id'] === '1' && $admin['estado'] === '1') {
                                $modeloArchivos = new archivosModelo();
                                $modeloCategorias = new categoriasModelo();
                                $categorias = $modeloCategorias->dameCategorias();
                                $archivo = $modeloArchivos->dameArchivoId($parametros['id']);
                                $archivo['categorias'] = $categorias;
                                $archivo = $this->construyeJSON($archivo);

                                //Construyo la cadena JSON
                                $admin = $this->construyeJSON($admin);
                                extract($archivo);
                                //Devuelvo lo datos del usuario a la vista
                                extract($admin);

                                $ruta_vista_admin_modificar = VISTAS .'archivos/admin_modificar.php';
                                require_once $ruta_vista_admin_modificar;
                            }
                        } else {
                            $error = $this->construyeJSON(array('estado_p' => '400 KO', 'Mensaje' => 'La sesión ha caducado.'));
                            extract($error);
                            
                            $ruta_vista_admin_login = VISTAS.'usuarios/admin_login.php';
                            require_once $ruta_vista_admin_login;
                        }
                    }

                }
            }
        }
        
        if($this->peticion === "POST") {
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

                                $modeloArchivo = new archivosModelo();
                                $archivo = $modeloArchivo->modificaArchivoId();
                                
                                //Recupero los categorias
                                $modeloCategorias = new categoriasModelo();
                                $categorias = $modeloCategorias->dameCategorias();
                                
                                //Añado las categorias al archivo recuperado para mostrar el tipo del rol en vez de el id
                                $archivo['categorias'] = $categorias;
                                $archivo = $this->construyeJSON($archivo);

                                //$borrado es la respuesta json para devolver a la vista el mensaje
                                extract($archivo);

                                //var_dump($usuarios);

                                $ruta_vista_admin_modificar = VISTAS .'archivos/admin_modificar.php';
                                require_once $ruta_vista_admin_modificar;
                            } else {
                                //No tiene permiso
                            }
                        } else {
                            $error = $this->construyeJSON(array('estado_p' => '400 KO', 'Mensaje' => 'La sesión ha caducado.'));
                            extract($error);
                            
                            $ruta_vista_admin_login = VISTAS.'usuarios/admin_login.php';
                            require_once $ruta_vista_admin_login;
                        }
                    }
                }
            }
        }
    }
    
    /**
     * Método que lista todos los archivos guardados en la base de datos para la parte privada de la aplicación
     * @param array $parametros Array asociativo con el token del administrador logueado
     */
    public function listarTodos($parametros=NULL) {
        echo "Estoy en la clase archivos en el método listarTodos";
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
                            
                            $modeloArchivos = new archivosModelo();
                            $archivos = $modeloArchivos->listadoArchivos();
                            $archivos = $this->construyeJSON($archivos);
                            
                            extract($archivos);
                            
                            //var_dump($usuarios);

                            $ruta_vista_admin_listado = VISTAS .'archivos/admin_listado.php';
                            require_once $ruta_vista_admin_listado;
                        } else {
                            //No tiene permiso
                        }
                    } else {
                        $error = $this->construyeJSON(array('estado_p' => '400 KO', 'Mensaje' => 'La sesión ha caducado.'));
                        extract($error);

                        $ruta_vista_admin_login = VISTAS.'usuarios/admin_login.php';
                        require_once $ruta_vista_admin_login;
                    }
                }
            }
        }
    }

        /**
     * Función que lista los archivos que un usuario tiene subidos en su perfil.
     * @param array $parametros Array asociativo con el id  y el token del usuario logueado
     */
    public function listar($parametros=NULL) {
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
                        
                        $archivo = new archivosModelo();
                        $archivos = $archivo->dameArchivos($parametros['id']);

                        //var_dump($archivos);
                        $archivos = $this->construyeJSON($archivos);

                        extract($archivo);

                        $ruta_vista_perfil = VISTAS .'usuarios/perfil.php';
                        require_once $ruta_vista_perfil;
                    } else {
                        $error = $this->construyeJSON(array('estado_p' => '400 KO', 'Mensaje' => 'La sesión ha caducado.'));
                        extract($error);

                        $ruta_vista_login = VISTAS.'usuarios/login.php';
                        require_once $ruta_vista_login;
                    }
                }
            }
        }
    }
    
    /**
     * Método que devuelve en formato JSON los datos de un archivo para visualizarlo. Este método se usa para visualizar los datos del archivo que se va a querer borrar
     * desde el perfil de la parte pública
     * @param array $parametros Array asociativo con el id del archivo y el token del usuario logueado
     */
    public function ver($parametros=NULL) {
        //echo "Estoy en el método ver() del controlador archivos";
        if(is_array($parametros) && count($parametros) === 2) {
            if(isset($parametros['id']) && isset($parametros['token'])) {
                if(strlen($parametros['token']) === 14) {
                    $modeloUsuario = new usuariosModelo();
                    if($modeloUsuario->compruebaValidezToken($parametros['token'])) {
                        $archivoModelo = new archivosModelo();
                        $archivo = $archivoModelo->dameArchivoId($parametros['id']);
                        $archivo = $this->construyeJSON($archivo);
                        echo $archivo;
                    }
                }
            }
        }
    }
    
    /**
     * Función para subir las fotos automáticamente cuando se añaden a la zona Drag and Drop del formulario de convertir
     * @param array $parametros Array con valor NULL para este método
     */
    public function subir($parametros=NULL) {
        //echo "Estoy en el método subir() del controlador archivos";
        //var_dump($_FILES['archivos']);
        $this->DamePeticion();
        if($this->peticion === "POST" && isset($_POST['directorio'])) {
            //$directorio_id contiene el identificador de directorio
            $directorio_id = $_POST['directorio'];
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
                    //$writable = is_writable(CARPETA_TEMPORALES);
                    //Creo un directorio único que genero en la vista y lo mando por POST
                    if(!file_exists(CARPETA_TEMPORALES.$directorio_id)){
                        mkdir(CARPETA_TEMPORALES.$directorio_id);
                    }
                    //var_dump($_POST['directorio']);
                    foreach ($_FILES['archivos']['tmp_name'] as $key => $value) {
                        //Se recoge la ruta de origen
                        $origen = $_FILES['archivos']['tmp_name'][$key];
                        //Se extrae el nombre temporal que se le asigna
                        $nombre_temp = explode("/", $value);
                        $nombre_temp = $nombre_temp[2];
                        //echo $nombre_temp;
                        //El destino será en la carpeta temp/$nombre_temp extraído
                        $destino = CARPETA_TEMPORALES . $directorio_id . SEPARADOR . microtime()."-".$nombre_temp;
                        //echo "<p>".$destino."</p>";
                        //Si se ha movido con éxtio...
                        if(move_uploaded_file($origen, str_replace(" ", "-", $destino)))
                        {
                            //var_dump($origen);
                            //var_dump($destino);
                            //Construyo la cadena de parámetros con el nombre de los archivos
                            //Quedará algo como /var/www/html/app/temp/archivo1 /var/www/html/app/temp/archivo2 ...
                            //$images = $destino.' '.$images;
                            $images .= $destino.' ';
                            //var_dump($images);
                            //echo "<br/>Se ha movido el archivo subido correctamente.";
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
     * Método que borra todos los archivos que permanecen en la carpeta temp de la aplicación
     */
    private function __borrarTodosTemporales() {
        $manejador = opendir(CARPETA_TEMPORALES);
        while ($archivo = readdir($manejador)) {
            if($archivo !== '.' && $archivo !== '..') {
                unlink(CARPETA_TEMPORALES.$archivo);
            }
        }
    }

    /**
     * Método que realiza la conversión cuando se pulsa el botón enviar y se han subido archivos automáticamente a través de la zona
     * de Drag and Drop
     * @param array $parametros Array asociativo con el token del usuario logueado o NULL si no se ha logueado ningún usuario
     */
    public function conversion($parametros=NULL) {
        //Incluyo las otras partes del layout
        //Tendría que incluir las categorías aquí también y en cada uno de los métodos
//        $ruta_vista_login = VISTAS . 'usuarios/login.php';
//        require_once $ruta_vista_login;
        
        $this->DamePeticion();
        //Viene por GET
        if($this->peticion === "GET")
        {
            //Borrar todos los temporales
            //$this->__borrarTodosTemporales();
            //Recoge el tipo de petición realizada
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
        
        if($this->peticion === "POST") {
            $directorio_id = $_POST['directorio'];
            //sleep(5);// Hago un sleep para que le de tiempo al Dropzone a subir los ficheros al servidor
            //var_dump($_POST);
            //Compruebo que se hayan archivos en la carpeta de los archivos temporales
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
            //var_dump(CARPETA_TEMPORALES);
            $temporales = scandir(CARPETA_TEMPORALES.$directorio_id, SCANDIR_SORT_ASCENDING);
            //var_dump($temporales);
            $images = '';
            for ($i=0; $i<=count($temporales)-1; $i++) {
                //var_dump($temporales[$i]);
                if($temporales[$i] !== '.' && $temporales[$i] !== '..') {
                    //echo '<br/>'.$temporales[$i];
                    $images .= CARPETA_TEMPORALES . $directorio_id . SEPARADOR . $temporales[$i].' ';
                    //var_dump($images);
                }
            }
            //La variable $images contiene la ruta de las imágenes que se le va a pasar al script NotheShrink.py para la conversión de archivos
                //echo '<br/>'.$images;
            //var_dump($images);
            //Se construye la cadena con los argumentos que se le pasarán posteriormente al script
            //Será de la forma: /var/www/html/TFG/app/temp/archivo1 [/var/www/html/TFG/app/temp/archivo2] -b salida.png -o salida.pdf -s 20 -v 25 -n 8 -p 5 -w -S -K
            $argumentos = $this->procesarParametros($images, $_POST);
            //echo $argumentos.'<br/';
            $salida = $this->ejecutarNoteshrink($argumentos);
            //var_dump($salida);
            if($salida !== NULL) {
                //Se ha ejecutado el script noteshrink.py correctamente
                //Se debería gestionar los archivos que ha generado el script
                //Primero borraré los temporales haciendo referencia a la salida: opened ... ruta/archivo/temporal
                //var_dump($salida[count($salida)-1]);
                $this->borrarTemporales($salida);

                //
                $nombre_archivo = $this->construyeJSON(array('nombre' => $this->dameNombreArchivo($salida[count($salida)-1])));
                $directorio_id = $this->construyeJSON(array('directorio_id' => $directorio_id));
                //var_dump($ruta_archivo_temporal);
                extract($nombre_archivo);
                
                extract($directorio_id);

                //..muestra el forumulario de registro
                $ruta_vista = VISTAS .'archivos/resultado.php' ;
                require_once $ruta_vista;
            } else {
                echo "El script noteshrink.py ha tirado algún error.";
                
                $this->borrarDirectorioId($directorio_id);
                $directorio_id = $this->construyeJSON(array('directorio_id' => $directorio_id));
                extract($directorio_id);
                
                $error = $this->construyeJSON(array('estado_p' => '400 KO', 'Mensaje' => 'Pruebe a dejar los parámetros por defecto o vuélvalo a intentar'));
                extract($error);
                
                
                $ruta_vista = VISTAS .'archivos/convertir.php' ;
                require_once $ruta_vista;
            }
        }
    }

    /**
     * NOTA: Esta función no se usa en ningún sitio de la aplicación ya que el proceso de convertir archivos lo he dividido en dos:
     * 1º se suben las fotos al servidor a través del drag And Drop del formulario de forma automática con Dropzone.js
     * 2º se manda el resto de datos del formulario (parámetros para el script NoteShrink.py) para realiar la conversión
     * Estas dos etapas las realizan los métodos subir() y conversion().
     * Función que muestra el formulario de subida de darchivos si viene por GET.Si viene por POST sube los archivos y manda los parámetros del script a la vez para realizar la conversión con NoteShrink.py
     * @param type $parametros
     */
    public function convertir($parametros=NULL) {
        //Habría que comprobar si hay usuario logueado o no!!
        //Si viene el directorio de una conversión anterior lo borro
        if(isset($parametros['directorio'])) {
            //var_dump($parametros['directorio']);
            $this->borrarDirectorioId($parametros['directorio']);
        }
        //Incluyo las otras partes del layout
        //Tendría que incluir las categorías aquí también y en cada uno de los métodos
//        $ruta_vista_login = VISTAS . 'usuarios/login.php';
//        require_once $ruta_vista_login;
        
        //Recoge el tipo de petición realizada
        $this->DamePeticion();
        //Viene por GET
        //Borro todos los temporales para evitar errores y conflictos
        if($this->peticion === "GET")
        {
        $this->__borrarTodosTemporales();
            //var_dump($parametros);
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
//            var_dump($_POST);
//            var_dump($_GET);
//            var_dump($_FILES);
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
                        $destino = CARPETA_TEMPORALES . microtime()."-".$nombre_temp;
                        //echo "<p>".$destino."</p>";
                        //Si se ha movido con éxtio...
                        if(move_uploaded_file($origen, str_replace(" ", "-", $destino)))
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
                    //Será de la forma: /var/www/html/TFG/app/temp/archivo1 [/var/www/html/TFG/app/temp/archivo2] -b salida.png -o salida.pdf -s 20 -v 25 -n 8 -p 5 -w -S -K
                    $argumentos = $this->procesarParametros($images, $_POST);
                    //echo $argumentos.'<br/';
                    $salida = $this->ejecutarNoteshrink($argumentos);
                    if($salida !== NULL) {
                        //Se ha ejecutado el script noteshrink.py correctamente
                        //Se debería gestionar los archivos que ha generado el script
                        //Primero borraré los temporales haciendo referencia a la salida: opened ... ruta/archivo/temporal
                        //var_dump($salida[count($salida)-1]);
                        $this->borrarTemporales($salida);
                        
                        //
                        $nombre_archivo = $this->construyeJSON(array('nombre' => $this->dameNombreArchivo($salida[count($salida)-1])));
                        //var_dump($ruta_archivo_temporal);
                        extract($nombre_archivo);
                    } else {
                        //El script noteshrink.py ha tirado algún error
                    }
                } else 
                {
                    echo "El formato requerido no coincide.";
                }
            } else {
                //Mensaje de error no se han subido los ficheros correctamente
                echo 'AQUÍ--Error al subir los ficheros';
            }
            //..muestra el forumulario de registro
            $ruta_vista = VISTAS .'archivos/resultado.php' ;
            require_once $ruta_vista;
        }
    }
    
    /**
     * Función que devuelve la ruta en la carpeta temp del fichero pdf convertido
     * @param string $salida Última línea del script NoteShrink.py que muestra la cadena wrote ruta/al/archivo.pdf
     * @return string $ruta Cadena con la ruta al archivo
     */
    private function dameNombreArchivo($salida) {
        //Si está la palabra "wrote" en $salida...
        if(strpos($salida, "wrote")){
            //Divido por esa palabra y en la segunda posición del array está la ruta al archivo temporal
            $ruta = explode("wrote ", $salida);
            //var_dump($ruta[1]);
            $array_ruta = explode("/", $ruta[1]);
            $nombre_archivo = $array_ruta[count($array_ruta)-1];
            return $nombre_archivo;
        }
    }
    
    /**
     * Método para establecer las cabeceras a la hora de descargar los archivos que hacen referencia en la base de datos.
     * @param array $parametros Array asociativo con el archivo para descargar
     */
    public function descargarArchivo($parametros=NULL) {
        if(isset($parametros['archivo'])) {
            //var_dump($parametros['archivo']);
            $this->tipo = "application/pdf";
            $file = DIRECTORIO_ARCHIVOS_ABSOLUTA.$parametros['archivo'];
            $this->EstablecerCabeceras($file, $parametros['archivo']);
        }
    }


    /**
     * Método para descargar el archivo inmediatamente después de ejecutar la conversión
     * @param array $parametros Array asociativo con el archivo para descargar
     */
    public function descargar($parametros=NULL) {
        //Si viene el nombre del archivo...
        if(isset($parametros['archivo']) && isset($parametros['directorio'])) {
            //Se establece el tipo Content-Type para la cabecera
            //Funciona tanto con 'application/force-download' como con 'application/pdf'
            //$this->tipo = 'application/force-download';
            $this->tipo = 'application/pdf';
            //Se construye la ruta del archivo para ser descargado
            $file = CARPETA_TEMPORALES.$parametros['directorio'].SEPARADOR.$parametros['archivo'];
            //Se establece la cabecera pasándole el archivo a ser descargado.
            $this->EstablecerCabeceras($file, $parametros['archivo']);
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
            //Busco la cadena 'opened '
            $posicion = strpos($value, 'opened ');
            //Si está...
            if($posicion !== false)
            {
                //echo "key ".$key.' -- '.$value.'<br/>';
                //Divido la cadena por el espacio
                $ruta = explode(' ', $value);
                //y borro la segunda posición que es la ruta al archivo
                unlink($ruta[1]);
            } else {
                
            }
        }
    }
    
    /**
     * Método para borrar los archivos que quedan en el directorio después de la conversión y el propio directorio.
     * @param string $id Identificador del directorio a borrar.
     */
    public function borrarDirectorioId($id) {
        $ruta = CARPETA_TEMPORALES.$id;
        if(is_dir($ruta)) {
            $dir = opendir($ruta);
            //var_dump($dir);
            while (false !== ($archivo = readdir($dir))) {
                if($archivo != "." && $archivo != "..") {
                    unlink($ruta.SEPARADOR.$archivo);
                }
            }
            rmdir($ruta);
        }
    }

    /**
     * Función que llama al script NoteShrink.py para tratar los archivos
     * @param string $argumentos Los argumentos del script
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
                if($value === 'image/jpeg' || $value === 'image/png' || $value === 'image/jpg')
                {
                } else
                {
                    //echo '<p>'.$value.'</p>';
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
                $params['-o'] = CARPETA_TEMPORALES.$params['directorio'].SEPARADOR.$params['-o'].'.pdf';
                //var_dump($params);
            }
            
            //Estalbezco la ruta de la carpeta temporal donde se van a guardar las imágenes .png mejoradas
            if(isset($params['-b']))
            {
                $params['-b'] = CARPETA_TEMPORALES.$params['directorio'].SEPARADOR.$params['-b'];
                //var_dump($params);
            }
            foreach ($params as $opcion => $value) {
                if($opcion !== 'directorio') {
                    if($opcion === '-w' || $opcion === '-S' || $opcion === '-K')
                    {
                        $cadena = $cadena.$opcion.' ';
                    } else {
                        $cadena = $cadena.$opcion.' '.$value.' ';
                    }
                }
            }
            //var_dump($cadena);
            return $cadena;
        }
    }
}
