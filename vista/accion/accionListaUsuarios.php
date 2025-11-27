<?php
// Incluir el ABM. El ABMUsuario ya se encarga de incluir Usuario.php
// IMPORTANTE: Ajusta estas rutas si tu estructura de carpetas es diferente.
require_once('../../control/ABMusuario.php');
require_once('../../modelo/Usuario.php');

// 1. Instanciar el ABM
$abmUsuario = new ABMUsuario();

// 2. Llamar al método de listado de la clase ABM
// El método 'buscar' de ABMUsuario, si se le pasa NULL, devuelve todos los usuarios.
// El resultado es un ARREGLO de OBJETOS Usuario.
$arregloUsuarios = $abmUsuario->buscar(); 

// 3. Preparar el formato JSON que el datagrid de EasyUI espera
$datosParaGrid = array();

// El datagrid espera una lista de arrays asociativos, no de objetos.
if (count($arregloUsuarios) > 0) {
    foreach ($arregloUsuarios as $objUsuario) {
        $estado = $objUsuario->getDesHabilitado_usuario();
        if($estado==null){
            $estado="Habilitado";
        }
        else{
            $estado="Deshabilitado";
        }
        $datosParaGrid[] = array(
            'idusuario' => $objUsuario->getId_usuario(),
            'usnombre' => $objUsuario->getNom_usuario(),
            'usmail' => $objUsuario->getEmail_usuario(),
            'usdeshabilitado' => $estado
        );
    }
}

// Estructura final para EasyUI: {total: N, rows: [...]}
$respuesta = array(
    'total' => count($datosParaGrid),
    'rows' => $datosParaGrid
);

// 4. Enviar la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($respuesta);
?>