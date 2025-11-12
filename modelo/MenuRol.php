<?php
include_once('Menu.php');
include_once('Rol.php');
class MenuRol{
    //atributos
    private Menu $objMenu; //referencia a un objeto Menu
    private Rol $objRol; //referencia a un objeto rol
    private $mensaje;

    //constructor
    public function __construct()
    {
        $this->objMenu=new Menu();
        $this->objRol=new Rol();
        $this->mensaje="";
    }

    //métodos de acceso
    public function getObjMenu(){
        return $this->objMenu;
    }
    public function setobjMenu($objeto){
        $this->objMenu=$objeto;
    }

    public function getobjRol(){
        return $this->objRol;
    }
    public function setObjRol($rol){
        $this->objRol=$rol;
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
        $menuRol="Menu: ".$this->getObjMenu()."\n";
        $menuRol.="Rol: ".$this->getobjRol()."\n";
        return $menuRol;
    }

    //cargar los objetos rol y menu
    public function cargar($idMenu, $idrol){
        $objRol=new Rol();
        $objRol->buscar($idrol);
        $this->setObjRol($objRol);
        $objMenu=new Menu();
        $objMenu->buscar($idMenu);
        $this->setObjMenu($objMenu);
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
        $consulta="INSERT INTO menurol(idmenu, idrol) VALUES";
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