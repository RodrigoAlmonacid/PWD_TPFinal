<?php

include_once (__DIR__.'/../../control/Session.php');

$objSession = new Session();
$objSession->cerrar();

// Redirigir al login o al inicio
header('Location: ../login.php');
exit;
?>