<div class="cuerpo" id="todo">

    <div class="mensajeInformativo informacion">
        <div class="top">
            <div class="bottom">
                <?if($_SESSION[duracion] > 0){?>
                    <p><span class="icono">Informacion: </span>Debes de terminar el test antes de que el crono llegue a 0. En cuanto finalice <br>el tiempo, los resultados se enviar&aacute;n autom&aacute;ticamente al profesor.
                    <br><strong style="text-decoration: underline; font-style: italic;">Las respuestas en blanco no restan puntos.</strong>
                    <br><strong style="text-decoration: underline; font-style: italic;">Las respuestas incorrectas restan <? echo round($_SESSION[penalizacion] * 100) / 100;?> puntos.</strong></p>
                <?}else{?>
                    <p><span class="icono">Informacion: </span>Cuando termines el test, pulsa el bot&oacute;n de <strong>"ENVIAR TEST"</strong> para finalizar <br> y los resultados se enviar&aacute;n autom&aacute;ticamente al profesor.
                    <br><strong style="text-decoration: underline; font-style: italic;">Las respuestas en blanco no restan puntos.</strong>
                    <br><strong style="text-decoration: underline; font-style: italic;">Las respuestas incorrectas restan <? echo round($_SESSION[penalizacion] * 100) / 100;?> puntos.</strong></p>
                <?}?>
            </div>
        </div>
    </div>

    <? PreguntasTest($_SESSION[examen]); ?>



</div>