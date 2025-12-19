<?php
include_once('funciones.php');
if(enviarMail('rodrigo.almonacid@est.fi.uncoma.edu.ar', 'Prueba de Sistema', 'Si lees esto, el sistema funciona!')){
    echo "¡Configuración exitosa!";
} else {
    echo "Algo falló. Revisa los logs.";
}