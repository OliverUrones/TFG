<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controladores\logs;

use app\modelos\logsModelo\logsModelo;
/**
 * Description of logs
 *
 * @author oliver
 */
class logs {
    //put your code here
    public $archivo_log = NULL;
    public $datos_log = NULL;
    
    public function __construct() {
        $modeloLog = new logsModelo();
    }
    
    public function crearArchivo() {
        $modelo_log = new logsModelo();
        $modelo_log->dameDatosArchivoLog();
    }
}
