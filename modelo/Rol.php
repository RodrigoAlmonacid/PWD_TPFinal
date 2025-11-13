<?php
include_once('conector/conector.php');
class Rol{
    //atributos
    private $id_rol;
    private $descripcion_rol;
    private $mensaje;

    //constructor
    public function __construct()
    {
        $this->id_rol=null;
        $this->descripcion_rol="";
        $this->mensaje="";
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
    
    public function getMensaje(){
        return $this->mensaje;
    }
    public function setMensaje($mensaje){
        $this->mensaje=$mensaje;
    }

    //metodo toString
    public function __toString()
    {
        $rol="ID rol: ".$this->getId_rol()."\n";
        $rol.="Descripcion: ".$this->getDescripcion_rol()."\n";
        return $rol;
    }


    //cargar rol
    public function cargar($descripcion){
        $this->setDescripcion_rol($descripcion);
    }

    //buscar un rol por id
    public function buscar($id){
        $base=new BaseDatos();
        $consulta="SELECT * FROM rol WHERE idrol=".$id.";";
        $respuesta=false;
        if($base->Iniciar()){
            if($base->Ejecutar($consulta)){
                $row=$base->Registro();
                if($row){
                    $respuesta=true;
                    $this->setId_rol($row['idrol']);
                    $this->setDescripcion_rol($row['rodescripcion']);  
                }
            }
            else {
                $this->setMensaje("rol->buscar: " . $base->getError());
            }
        }
        else {
            $this->setMensaje("rol->buscar: " . $base->getError());
        }
        return $respuesta;
    }

    /** funcion para listar todos los roles
     * @return array
     * */
    public function listar(){
        $base=new BaseDatos();
        $consulta="SELECT * FROM rol;";
        $arregloRol=[];
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $row=$base->Registro();
                if($row){
                    do{
                        $objRol=new Rol();
                        $objRol->setId_rol($row['idrol']);
                        $objRol->setDescripcion_rol($row['rodescripcion']);  
                        array_push($arregloRol, $objRol);
                    }while($row = $base->Registro());
                }
            }
            else {
                $this->setMensaje("rol->listar: " . $base->getError());
            }
        }
        else {
            $this->setMensaje("rol->listar: " . $base->getError());
        }
        return $arregloRol;
    }

    /** funcion que me permite insertar un rol
     * @return bool
     */
    public function insertar(){
        $agrega=false;
        $base=new BaseDatos();
        $consulta="INSERT INTO rol (rodescripcion) VALUES";
        $consulta.="('".$this->getDescripcion_rol()."');";
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $agrega=true;
            }
            else {
                $this->setMensaje("rol->insertar: " . $base->getError());
            } 	
        }
        else {
            $this->setMensaje("rol->insertar: " . $base->getError());
        }
        return $agrega;   
    }

    /** Funcion que me permite modificar un rol
     * @return bool
     */
    public function modificar(){
        $base=new BaseDatos();
        $modifica=false;
        $consulta="UPDATE rol SET ";
        $consulta.="rodescripcion='".$this->getDescripcion_rol();
        $consulta.="' WHERE id_rol=".$this->getId_rol().";";        
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
            $modifica=true;
            }
            else {
                $this->setMensaje("rol->modificar: " . $base->getError());
            }
        }
        else {
            $this->setMensaje("rol->modificar: " . $base->getError());
        }
        return $modifica;
    }

    /** funcion que me permite eliminar un rol
     * @return bool
     */
    public function eliminar(){
        $base=new BaseDatos();
        $elimina=false;
        $consulta="DELETE FROM rol WHERE idrol=".$this->getId_rol().";";
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $elimina=true;
            }
            else {
                $this->setMensaje("usuario->eliminar: " . $base->getError());
            } 	
        }
        else {
            $this->setMensaje("usuario->eliminar: " . $base->getError());
        }
        return $elimina;
    }
}
?>