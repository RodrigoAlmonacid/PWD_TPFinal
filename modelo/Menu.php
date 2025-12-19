<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');
include_once('conector/conector.php');
class Menu{
    //atributos
    private $idMenu;
    private $meNombre;
    private $meDescripcion;
    private $idPadre;
    private $meDeshabilitado;
    private $iconoBootstrap;
    private $mensaje;

    //constructor
    public function __construct()
    {
        $this->idMenu=null;
        $this->meNombre="";
        $this->meDescripcion="";
        $this->idPadre="";
        $this->meDeshabilitado=date('Y-m-d H:i:s');
        $this->mensaje="";
        $this->iconoBootstrap="";
    }

    //métodos de acceso
    public function getIdMenu(){
        return $this->idMenu;
    }
    public function setIdMenu($idMenu){
        $this->idMenu=$idMenu;
    }

    public function getMeNombre(){
        return $this->meNombre;
    }
    public function setMeNombre($meNombre){
        $this->meNombre=$meNombre;
    }

    public function getMeDescripcion(){
        return $this->meDescripcion;
    }
    public function setMeDescripcion($meDescripcion){
        $this->meDescripcion=$meDescripcion;
    }

    public function getIdPadre(){
        return $this->idPadre;
    }
    public function setIdPadre($idPadre){
        $this->idPadre=$idPadre;
    }

    public function getMeDeshabilitado(){
        return $this->meDeshabilitado;
    }
    public function setMeDeshabilitado($meDeshabilitado){
        $this->meDeshabilitado=$meDeshabilitado;
    }

    public function getMensaje(){
        return $this->mensaje;
    }
    public function setMensaje($mensaje){
        $this->mensaje=$mensaje;
    }

    public function getIconoBootstrap(){
        return $this->iconoBootstrap;
    }
    public function setIconoBootstrap($iconoBootstrap){
        $this->iconoBootstrap=$iconoBootstrap;
    }

    //metodo toString
    public function __toString()
    {
        $menu="ID: ".$this->getIdMenu()."\n";
        $menu.="Nombre: ".$this->getMeNombre()."\n";
        $menu.="Descripcion: ".$this->getMeDescripcion()."\n";
        $menu.="ID padre: ".$this->getIdPadre()."\n";
        $deshabilitado=$this->getMeDeshabilitado();
        if($deshabilitado){
            $menu.="Menú deshabilitado desde ".$deshabilitado."\n";
        }
        else{
            $menu.="Menú habilitado\n";
        }
        $menu.="Clase del icono de bootstrap: ".$this->getIconoBootstrap()."\n";
        return $menu;
    }

    //cargar menu
    public function cargar($nombre, $descripcion, $idPadre, $iconoBootstrap){
        $this->setMeNombre($nombre);
        $this->setMeDescripcion($descripcion);
        $this->setIdPadre($idPadre);
        $this->setIconoBootstrap($iconoBootstrap);
    }

    //buscar un menu por id
    public function buscar($id){
        $base=new BaseDatos();
        $consulta="SELECT * FROM menu WHERE idmenu=".$id.";";
        $respuesta=false;
        if($base->Iniciar()){
            if($base->Ejecutar($consulta)){
                $row=$base->Registro();
                if($row){
                    $respuesta=true;
                    $this->setIdMenu($row['idmenu']);
                    $this->setMeNombre($row['menombre']);
                    $this->setMeDescripcion($row['medescripcion']);
                    $this->setIdPadre($row['idpadre']);
                    $this->setMeDeshabilitado($row['medeshabilitado']);
                    $this->setIconoBootstrap($row['iconoBootstrap']);    
                }
            }
            else {
                $this->setMensaje("menu->buscar: " . $base->getError());
            }
        }
        else {
            $this->setMensaje("menu->buscar: " . $base->getError());
        }
        return $respuesta;
    }

    /** funcion para listar todos los menus
     * @return array
     * */
    public function listar(){
        $base=new BaseDatos();
        $consulta="SELECT * FROM menu;";
        $arregloMenu=[];
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $row=$base->Registro();
                if($row){
                    do{
                        $objMenu=new Menu();
                        $objMenu->setIdMenu($row['idmenu']);
                        $objMenu->setMeNombre($row['menombre']);
                        $objMenu->setMeDescripcion($row['medescripcion']);
                        $objMenu->setIdPadre($row['idpadre']);
                        $objMenu->setMeDeshabilitado($row['medeshabilitado']);
                        $objMenu->setIconoBootstrap($row['iconoBootstrap']);  
                        array_push($arregloMenu, $objMenu);
                    }while($row = $base->Registro());
                }
            }
            else {
                $this->setMensaje("menu->listar: " . $base->getError());
            }
        }
        else {
            $this->setMensaje("menu->listar: " . $base->getError());
        }
        return $arregloMenu;
    }

    /** funcion que me permite insertar un usuario
     * @return bool
     */
    public function insertar(){
        $agrega=false;
        $base=new BaseDatos();
        $consulta="INSERT INTO menu (menombre, medescripcion, idpadre, medeshabilitado) VALUES";
        $nombre = $this->getMeNombre();
        $descripcion=$this->getMeDescripcion();
        $idPadre=$this->getIdPadre();
        $deshabilitado=$this->getMeDeshabilitado();
        $consulta.="('$nombre', '$descripcion', ";
        if($idPadre==null || $idPadre=="null"){
            $consulta.=" NULL,";
        }
        else{
            $consulta.=$idPadre.",";
        }
        if($deshabilitado==null || $deshabilitado=="null"){
            $consulta.=" NULL);";
        }
        else{
            $consulta.=" '".$deshabilitado."');";
        }
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $agrega=true;
            }
            else {
                $this->setMensaje("usuario->insertar: " . $base->getError());
            } 	
        }
        else {
            $this->setMensaje("usuario->insertar: " . $base->getError());
        }
        return $agrega;   
    }

    /** Funcion que me permite modificar un menu
     * @return bool
     */
    public function modificar(){
        $base=new BaseDatos();
        $modifica=false;
        $consulta="UPDATE menu SET ";
        $consulta.="menombre='".$this->getMeNombre()."', medescripcion='".$this->getMeDescripcion();
        $des = $this->getMeDeshabilitado();
        if ($des === null || $des === "null" || $des === "Habilitado") {
            $consulta .= "', medeshabilitado=NULL";
        } else {
            $consulta .= "', medeshabilitado='".$des."'";
        }
        $consulta.=", iconoBootstrap= '".$this->getIconoBootstrap()."' WHERE idmenu=".$this->getIdMenu().";";        
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
            $modifica=true;
            }
            else {
                $this->setMensaje("menu->modificar: " . $base->getError());
            }
        }
        else {
            $this->setMensaje("menu->modificar: " . $base->getError());
        }
        return $modifica;
    }

    /** funcion que me permite eliminar un id menu
     * @return bool
     */
    public function eliminar(){
        $base=new BaseDatos();
        $elimina=false;
        $consulta="DELETE FROM menu WHERE idmenu=".$this->getIdMenu().";";
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $elimina=true;
            }
            else {
                $this->setMensaje("menu->eliminar: " . $base->getError());
            } 	
        }
        else {
            $this->setMensaje("menu->eliminar: " . $base->getError());
        }
        return $elimina;
    }
}
?>