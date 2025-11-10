<?php
include_once('Rol.php');
include_once('Usuario.php');
include_once('UsuarioRol.php');
//prueba clase usuario
//$objUsuario=new Usuario();
/* ->> Insert <<-
$objUsuario->cargar('Almonacid', 'almonacid@gmail.com', 'pass');
$insertar=$objUsuario->insertar();
if($insertar){
    echo "inserta\n";
}
else{
    echo $objUsuario->getMensaje()."\n";
}
*/
/* ->> buscar <<-
$buscar=$objUsuario->buscar(1);
if($buscar){
    echo "Usuario: ".$objUsuario."\n";
}
else{
    echo $objUsuario->getMensaje()."\n";
}
*/
/* ->> update <<-
$objUsuario->buscar(1);
echo "Usuario: ".$objUsuario."\n";
$objUsuario->setNom_usuario('Rodrigo Almonacid');
$modificar=$objUsuario->modificar();
if($modificar){
    $objUsuario->buscar(1);
    echo "Usuario modificado: ".$objUsuario."\n";
}
else{
    echo $objUsuario->getMensaje()."\n";
}
*/
/* ->> listar <<-
$array=$objUsuario->listar();
$cantidad=count($array);
if($cantidad>0){
    echo "Se encontraron ".$cantidad." usuarios.\n";
    foreach($array as $usuario){
        echo $usuario."\n";
    }
}
else{
    echo $objUsuario->getMensaje()."\n";
}
*/
/* ->> eliminar <<-

*/

$objUsuarioRol=new UsuarioRol();
$objUsuarioRol->cargar(3, 1);
$inserta=$objUsuarioRol->insertar();
/*if($inserta){
    echo "Inserta\n";
}
else{
    echo $objUsuarioRol->getMensaje()."\n";
}*/
$p=[
    'idusuario'=>1,
    'idrol'=>null
];
$arreglo=$objUsuarioRol->buscar($p);
echo "Usuario encontrado: ".$arreglo['usuario']."\nRoles: ";
foreach($arreglo['rol'] as $rol){
    echo $rol;
}
?>