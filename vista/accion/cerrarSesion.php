<?php

include_once ('../../control/Session.php');
// O incluye Session.php manualmente si no usas config
// include_once '../../control/Session.php';

$objSession = new Session();
$objSession->cerrar();

// Redirigir al login o al inicio
header('Location: ../login.php');
exit;
?>