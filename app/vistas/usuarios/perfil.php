<?php //var_dump($usuario); 
    if(isset($usuario)) {
        $usuario_json = json_decode($usuario);
        //var_dump($usuario_json);
    }
?>
<?php ob_start(); ?>
<?php 
    if(isset($usuario->token)) {
?>
<h2>Perfil del usuario</h2>
<?php
    } else {
?>
<h2>Error en la autentificación</h2>
<h3>Estado de la petición: <?php echo $usuario_json->estado; ?></h3>
<h3>Mensaje: <?php echo $usuario_json->Mensaje; ?></h3>
<?php
    }
?>
<?php $contenido = ob_get_clean(); ?>
<?php 
    /*Función para cargar plantilla en la configuración*/
    $ruta_plantillas = PLANTILLAS.'plantilla.php';
    //echo '<br/>'.$ruta_plantillas;
    require_once $ruta_plantillas;
?>