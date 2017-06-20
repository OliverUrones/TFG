<?php 
/**
 * @author A. Oliver Urones García
 * @copyleft (cc) 2017, Oliver Urones
 * @license https://creativecommons.org/licenses/by-nc-sa/4.0/ Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0)
 * @version 1.0
 * 
 * Vista del logout de usuarios para la parte de administración
 * 
 * La vista recibe las siguientes variables del controlador
 * $estado_peticion Datos de la operación realizada
 * @var string JSON
 */
//var_dump($usuario); 
    if(isset($estado_peticion)) {
        $estado_peticion_json = json_decode($estado_peticion);
        //var_dump($estado_peticion_json);
        //var_dump(strcmp($estado_peticion, '200 OK'));
    }
?>
<?php ob_start() ?>
<!--    <div data-ng-app="loginApp" data-ng-controller="loginAppCtrl">-->
    <div>
        <h2>Logout</h2>
        <?php if(isset($estado_peticion_json) && (strcmp($estado_peticion_json->estado_p, "200 OK") == 0)) { ?>
            <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><?php echo $estado_peticion_json->Mensaje; ?></div>
        <?php } else { ?>
            <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><?php echo $estado_peticion_json->Mensaje; ?></div>
        <?php }  ?>
        <p>
          <a href="?home/admin" class="btn btn-primary btn-lg" role="button">Login</a>
        </p>
    </div>
<?php $contenido = ob_get_clean(); ?>
<?php 
    /*Función para cargar plantilla en la configuración*/
    $ruta_plantillas = PLANTILLAS.'plantilla_admin.php';
    //echo '<br/>'.$ruta_plantillas;
    require_once $ruta_plantillas;
?>