<?php
include_once('conector/conector.php');
include_once('Usuario.php');
include_once('Rol.php');
class UsuarioRol{
    //atributos
    private Usuario $objUsuario; //referencia a un objeto usuario
    private Rol $objRol; //referencia a un objeto rol
    private $mensaje;

    //constructor
    public function __construct()
    {
        $this->objUsuario=new Usuario();
        $this->objRol=new Rol();
        $this->mensaje="";
    }

    //métodos de acceso
    public function getObjUsuario(){
        return $this->objUsuario;
    }
    public function setobjUsuario($objeto){
        $this->objUsuario=$objeto;
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
        $usuarioRol="Usuario: ".$this->getObjUsuario()."\n";
        $usuarioRol.="Rol: ".$this->getobjRol()."\n";
        return $usuarioRol;
    }

    //cargar los objetos rol
    public function cargar($idusuario, $idrol){
        $objRol=new Rol();
        $objRol->buscar($idrol);
        $this->setObjRol($objRol);
        $objUsuario=new Usuario();
        $objUsuario->buscar($idusuario);
        $this->setObjUsuario($objUsuario);
    }

    //buscar un roles por id usuario o por id rol, mando el parámetro correspondiente
    public function buscar($params){
        $where = "TRUE";
        $respuesta=false;
        $arreglo=[
            'rol'=>"",
            'usuario'=>"",
            'respuesta'=>$respuesta
        ];
        if ($params['idusuario']){
            $where .= " AND idusuario = ". $params['idusuario'];
            $objUsuario=new Usuario();
            $objUsuario->buscar($params['idusuario']);
            $arreglo['usuario']=$objUsuario;
        };
        if ($params['idrol']){
            $where .= " AND idrol = ". $params['idrol'];
            $objRol=new Rol();
            $objRol->buscar($params['idrol']);
            $arreglo['rol']=$objRol;
        };
        $base=new BaseDatos();
        $consulta="SELECT * FROM usuariorol WHERE $where;";
            if($base->Iniciar()){
                if($base->Ejecutar($consulta)){
                    $row=$base->Registro();
                    if($row){
                        $respuesta=true;
                        if($params['idrol']){
                            $arregloUsuario=[];
                            do{
                                $objUsuario=new Usuario();
                                $objUsuario->buscar($row['idusuario']);  
                                array_push($arregloUsuario, $objUsuario);
                            }while($row = $base->Registro());
                            $arreglo['usuario']=$arregloUsuario;
                        }
                        if($params['idusuario']){
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
                    $this->setMensaje("usuariorol->buscar: " . $base->getError());
                }
            }
            else {
                $this->setMensaje("usuariorol->buscar: " . $base->getError());
            }
        return $arreglo;
    }

    /** funcion para listar todos los usuarios y sus roles
     * @return array
     * */
    public function listar($param){
        $base=new BaseDatos();
        $consulta="SELECT * FROM usuariorol WHERE $param ORDER BY idusuario;";
        $arregloUsuarioRol=[];
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $row=$base->Registro();
                if($row){
                    do{
                        $objUsuarioRol=new UsuarioRol();
                        $objUsuarioRol->cargar($row['idusuario'], $row['idrol']);  
                        array_push($arregloUsuarioRol, $objUsuarioRol);
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
        return $arregloUsuarioRol;
    }

    /** funcion que me permite insertar un rol
     * @return bool
     */
    public function insertar(){
        $agrega=false;
        $base=new BaseDatos();
        $objRol=$this->getObjRol();
        $objUsuario=$this->getObjUsuario();
        $consulta="INSERT INTO usuariorol(idusuario, idrol) VALUES";
        $consulta.="(".$objUsuario->getId_usuario().", ".$objRol->getId_rol().");";
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $agrega=true;
            }
            else {
                $this->setMensaje("usuariorol->insertar: " . $base->getError());
            } 	
        }
        else {
            $this->setMensaje("uauriorol->insertar: " . $base->getError());
        }
        return $agrega;   
    }

    /** Funcion que me permite modificar un rol de un usuario
     * @return bool
     */
    public function modificar(){
        $base=new BaseDatos();
        $objRol=$this->getObjRol();
        $objUsuario=$this->getObjUsuario();
        $modifica=false;
        $consulta="UPDATE usuariorol SET ";
        $consulta.="idrol=".$objRol->getId_rol();
        $consulta.=" AND idusuario=".$objUsuario->getId_usuario();
        $consulta.=" WHERE idusuario=".$objUsuario->getId_usuario().";";        
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
            $modifica=true;
            }
            else {
                $this->setMensaje("usuariorol->modificar: " . $base->getError());
            }
        }
        else {
            $this->setMensaje("usuariorol->modificar: " . $base->getError());
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
        $objUsuario=$this->getObjUsuario();
        $consulta="DELETE FROM usuariorol WHERE idrol=".$objRol->getId_rol()." AND idusuario=".$objUsuario->getId_usuario().";";
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $elimina=true;
            }
            else {
                $this->setMensaje("usuariorol->eliminar: " . $base->getError());
            } 	
        }
        else {
            $this->setMensaje("usuariorol->eliminar: " . $base->getError());
        }
        return $elimina;
    }
}
?>