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
        $this->fechaIni=date('Y-m-d H:i:s');
        $this->fechaFin=null;
        $this->mensaje="";
    }

    //métodos de acceso
    public function getIdCompraEstado(){
        return $this->idCompraEstado;
    }
    public function setIdCompraEstado($id){
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
        $compraEstado="ID: ".$this->getIdCompraEstado()."\n";
        $compraEstado="Compra: ".$this->getObjCompra()."\n";
        $compraEstado="CompraEstadoTipo: ".$this->getobjCompraEstadoTipo()."\n";
        $compraEstado.="Fecha Inicio: ".$this->getFechaIni()."\n";
        $compraEstado="Fecha Fin: ".$this->getFechaFin()."\n";
        return $compraEstado;
    }

    //cargar los datos
    public function cargar($idCompraEstado, $idCompra, $idCompraEstadoTipo, $fechaIni, $fechaFin){
        $objCompraEstadoTipo=new CompraEstadoTipo();
        $objCompraEstadoTipo->buscar($idCompraEstadoTipo);
        $this->setObjCompraEstadoTipo($objCompraEstadoTipo);
        $objCompra=new Compra();
        $objCompra->buscar($idCompra);
        $this->setObjCompra($objCompra);
        $this->setIdCompraEstado($idCompraEstado);
        $this->setFechaIni($fechaIni);
        $this->setFechaFin($fechaFin);
    }

    //buscar detalle de un item
    public function buscar($id){
        $respuesta=false;
        $base=new BaseDatos();
        $consulta="SELECT * FROM compraestado WHERE idcompraestado=".$id.";";
            if($base->Iniciar()){
                if($base->Ejecutar($consulta)){
                    $row=$base->Registro();
                    if($row){
                        $respuesta=true;
                        $this->setIdCompraEstado($id);
                        $objCompraEstadoTipo=new CompraEstadoTipo();
                        $objCompraEstadoTipo->buscar($row['idcompraestadotipo']);
                        $this->setObjCompraEstadoTipo($objCompraEstadoTipo);
                        $this->setFechaIni($row['cefechaini']);
                        $this->setFechaFin($row['cefechafin']);
                        $objCompra=new Compra();
                        $objCompra->buscar($row['idcompra']);
                        $this->setObjCompra($objCompra);
                        }
                    }
                else{
                    $this->setMensaje("compraestado->buscar: " . $base->getError());
                }
            }
            else {
                $this->setMensaje("compraestado->buscar: " . $base->getError());
            }
        return $respuesta;
    }

    /** funcion para listar todos productos comprados
     * @return array
     * */
    public function listar($where){
        $base=new BaseDatos();
        $consulta="SELECT * FROM compraestado WHERE $where;";
        $arregloCompraEstado=[];
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $row=$base->Registro();
                if($row){
                    do{
                        $objCompraEstado=new CompraEstado();
                        $objCompraEstado->buscar($row['idcompraestado']);  
                        array_push($arregloCompraEstado, $objCompraEstado);
                    }while($row = $base->Registro());
                }
            }
            else {
                $this->setMensaje("compraestado->listar: " . $base->getError());
            }
        }
        else {
            $this->setMensaje("compraestado->listar: " . $base->getError());
        }
        return $arregloCompraEstado;
    }

    /** funcion que me permite insertar un registro
     * @return bool
     */
    public function insertar(){
        $agrega=false;
        $base=new BaseDatos();
        $objCompraEstadoTipo=$this->getobjCompraEstadoTipo();
        $objCompra=$this->getObjCompra();
        $consulta="INSERT INTO compraestado(idcompraestadotipo, idcompra, cefechaini, cefechafin) VALUES";
        $consulta.="(".$objCompraEstadoTipo->getIdCompraEstadoTipo().", ".$objCompra->getIdCompra().", '".$this->getFechaIni()."', '".$this->getFechaFin()."');";
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $agrega=true;
            }
            else {
                $this->setMensaje("compraestado->insertar: " . $base->getError());
            } 	
        }
        else {
            $this->setMensaje("compraestado->insertar: " . $base->getError());
        }
        return $agrega;   
    }

    /** Funcion que me permite modificar una compraEstado
     * @return bool
     */
    public function modificar(){
        $base=new BaseDatos();
        $objCompraEstadoTipo=$this->getobjCompraEstadoTipo();
        $objCompra=$this->getObjCompra();
        $modifica=false;
        $consulta="UPDATE compraestado SET ";
        $consulta.="idcompra=".$objCompra->getIdCompra();
        $consulta.=", idcompraestadotipo=".$objCompraEstadoTipo->getIdCompraEstadoTipo();
        $consulta.=", cefechaini=".$this->getFechaIni();
        $consulta.=", cefechafin=".$this->getFechaFin();
        $consulta.=" WHERE idcompraestado=".$this->getIdCompraEstado().";";        
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
            $modifica=true;
            }
            else {
                $this->setMensaje("compraestado->modificar: " . $base->getError());
            }
        }
        else {
            $this->setMensaje("compraestado->modificar: " . $base->getError());
        }
        return $modifica;
    }

    /** funcion que me permite eliminar un compraestado
     * @return bool
     */
    public function eliminar(){
        $base=new BaseDatos();
        $elimina=false;
        $consulta="DELETE FROM compraestado WHERE idcompraitem=".$this->getIdCompraEstado().";";
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $elimina=true;
            }
            else {
                $this->setMensaje("compraestado->eliminar: " . $base->getError());
            } 	
        }
        else {
            $this->setMensaje("compraestado->eliminar: " . $base->getError());
        }
        return $elimina;
    }
}
?>