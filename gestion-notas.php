<div class="cuerpo">

    <form name="notas">
            <h2>Notas</h2>

            <h3>Elige un curso:</h3>
            <SELECT ONCHANGE="document.getElementById('alu').innerHTML = ''; document.getElementById('exa').innerHTML = ''; FAjax('cargacombos.php','asig','curso=' + document.forms.notas.curso.value,'post');" NAME="curso" style="font-size:13px">
                <OPTION SELECTED VALUE="0">Selecciona curso
                <?
                //Muestro los cursos que hay
                $directorio = opendir('./cursos');
                while ($file = readdir($directorio)) {
                      if ($file != '.' && $file != '..' && $file[0] != '.')
                          echo '<OPTION VALUE="'.$file.'">'.$file;
                }
                closedir('./cursos');
                ?>
                
            </SELECT>
            <br><br><br>

            <div id="asig">

            </div>

            <div id="alu">

            </div>

            <div id="exa">

            </div>
        </form>
</div>

