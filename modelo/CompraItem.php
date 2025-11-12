<?php
include_once('Compra.php');
include_once('Producto.php');
class CompraItem{
    //atributos
    private $idCompraItem;
    private Compra $objCompra; //referencia a un objeto Compra
    private Producto $objProducto; //referencia a un objeto producto
    private $cantidad;
    private $mensaje;

    //constructor
    public function __construct()
    {
        $this->idCompraItem=null;
        $this->objCompra=new Compra();
        $this->objProducto=new Producto();
        $this->cantidad=0;
        $this->mensaje="";
    }

    //métodos de acceso
    public function getIdCompraItem(){
        return $this->idCompraItem;
    }
    public function setIdCompraItem($id){
        $this->idCompraItem=$id;
    }

    public function getObjCompra(){
        return $this->objCompra;
    }
    public function setobjCompra($objeto){
        $this->objCompra=$objeto;
    }

    public function getobjProducto(){
        return $this->objProducto;
    }
    public function setObjProducto($producto){
        $this->objProducto=$producto;
    }

    public function getCantidad(){
        return $this->cantidad;
    }
    public function setCantidad($cantidad){
        $this->cantidad=$cantidad;
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

    /** Funcion que me permite modificar un rol dentro de un Menu
     * @return bool
     */
    public function modificar(){
        $base=new BaseDatos();
        $objProducto=$this->getobjProducto();
        $objCompra=$this->getObjCompra();
        $modifica=false;
        $consulta="UPDATE compraitem SET ";
        $consulta.="idcompra=".$objCompra->getIdCompra();
        $consulta.=" AND idproducto=".$objCompra->getIdCompra();
        $consulta.=" WHERE idmenu=".$objMenu->getIdMenu().";";        
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
            $modifica=true;
            }
            else {
                $this->setMensaje("mrnurol->modificar: " . $base->getError());
            }
        }
        else {
            $this->setMensaje("mrnurol->modificar: " . $base->getError());
        }
        return $modifica;
    }

    /** funcion que me permite eliminar un rol
     * @return bool
     */
    public function eliminar(){
        $base=new BaseDatos();
        $elimina=false;
        $objRol=$this->getObjRol();
        $objMenu=$this->getObjMenu();
        $consulta="DELETE FROM menurol WHERE idrol=".$objRol->getId_rol()." AND idmenu=".$objMenu->getIdMenu().";";
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $elimina=true;
            }
            else {
                $this->setMensaje("menurol->eliminar: " . $base->getError());
            } 	
        }
        else {
            $this->setMensaje("menurol->eliminar: " . $base->getError());
        }
        return $elimina;
    }
}
?>