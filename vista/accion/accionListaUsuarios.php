<?php
require_once('../../control/ABMusuario.php');
require_once('../../modelo/Usuario.php');

$abmUsuario = new ABMUsuario();

// El método 'buscar' si se le pasa NULL, devuelve todos los productos, un arreglo de objetos
$arregloUsuarios = $abmUsuario->buscar(null); 

//Preparar el formato JSON que el datagrid de EasyUI espera
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

//Enviar la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($respuesta);
?>