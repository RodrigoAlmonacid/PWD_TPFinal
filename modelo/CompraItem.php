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
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
    //cargar los objetos rol y menu
    public function cargar($idCompra, $idrol){
        $objRol=new Rol();
        $objRol->buscar($idrol);
        $this->setObjRol($objRol);
        $objCompra=new Compra();
        $objCompra->buscar($idCompra);
        $this->setObjCompra($objCompra);
    }

    //buscar un roles por id Menu o por id rol, mando el parámetro correspondiente
    public function buscar($params){
        $where = "TRUE";
        $respuesta=false;
        $arreglo=[
            'rol'=>"",
            'menu'=>"",
            'respuesta'=>$respuesta
        ];
        if ($params['idmenu']){
            $where .= " AND idmenu = ". $params['idmenu'];
            $objMenu=new Menu();
            $objMenu->buscar($params['idmenu']);
            $arreglo['menu']=$objMenu;
        };
        if ($params['idrol']){
            $where .= " AND idrol = ". $params['idrol'];
            $objRol=new Rol();
            $objRol->buscar($params['idrol']);
            $arreglo['rol']=$objRol;
        };
        $base=new BaseDatos();
        $consulta="SELECT * FROM menurol WHERE $where;";
            if($base->Iniciar()){
                if($base->Ejecutar($consulta)){
                    $row=$base->Registro();
                    if($row){
                        $respuesta=true;
                        if($params['idrol']){
                            $arregloMenu=[];
                            do{
                                $objMenu=new Menu();
                                $objMenu->buscar($row['idmenu']);  
                                array_push($arregloMenu, $objMenu);
                            }while($row = $base->Registro());
                            $arreglo['menu']=$arregloMenu;
                        }
                        if($params['idmenu']){
                            $arregloRol=[];
                            do{
                                $objRol=new Rol();
                                $objRol->buscar($row['idrol']);  
                                array_push($arregloRol, $objRol);
                            }while($row = $base->Registro());
                            $arreglo['rol']=$arregloRol;
                        } 
                    }
                }
                else {
                    $this->setMensaje("menurol->buscar: " . $base->getError());
                }
            }
            else {
                $this->setMensaje("menurol->buscar: " . $base->getError());
            }
        return $arreglo;
    }

    /** funcion para listar todos los Menus y sus roles
     * @return array
     * */
    public function listar(){
        $base=new BaseDatos();
        $consulta="SELECT * FROM menurol ORDER BY idrol;";
        $arregloMenuRol=[];
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $row=$base->Registro();
                if($row){
                    do{
                        $objMenuRol=new MenuRol();
                        $objMenuRol->cargar($row['idmenu'], $row['idrol']);  
                        array_push($arregloMenuRol, $objMenuRol);
                    }while($row = $base->Registro());
                }
            }
            else {
                $this->setMensaje("menurol->listar: " . $base->getError());
            }
        }
        else {
            $this->setMensaje("menurol->listar: " . $base->getError());
        }
        return $arregloMenuRol;
    }

    /** funcion que me permite insertar un menurol
     * @return bool
     */
    public function insertar(){
        $agrega=false;
        $base=new BaseDatos();
        $objRol=$this->getObjRol();
        $objMenu=$this->getObjMenu();
        $consulta="INSERT INTO Menurol(idMenu, idrol) VALUES";
        $consulta.="(".$objMenu->getIdMenu().", ".$objRol->getId_rol().");";
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $agrega=true;
            }
            else {
                $this->setMensaje("menurol->insertar: " . $base->getError());
            } 	
        }
        else {
            $this->setMensaje("menurol->insertar: " . $base->getError());
        }
        return $agrega;   
    }

    /** Funcion que me permite modificar un rol dentro de un Menu
     * @return bool
     */
    public function modificar(){
        $base=new BaseDatos();
        $objRol=$this->getObjRol();
        $objMenu=$this->getObjMenu();
        $modifica=false;
        $consulta="UPDATE menurol SET ";
        $consulta.="idrol=".$objRol->getId_rol();
        $consulta.=" AND idmenu=".$objMenu->getIdMenu();
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