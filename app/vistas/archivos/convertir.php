<?php ob_start() ?>
    <h2>Convierta documentos escaneados a PDF</h2>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<?php
//Si viene el usuario...
if(isset($usuario)) {
    //..decodifico la cadena json
    $usuario_json = json_decode($usuario);
    //var_dump($usuario_json->token);
    //Al action del formulario se le añade el token
?>
    <form role="form" class="form-horizontal" action="?archivos/convertir<?php if($usuario_json!=null) { echo SEPARADOR.$usuario_json->token ; }?>" method="POST" enctype="multipart/form-data">
<?php } else { ?>
    <form role="form" class="form-horizontal" action="?archivos/convertir" method="POST" enctype="multipart/form-data"> 
<?php } ?>
        <div class="form-group">
            <label>Seleccione uno o varios archivos</label>
            <input type="file" id="archivos" multiple="multiple" class="form-control" name="archivos[]">
            <p class="help-block">Formatos: JPG y/o PNG</p>
        </div>
        <!-- Este archivo de salida se podría omitir-->
        <div class="form-group">
            <label>Nombre del archivo de salida</label>
            <input type="text" placeholder="página.png" class="form-control" name="-b" value="pagina">
            <p class="help-block">Por defecto será pagina.png</p>
        </div>
        <div class="form-group">
            <label>Nombre del archivo de salida en formato .PDF</label>
            <input type="text" placeholder="salida.pdf" class="form-control" name="-o" value="output">
            <p class="help-block">Por defecto será output.pdf</p>
        </div>
        <div ng-app="avanzadasApp" ng-controller="avanzadasAppCtrl as vm">
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
                <button type="submit" class="btn btn-success" value="Enviar">Enviar</button>
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