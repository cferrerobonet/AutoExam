<div id="secundario">				
	<div class="reloj">
        <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="165" height="150">
            <param name="movie" value="reloj.swf"></param>
            <param name="quality" value="high"></param>
      <embed src="reloj.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="165" height="150"></embed>
      </object>
            <div align="center" id="crono">
              <h3>Tiempo:<strong> --:--</strong></h3>           
            </div>
            <? 
                $nomfoto = "noimage.jpg";
                $directorio = opendir("./cursos/$_SESSION[curso]/fotos");

                //Miro si existe la foto, y si no existe, pongo la noimage.jpg
                 while ($file = readdir($directorio)){

                    $nom1 = str_replace(" ",'', $file);
                    $nom1 = str_replace(",", '', $nom1);
                    $nom1 = strtolower($nom1);

                    $nom2 = str_replace(' ', '', ucwords(($_SESSION[alu])).".jpg");
                    $nom2 = str_replace(",", '', $nom2);
                    $nom2 = strtolower($nom2);
                   
                    //echo $nom1."<br>".$nom2."<br>";
                    if ($file != '.' && $file != '..' && (strcmp($nom1,$nom2) == 0)){
                        $nomfoto = $file;
                    }
                 }                 
                 $altura = DameAltura("./cursos/$_SESSION[curso]/fotos/$nomfoto");
            ?>
            <div align="center"><img border="1" width="140" height="<? echo $altura; ?>" src="./cursos/<? echo $_SESSION[curso]; ?>/fotos/<? echo $nomfoto; ?>"></div>
      </div>
</div>