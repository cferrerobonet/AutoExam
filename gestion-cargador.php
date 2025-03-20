<div class="cuerpo">

    <form name="notas">
            <h2>Cargador</h2>

            <h3>Elige un curso:</h3>
            <SELECT ONCHANGE="document.getElementById('alu').innerHTML = ''; FAjax('cargacombos4.php','asig','curso=' + document.forms.notas.curso.value,'post');" NAME="curso" style="font-size:13px">
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
            <br><br>
            <a onclick="var miFecha = new Date(); var ano = miFecha.getFullYear(); if(confirm('Si pulsas aceptar, se crear&aacute; el nuevo curso ' + ano + '-' + (ano+1) + '\n&iquest;SEGURO QUE QUIERES CREARLO?'))FAjax('creacurso.php','creacurso','','post');location.href='alumnos.php'" style="font-size:12px;text-decoration:underline;cursor:pointer;">A&ntilde;adir siguiente curso curso</a><br><br><br>
                        
            
            <div id="creacurso">
                <?/*
                        if($_SESSION['cc'] == 1){
                            echo '<div class="mensajeInformativo informacion">
                                    <div class="top">
                                        <div class="bottom">
                                            <p><span class="icono">Informacion: </span>El curso <strong>'.Date('Y').'-'.(Date('Y')+1).'</strong> ha sido creado con satisfactoriamente.</p>
                                        </div>
                                    </div>
                                    </div>';
                            $_SESSION['cc'] = 2;
                        }
                        if($_SESSION['cc'] == 0){
                            echo '<div class="mensajeInformativo informacion">
                                <div class="top">
                                    <div class="bottom">
                                        <p><span class="icono">Informacion: </span>El curso <strong>'.Date('Y').'-'.(Date('Y')+1).'</strong> ya exist&iacute;a.</p>
                                    </div>
                                </div>
                                </div>';
                            $_SESSION['cc'] = 2;
                        }                       
                */
                ?>
            </div>

            <div id="asig">

            </div>

            <div id="alu">

            </div>

        </form>
</div>

