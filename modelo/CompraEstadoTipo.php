<?php
include_once('conector/conector.php');
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
                        $this->setIdCompraEstadoTipo($id);
                        $this->setCetDescripcion($row['cetdescripcion']);
                        $this->setCetDetalle($row['cetdetalle']);
                    }
                }
                else {
                    $this->setMensaje("compraestadotipo->buscar: " . $base->getError());
                }
            }
            else {
                $this->setMensaje("compraestadotipo->buscar: " . $base->getError());
            }
        return $respuesta;
    }

    /** funcion para listar todas la compras
     * @return array
     * */
    public function listar($where){
        $base=new BaseDatos();
        $consulta="SELECT * FROM compraestadotipo WHERE $where;";
        $arregloComprasET=[];
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $row=$base->Registro();
                if($row){
                    do{
                        $objCompraET=new CompraEstadoTipo();
                        $objCompraET->buscar($row['idcompraestadotipo']);  
                        array_push($arregloComprasET, $objCompraET);
                    }while($row = $base->Registro());
                }
            }
            else {
                $this->setMensaje("compraestadotipo->listar: " . $base->getError());
            }
        }
        else {
            $this->setMensaje("compraestadotipo->listar: " . $base->getError());
        }
        return $arregloComprasET;
    }

    /** funcion que me permite insertar una compra ET
     * @return bool
     */
    public function insertar(){
        $agrega=false;
        $base=new BaseDatos();
        $consulta="INSERT INTO compraestadotipo(cetdescripcion, cetdetalle) VALUES";
        $consulta.="('".$this->getCetDescripcion()."', '".$this->getCetDetalle()."');";
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $agrega=true;
            }
            else {
                $this->setMensaje("compraestadotipo->insertar: " . $base->getError());
            } 	
        }
        else {
            $this->setMensaje("compraestadotipo->insertar: " . $base->getError());
        }
        return $agrega;   
    }

    /** Funcion que me permite modificar una compra ET
     * @return bool
     */
    public function modificar(){
        $base=new BaseDatos();
        $modifica=false;
        $consulta="UPDATE compraestadotipo SET ";
        $consulta.="idcompraestadotipo=".$this->getIdCompraEstadoTipo();
        $consulta.=", cetdetalle=".$this->getCetDetalle();
        $consulta.=", cetdescripcion='".$this->getCetDescripcion();
        $consulta.="' WHERE idcompraestadotipo=".$this->getIdCompraEstadoTipo().";";        
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
            $modifica=true;
            }
            else {
                $this->setMensaje("compraestadotipo->modificar: " . $base->getError());
            }
        }
        else {
            $this->setMensaje("compraestadotipo->modificar: " . $base->getError());
        }
        return $modifica;
    }

    /** funcion que me permite eliminar una compra ET
     * @return bool
     */
    public function eliminar(){
        $base=new BaseDatos();
        $elimina=false;
        $consulta="DELETE FROM compraestadotipo WHERE idcompraestadotipo=".$this->getIdCompraEstadoTipo().";";
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $elimina=true;
            }
            else {
                $this->setMensaje("compraestadotipo->eliminar: " . $base->getError());
            } 	
        }
        else {
            $this->setMensaje("compraestadotipo->eliminar: " . $base->getError());
        }
        return $elimina;
    }
}
?>