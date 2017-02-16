<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modelos\envioEmailModelo;

require_once PHPMAILER;
require_once PHPMAILER_SMTP;

/**
 * Description of envioEmailModelo
 *
 * @author oliver
 */
class envioEmailModelo {
        
    public $seguridad = "ssl";
    public $host = "smtp.gmail.com";
    public $puerto = 465;
    public $usuario = "Oliver.Urones@usal.es";
    //Quitar la contraseña antes de subirlo al repositorio
    public $password = "********";
    
    /**
     * Función que manda un correo con el enlace para activar la cuenta
     * @param int $usuario_id   id del usuario
     * @param string $email     email del usuario
     */
    public function activarCuenta($usuario_id, $email, $nombre, $apellidos) {
        //Creación del objeto mail de la clase PHPMailer
        $mail = new \PHPMailer();
        
        //Activo el debug
        $mail->SMTPDebug = 2;
        
        //Configuración envío por SMTP
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = $this->seguridad;
        
        //Datos del servidor
        $mail->Host = $this->host;
        $mail->Port = $this->puerto;
        $mail->Username = $this->usuario;
        $mail->Password = $this->password;
        
        //Emisor del correo
        $mail->setFrom("no-reply@repositorio.es", "Oliver Urones");
        
        //Receptor del correo
        $mail->addAddress($email, $nombre." ".$apellidos );
        
        $mail->Subject = "Activar cuenta";
        $mail->Body = "Para activar la cuenta haga click <a href=\"https://localhost/TFG2/?usuarios/activar/".$usuario_id."\">". utf8_decode("Aquí")."</a>";
        $mail->AltBody = "Para activar la cuenta copie el siguiente enlace https://localhost/TFG2/?usuarios/activar/".$usuario_id." y péguelo en la barra de direcciones del navegador";

        if($mail->send()){
            echo "Mensaje enviado";
        } else {
            //Ver info del error
            echo "Error al enviar mensaje: " . $mail->ErrorInfo;
        }
    }
}
