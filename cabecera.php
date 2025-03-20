<?		ini_set('session.gc_maxlifetime', 7200);
		ini_set("session.cookie_lifetime",7200);
?>
		  <div id="cabecera">
			<div id="navegacionPpal">

			  <strong><a class=logo href=bienvenida.php><h1 id="logo" style="font-size:42px; color:#DDD; margin-top:40px;margin-left:50px;"><?echo $nombre_admin;?></h1></a></strong>
			  <ul id="menuPpal">
				  <li><?if(substr_count($_SERVER['PHP_SELF'], 'bienvenida') > 0) echo "<strong>";?><a href="bienvenida.php" title=""><span>Inicio</span></a><?if(substr_count($_SERVER['PHP_SELF'], 'bienvenida') > 0) echo "</strong>";?></strong></li>
                                  <li><?if(substr_count($_SERVER['PHP_SELF'], 'alumnos') > 0) echo "<strong>";?><a href="alumnos.php" title=""><span>Alumnos</span></a><?if(substr_count($_SERVER['PHP_SELF'], 'alumnos') > 0) echo "</strong>";?></strong></li>
				  <li><?if(substr_count($_SERVER['PHP_SELF'], 'notas') > 0) echo "<strong>";?><a href="notas.php" title="Notas"><span>Notas</span></a><?if(substr_count($_SERVER['PHP_SELF'], 'notas') > 0) echo "</strong>";?></li>
				  <li><?if(substr_count($_SERVER['PHP_SELF'], 'examenes') > 0) echo "<strong>";?><a href="examenes.php" title="Ver ex&aacute;menes"><span>Ver ex&aacute;menes</span></a><?if(substr_count($_SERVER['PHP_SELF'], 'examenes') > 0) echo "</strong>";?></li>
                                 <!-- <li><?if(substr_count($_SERVER['PHP_SELF'], 'cargador') > 0) echo "<strong>";?><a href="cargador.php" title="Cargador"><span>Cargador</span></a><?if(substr_count($_SERVER['PHP_SELF'], 'cargador') > 0) echo "</strong>";?></li>-->
                                  <li><?if(substr_count($_SERVER['PHP_SELF'], 'servidor') > 0) echo "<strong>";?><a href="./explorer/index.php" title="Servidor"><span>Servidor</span></a><?if(substr_count($_SERVER['PHP_SELF'], 'servidor') > 0) echo "</strong>";?></li>
			  </ul>
			</div>
		  </div>