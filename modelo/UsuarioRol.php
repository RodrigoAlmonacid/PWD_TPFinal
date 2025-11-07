<?php
include_once('Usuario.php');
include_once('Rol.php');
class UsuarioRol{
    //atributos
    private $objUsuario; //referencia a Usuario
    private $objRol; //refrencia a Rol

    //constructor
    public function __construct()
    {
        $this->objUsuario=null;
        $this->objRol=null;
    }

    //métodos de acceso
    public function getObjUsuario(){
        return $this->objUsuario;
    }
    public function setObjUsuario($usuario){
        $this->objUsuario=$usuario;
    }

    public function getObjRol(){
        return $this->objRol;
    }
    public function setObjRol($rol){
        $this->objRol=$rol;
    }

    
}
?>