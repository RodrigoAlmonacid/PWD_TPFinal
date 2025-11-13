<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');
include_once('conector/conector.php');
include_once('Compra.php');
include_once('Producto.php');
class CompraEstado{
    //atributos
    private $idCompraEstado;
    private Compra $objCompra; //referencia a un objeto Compra
    private CompraEstadoTipo $objCompraEstadoTipo; //referencia a un objeto producto
    private $fechaIni;
    private $fechaFin;
    private $mensaje;

    //constructor
    public function __construct()
    {
        $this->idCompraEstado=null;
        $this->objCompra=new Compra();
        $this->objCompraEstadoTipo=new CompraEstadoTipo();
        $this->fechaIni=date('Y-m-d H:i:s');;
        $this->fechaFin=null;
        $this->mensaje="";
    }

    //métodos de acceso
    public function getIdCompraEstado(){
        return $this->idCompraEstado;
    }
    public function setIdCompraItem($id){
        $this->idCompraEstado=$id;
    }

    public function getObjCompra(){
        return $this->objCompra;
    }
    public function setobjCompra($objeto){
        $this->objCompra=$objeto;
    }

    public function getobjCompraEstadoTipo(){
        return $this->objCompraEstadoTipo;
    }
    public function setObjCompraEstadoTipo($compraEstadoTipo){
        $this->objCompraEstadoTipo=$compraEstadoTipo;
    }

    public function getFechaIni(){
        return $this->fechaIni;
    }
    public function setFechaIni($fecha){
        $this->fechaIni=$fecha;
    }

    public function getFechaFin(){
        return $this->fechaFin;
    }
    public function setFechaFin($fecha){
        $this->fechaIni=$fecha;
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
        $compraItem="ID: ".$this->getIdCompraItem()."\n";
        $compraItem="Producto: ".$this->getobjProducto()."\n";
        $compraItem.="Compra: ".$this->getObjCompra()."\n";
        $compraItem="Cantidad de productos: ".$this->getCantidad()."\n";
        return $compraItem;
    }

    //cargar los objetos compra y producto, y la cantidad de ese producto
    public function cargar($idCompra, $idProducto, $cantidad){
        $objProducto=new Producto();
        $objProducto->buscar($idProducto);
        $this->setObjProducto($objProducto);
        $objCompra=new Compra();
        $objCompra->buscar($idCompra);
        $this->setObjCompra($objCompra);
        $this->setCantidad($cantidad);
    }

    //buscar detalle de un item
    public function buscar($id){
        $respuesta=false;
        $base=new BaseDatos();
        $consulta="SELECT * FROM compraitem WHERE idcompraitem=".$id.";";
            if($base->Iniciar()){
                if($base->Ejecutar($consulta)){
                    $row=$base->Registro();
                    if($row){
                        $respuesta=true;
                        $this->setIdCompraItem($row['idcompraitem']);
                        $objProducto=new Producto();
                        $objProducto->buscar($row['idprodudcto']);
                        $this->setObjProducto($objProducto);
                        $this->setCantidad($row['cantidad']);
                        $objCompra=new Compra();
                        $objCompra->buscar($row['idcompra']);
                        $this->setObjCompra($objCompra);
                        }
                    }
                else{
                    $this->setMensaje("compraItem->buscar: " . $base->getError());
                }
            }
            else {
                $this->setMensaje("compraItem->buscar: " . $base->getError());
            }
        return $respuesta;
    }

    /** funcion para listar todos productos comprados
     * @return array
     * */
    public function listar(){
        $base=new BaseDatos();
        $consulta="SELECT * FROM compraitem;";
        $arregloCompraItem=[];
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $row=$base->Registro();
                if($row){
                    do{
                        $objCompraItem=new CompraItem();
                        $objCompraItem->buscar($row['idcompraitem']);  
                        array_push($arregloCompraItem, $objCompraItem);
                    }while($row = $base->Registro());
                }
            }
            else {
                $this->setMensaje("compraItem->listar: " . $base->getError());
            }
        }
        else {
            $this->setMensaje("compraItem->listar: " . $base->getError());
        }
        return $arregloCompraItem;
    }

    /** funcion que me permite insertar un registro
     * @return bool
     */
    public function insertar(){
        $agrega=false;
        $base=new BaseDatos();
        $objProducto=$this->getobjProducto();
        $objCompra=$this->getObjCompra();
        $consulta="INSERT INTO compraitem(idproducto, idcompra, cicantidad) VALUES";
        $consulta.="(".$objProducto->getIdProducto().", ".$objCompra->getIdCompra().", ".$this->getCantidad().");";
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $agrega=true;
            }
            else {
                $this->setMensaje("copraitem->insertar: " . $base->getError());
            } 	
        }
        else {
            $this->setMensaje("compraitem->insertar: " . $base->getError());
        }
        return $agrega;   
    }

    /** Funcion que me permite modificar una compraitem
     * @return bool
     */
    public function modificar(){
        $base=new BaseDatos();
        $objProducto=$this->getobjProducto();
        $objCompra=$this->getObjCompra();
        $modifica=false;
        $consulta="UPDATE compraitem SET ";
        $consulta.="idcompra=".$objCompra->getIdCompra();
        $consulta.=", idproducto=".$objCompra->getIdCompra();
        $consulta.=", cantidad=".$this->getCantidad();
        $consulta.=" WHERE idcompraitem=".$this->getIdCompraItem().";";        
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
            $modifica=true;
            }
            else {
                $this->setMensaje("compraitem->modificar: " . $base->getError());
            }
        }
        else {
            $this->setMensaje("compraitem->modificar: " . $base->getError());
        }
        return $modifica;
    }

    /** funcion que me permite eliminar un compraitem
     * @return bool
     */
    public function eliminar(){
        $base=new BaseDatos();
        $elimina=false;
        $consulta="DELETE FROM compraitem WHERE idcompraitem=".$this->getIdCompraItem().";";
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $elimina=true;
            }
            else {
                $this->setMensaje("compraitem->eliminar: " . $base->getError());
            } 	
        }
        else {
            $this->setMensaje("compraitem->eliminar: " . $base->getError());
        }
        return $elimina;
    }
}
?>