<?php

echo 'TimeZonePHP default: ', date_default_timezone_get();
echo '<br/>';
echo '<br/>';



echo 'Fecha/hora actual: ', date('Y-m-d h:i:s', time());

echo '<br/>';
echo '<br/>';

$fecha = new DateTime('NOW');
echo 'Fecha/hora actual: ', $fecha->format('Y-m-d H:i:s');
