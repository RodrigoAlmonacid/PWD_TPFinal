<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ponete Las Pilas</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/color.css">

    <?php
        //include_once(__DIR__.'/configuracion.php');
        include_once('ruta.php');
        $ruta = ruta();
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        // Incluimos Session acá para que esté disponible en todas partes
        include_once(__DIR__.'/../../control/Session.php');
        $objSession = new Session();
    ?>
    

    <link rel="icon" href="<?=$ruta?>/vista/imagenes/logo.png" type="image/png">
    <link rel="stylesheet" href="<?php echo $ruta?>/vista/css/estilos.css">