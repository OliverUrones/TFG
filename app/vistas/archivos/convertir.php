<?php //var_dump($usuario); 
//    if(isset($usuario)) {
//        $usuario_json = json_decode($usuario);
//    }

    $directorio_conversion = 'd'.uniqid();
    //echo $directorio_conversion;
    if(isset($error)) {
        $error_json = json_decode($error);
    }
?>
<?php ob_start() ?>
    <h2>Convierta documentos escaneados a PDF</h2>
    <?php if( (isset($error_json->estado_p) && $error_json->estado_p === '400 KO') ) { ?>
    <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>¡Error! </strong><?php echo $error_json->Mensaje; ?></div>
        <?php } ?>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-app="dragAndDropApp" ng-controller="DragAndDropController">
<?php
//Si viene el usuario...
if(isset($usuario)) {
    //..decodifico la cadena json
    $usuario_json = json_decode($usuario);
    //var_dump($usuario_json->token);
    //Al action del formulario se le añade el token
?>
<!--    <form role="form" class="form-horizontal" action="?archivos/convertir<?php if($usuario_json!=null) { echo SEPARADOR.$usuario_json->token ; }?>" method="POST" enctype="multipart/form-data" ng-app="dragAndDropApp" ng-controller="DragAndDropController">-->
    <form role="form" class="form-horizontal" action="?archivos/conversion<?php if($usuario_json!=null) { echo SEPARADOR.$usuario_json->token ; }?>" enctype="multipart/form-data" method="POST">
<!--    <form role="form" class="form-horizontal" action="" method="POST" ng-app="dragAndDropApp" ng-controller="DragAndDropController">-->
<?php } else { ?>
<!--<form id="formConvertir" role="form" class="form-horizontal" action="" method="POST" enctype="multipart/form-data" ng-app="dragAndDropApp" ng-controller="DragAndDropController"> -->
    <form role="form" class="form-horizontal" action="?archivos/conversion" enctype="multipart/form-data" method="POST"> 
<!--    <form role="form" class="form-horizontal" action="" method="POST"  ng-app="dragAndDropApp" ng-controller="DragAndDropController"> -->
<?php } ?>
<ng-model-options ng-model-options="{ getterSetter: true }">
    <ng-model ng-model="convertir.directorio = '<?php echo $directorio_conversion; ?>'"></ng-model>
</ng-model-options>
        <input type="hidden" name="directorio" value="<?php echo $directorio_conversion; ?>" ng-model="convertir.directorio">
        <div class="form-group dropzone form-group col-xs-12 col-sm-12 col-md-12 col-lg-12" options="dzOptions" callbacks="dzCallbacks" methods="dzMethods" ng-dropzone ng-model="convertir.archivos">
            <div class="dz-message">
                Arrastre aquí sus archivos escaneados
            </div>
        </div>
<!--        <div class="form-group" ng-app="dragAndDropApp" ng-controller="DragAndDropController">
            <div id="archivos" class="dropzone dz-clickable dz-started" options="dzOptions" methods="dzMethods" callbacks="dzCallbacks" ng-dropzone name="archivos">
                <div class="dz-message">
                    <span>Arrastre y suelte sus archivos escaneados</span>
                </div>
            <label>Seleccione uno o varios archivos</label>
            </div>-->
<!--<div ng-repeat="archivo in convertir.archivos">{{archivo}}</div>-->
<!--            <input type="file" id="archivos" multiple="multiple" class="form-control" name="archivos[{{archivos}}]">-->
            <p class="help-block">Formatos: JPG y/o PNG</p>
        <!-- Este archivo de salida se podría omitir-->
        <div class="form-group">
<!--            <label>Nombre del archivo de salida</label>-->
            <input type="hidden" placeholder="página.png" class="form-control" name="-b" value="pagina" ng-model="convertir.b">
<!--            <p class="help-block">Por defecto será pagina.png</p>-->
        </div>
        <div class="form-group">
<!--            <label>Nombre del archivo de salida en formato .PDF</label>-->
            <input type="hidden" placeholder="salida.pdf" class="form-control" name="-o" value="output" ng-model="convertir.o">
<!--            <p class="help-block">Por defecto será output.pdf</p>-->
        </div>
            <div>
                <div ng-class="vm.clase">
                    <div class="form-group">
                        <label>Umbral de saturación</label>
                        <div class=" input-group">
                            <input type="text" class="form-control" placeholder="20" name="-s" value="20">
                            <span class="input-group-addon">%</span>
                        </div>
                        <p class="help-block">Reduce los colores de la imagen a blanco y negro.</p>
                    </div>
                    <div class="form-group">
                        <label>Umbral de fondo</label>
                        <div class=" input-group">
                            <input type="text" class="form-control" placeholder="25" name="-v" value="25">
                            <span class="input-group-addon">%</span>
                        </div>
                        <p class="help-block">Los píxeles blancos representan los píxeles de la imagen cuyo valor está  en el rango del umbral, y los negros el valor que está  fuera de este rango.</p>
                    </div>
                    <div class="form-group">
                        <label>Profundidad del color</label>
                        <div class=" input-group">
                            <input type="text" class="form-control" placeholder="8" name="-n" value="8">
                            <span class="input-group-addon">%</span>
                        </div>
                        <p class="help-block">Cantidad de bits para representar el color de un píxel. 8 por defecto, equivale a 256 colores.</p>
                    </div>
                    <div class="form-group">
                        <label>Píxeles para muestrear</label>
                        <div class=" input-group">
                            <input type="text" class="form-control" placeholder="5" name="-p" value="5">
                            <span class="input-group-addon">%</span>
                        </div>
                        <p class="help-block">El muestreo reduce la resolución espacial de la imagen. 5 por defecto</p>
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="-w" checked>Color de fondo blanco
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="-S">Sin saturación de colores
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="-K">Mantiene los nombres de archivos ordenados.
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-default" ng-click="vm.ver()">{{vm.texto_boton}}</button>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success" id="EnviarArchivos" value="EnviarArchivos">Enviar</button>
            </div>
    </form>
    </div>
<?php $contenido = ob_get_clean(); ?>
<?php
    /*Función para cargar plantilla en la configuración*/
    $ruta_plantillas = PLANTILLAS.'plantilla.php';
    //echo '<br/>'.$ruta_plantillas;
    require_once $ruta_plantillas;
?>
