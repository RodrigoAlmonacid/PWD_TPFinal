<?php
class Rol{
    //atributos
    private $id_rol;
    private $descripcion_rol;

    //constructor
    public function __construct()
    {
        $this->id_rol=null;
        $this->descripcion_rol="";
    }

    //métodos de acceso
    public function getId_rol(){
        return $this->id_rol;
    }
    public function setId_rol($id){
        $this->id_rol=$id;
    }

    public function getDescripcion_rol(){
        return $this->descripcion_rol;
    }
    public function setDescripcion_rol($descripcion){
        $this->descripcion_rol=$descripcion;
    }
}
?>