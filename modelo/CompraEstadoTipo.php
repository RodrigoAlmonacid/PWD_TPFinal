<?php
include_once('../Conector.php');
class CompraEstadoTipo{
    //atributos
    private $idCompraEstadoTipo;
    private $cetDescripcion;
    private $cetDetalle;
    private $mensaje;

    //constructor
    public function __construct()
    {
        $this->idCompraEstadoTipo=null;
        $this->cetDescripcion="";
        $this->cetDetalle="";
        $this->mensaje="";
    }

    //métodos de acceso
    public function getIdCompraEstadoTipo(){
        return $this->idCompraEstadoTipo;
    }
    public function setIdCompraEstadoTipo($id){
        $this->idCompraEstadoTipo=$id;
    }

    public function getCetDescripcion(){
        return $this->cetDescripcion;
    }
    public function setCetDescripcion($descripcion){
        $this->cetDescripcion=$descripcion;
    }

    public function getCetDetalle(){
        return $this->cetDetalle;
    }
    public function setCetDetalle($detalle){
        $this->cetDetalle=$detalle;
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
        $compra="ID compra estado tipo: ".$this->getIdCompraEstadoTipo()."\n";
        $compra.="Descripcion: ".$this->getCetDescripcion()."\n";
        $compra.="Detalle: ".$this->getCetDetalle()."\n";
        return $compra;
    }

    //cargar compra estado tipo
    public function cargar($detalle, $descripcion){
        $this->setCetDetalle($detalle);
        $this->setCetDescripcion($descripcion);
    }

    //buscar una compra estado por id
    public function buscar($id){
        $respuesta=false;
        $base=new BaseDatos();
        $consulta="SELECT * FROM compraestadotipo WHERE idcompraestadotipo=".$id.";";
            if($base->Iniciar()){
                if($base->Ejecutar($consulta)){
                    $row=$base->Registro();
                    if($row){
                        $respuesta=true;
                        $objUsuario=new Usuario();
                        $objUsuario->buscar($row['idusuario']);  
                        $this->setIdCompra($row['idcompra']);
                        $this->setFecha($row['cofecha']);
                        $this->setobjUsuario($objUsuario);
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
    public function listar(){
        $base=new BaseDatos();
        $consulta="SELECT * FROM compra;";
        $arregloCompras=[];
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $row=$base->Registro();
                if($row){
                    do{
                        $objCompra=new Compra();
                        $objCompra->cargar($row['idusuario']);  
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