<?php ob_start() ?>
    <h2>Convierta documentos escaneados a PDF</h2>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <form role="form" class="form-horizontal">
        <div class="form-group">
            <label>Seleccione uno o varios archivos</label>
            <input type="file" id="archivos" multiple="multiple" class="form-control">
            <p class="help-block">Formatos: JPG, GIF y/o PNG</p>
        </div>
        <!-- Este archivo de salida se podría omitir-->
        <div class="form-group">
            <label>Nombre del archivo de salida</label>
            <input value="página.png" type="text" placeholder="página.png" class="form-control">
            <p class="help-block">Por defecto será page.png</p>
        </div>
        <div class="form-group">
            <label>Nombre del archivo de salida en formato .PDF</label>
            <input value="salida.pdf" type="text" placeholder="salida.pdf" class="form-control">
            <p class="help-block">Por defecto será output.pdf</p>
        </div>
        <div ng-app="avanzadasApp" ng-controller="avanzadasAppCtrl as vm">
            <div ng-class="vm.clase">
                <div class="form-group">
                    <label>Umbral de saturación</label>
                    <div class=" input-group">
                        <input value="20" type="text" class="form-control" placeholder="20" value="20">
                        <span class="input-group-addon">%</span>
                    </div>
                    <p class="help-block">Reduce los colores de la imagen a blanco y negro.</p>
                </div>
                <div class="form-group">
                    <label>Umbral de fondo</label>
                    <div class=" input-group">
                        <input value="25" type="text" class="form-control" placeholder="25" value="25">
                        <span class="input-group-addon">%</span>
                    </div>
                    <p class="help-block">Los píxeles blancos representan los píxeles de la imagen cuyo valor está  en el rango del umbral, y los negros el valor que está  fuera de este rango.</p>
                </div>
                <div class="form-group">
                    <label>Profundidad del color</label>
                    <div class=" input-group">
                        <input value="8" type="text" class="form-control" placeholder="8" value="8">
                        <span class="input-group-addon">%</span>
                    </div>
                    <p class="help-block">Cantidad de bits para representar el color de un píxel. 8 por defecto, equivale a 256 colores.</p>
                </div>
                <div class="form-group">
                    <label>Píxeles para muestrear</label>
                    <div class=" input-group">
                        <input value="5" type="text" class="form-control" placeholder="5" value="5">
                        <span class="input-group-addon">%</span>
                    </div>
                    <p class="help-block">El muestreo reduce la resolución espacial de la imagen. 5 por defecto</p>
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox">Color de fondo blanco
                        </label>
                    </div>
                    <div  class="checkbox">
                        <label>
                            <input type="checkbox">Sin saturación de colores
                        </label>
                    </div>
                    <div  class="checkbox">
                        <label>
                            <input type="checkbox">Mantiene los nombres de archivos ordenados.
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-default" ng-click="vm.ver()">{{vm.texto_boton}}</button>
            </div>
        </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Enviar</button>
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