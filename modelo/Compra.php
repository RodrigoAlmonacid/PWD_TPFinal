<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');
include_once('conector/conector.php');
include_once('Usuario.php');
class Compra{
    //atributos
    private $idCompra;
    private $fecha;
    private Usuario $objUsuario; //referencia a un objeto usuario
    private $mensaje;

    //constructor
    public function __construct()
    {
        $this->objUsuario=new Usuario();
        $this->idCompra=null;
        $this->fecha=date('Y-m-d H:i:s');
        $this->mensaje="";
    }

    //métodos de acceso
    public function getObjUsuario(){
        return $this->objUsuario;
    }
    public function setobjUsuario($objeto){
        $this->objUsuario=$objeto;
    }

    public function getIdCompra(){
        return $this->idCompra;
    }
    public function setIdCompra($id){
        $this->idCompra=$id;
    }

    public function getFecha(){
        return $this->fecha;
    }
    public function setFecha($fecha){
        $this->fecha=$fecha;
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
        $compra="Usuario: ".$this->getObjUsuario()."\n";
        $compra.="ID: ".$this->getIdCompra()."\n";
        $compra.="Fecha: ".$this->getFecha()."\n";
        return $compra;
    }

    //cargar los objetos rol
    public function cargar($idCompra, $fecha, $idUsuario){
        $objUsuario=new Usuario();
        $objUsuario->buscar($idUsuario);
        $this->setObjUsuario($objUsuario);
        $this->setFecha($fecha);
        $this->setIdCompra($idCompra);
    }

    //buscar un roles por id usuario o por id rol, mando el parámetro correspondiente
    public function buscar($id){
        $respuesta=false;
        $base=new BaseDatos();
        $consulta="SELECT * FROM compra WHERE idcompra=".$id.";";
            if($base->Iniciar()){
                if($base->Ejecutar($consulta)){
                    $row=$base->Registro();
                    if($row){
                        $respuesta=true;
                        $objUsuario=new Usuario();
                        $objUsuario->buscar($row['idusuario']);  
                        $this->setIdCompra($row['idcompra']);
                        $this->setFecha($row['cofecha']);
                        $this->setObjUsuario($objUsuario);
                    }
                }
                else {
                    $this->setMensaje("compra->buscar: " . $base->getError());
                }
            }
            else {
                $this->setMensaje("compra->buscar: " . $base->getError());
            }
        return $respuesta;
    }

    /** funcion para listar todas la compras
     * @return array
     * */
    public function listar($where){
        $base=new BaseDatos();
        $consulta="SELECT * FROM compra WHERE $where;";
        $arregloCompras=[];
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $row=$base->Registro();
                if($row){
                    do{
                        $objCompra=new Compra();
                        $objCompra->buscar($row['idcompra']);  
                        array_push($arregloCompras, $objCompra);
                    }while($row = $base->Registro());
                }
            }
            else {
                $this->setMensaje("usuariorol->listar: " . $base->getError());
            }
        }
        else {
            $this->setMensaje("uauariorol->listar: " . $base->getError());
        }
        return $arregloCompras;
    }

    /** funcion que me permite insertar una compra
     * @return bool
     */
    public function insertar(){
        $agrega=false;
        $base=new BaseDatos();
        $objUsuario=$this->getObjUsuario();
        $consulta="INSERT INTO compra(cofecha, idusuario) VALUES";
        $consulta.="('".$this->getFecha()."', ".$objUsuario->getId_usuario().");";
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $agrega=true;
            }
            else {
                $this->setMensaje("compra->insertar: " . $base->getError());
            } 	
        }
        else {
            $this->setMensaje("compra->insertar: " . $base->getError());
        }
        return $agrega;   
    }

    /** Funcion que me permite modificar una compra
     * @return bool
     */
    public function modificar(){
        $base=new BaseDatos();
        $objUsuario=$this->getObjUsuario();
        $modifica=false;
        $consulta="UPDATE compra SET ";
        $consulta.="idusuario=".$objUsuario->getId_usuario();
        $consulta.=" AND cofecha=".$this->getFecha();
        $consulta.=" WHERE idcompra=".$this->getIdCompra().";";        
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
            $modifica=true;
            }
            else {
                $this->setMensaje("compra->modificar: " . $base->getError());
            }
        }
        else {
            $this->setMensaje("compra->modificar: " . $base->getError());
        }
        return $modifica;
    }

    /** funcion que me permite eliminar un rol
     * @return bool
     */
    public function eliminar(){
        $base=new BaseDatos();
        $elimina=false;
        $consulta="DELETE FROM compra WHERE idcompra=".$this->getIdCompra().";";
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $elimina=true;
            }
            else {
                $this->setMensaje("compra->eliminar: " . $base->getError());
            } 	
        }
        else {
            $this->setMensaje("compra->eliminar: " . $base->getError());
        }
        return $elimina;
    }
}
?>