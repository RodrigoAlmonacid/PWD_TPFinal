<?php
include_once('Usuario.php');
include_once('Rol.php');
class UsuarioRol{
    //atributos
    private $colUsuario; //referencia a Usuario
    private $colRol; //refrencia a Rol
    private Usuario $objUsuario; //cuando tengo un solo objeto
    private $mensaje;

    //constructor
    public function __construct()
    {
        $this->colUsuario=null;
        $this->colRol=null;
        $this->mensaje="";
    }

    //métodos de acceso
    public function getColUsuario(){
        return $this->colUsuario;
    }
    public function setColUsuario($arreglo){
        $this->colUsuario=$arreglo;
    }

    public function getColRol(){
        return $this->colRol;
    }
    public function setColRol($arreglo){
        $this->colRol=$arreglo;
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
        $arregloUsuario=$this->getColUsuario();
        $arregloRol=$this->getColRol();
        //ver como recorrer los arreglos sin perder la relación
        return $arregloUsuario;
    }

    //cargar los objetos rol
    public function cargar($idrol, $idusuario){
        $objRol=new Rol();
        $objRol->buscar($idrol);
        $this->setColRol($objRol);
        $objUsuario=new Usuario();
        $objUsuario->buscar($idusuario);
        $this->setColUsuario($objUsuario);
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
                    $this->setMensaje("rol->buscar: " . $base->getError());
                }
            }
            else {
                $this->setMensaje("rol->buscar: " . $base->getError());
            }
        return $arreglo;
    }

    /** funcion para listar todos los roles
     * @return array
     * */
    public function listar(){
        $base=new BaseDatos();
        $consulta="SELECT * FROM usuariorol;";
        $arregloRol=[];
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $row=$base->Registro();
                if($row){
                    do{
                        $objRol=new Rol();
                        $objRol->setId_rol($row['id_rol']);
                        $objRol->setDescripcion_rol($row['descripcion_rol']);  
                        array_push($arregloRol, $objRol);
                    }while($row = $base->Registro());
                }
            }
            else {
                $this->setMensaje("rol->listar: " . $base->getError());
            }
        }
        else {
            $this->setMensaje("rol->listar: " . $base->getError());
        }
        return $arregloRol;
    }

    /** funcion que me permite insertar un rol
     * @return bool
     */
    public function insertar(){
        $agrega=false;
        $base=new BaseDatos();
        $objRol=$this->getColRol();
        $objUsuario=$this->getColUsuario();
        $consulta="INSERT INTO usuariorol(idusuario, idrol) VALUES";
        $consulta.="(".$objUsuario->getId_usuario().", ".$objRol->getId_rol().");";
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $agrega=true;
            }
            else {
                $this->setMensaje("rol->insertar: " . $base->getError());
            } 	
        }
        else {
            $this->setMensaje("rol->insertar: " . $base->getError());
        }
        return $agrega;   
    }

    /** Funcion que me permite modificar un rol de un usuario
     * @return bool
     */
    public function modificar(){
        $base=new BaseDatos();
        $objRol=$this->getColRol();
        $objUsuario=$this->getColUsuario();
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
                $this->setMensaje("rol->modificar: " . $base->getError());
            }
        }
        else {
            $this->setMensaje("rol->modificar: " . $base->getError());
        }
        return $modifica;
    }

    /** funcion que me permite eliminar un rol
     * @return bool
     */
    public function eliminar(){
        $base=new BaseDatos();
        $elimina=false;
        $objRol=$this->getColRol();
        $objUsuario=$this->getColUsuario();
        $consulta="DELETE FROM usuariorol WHERE idrol=".$objRol->getId_rol()." AND idusuario=".$objUsuario->getId_usuario().";";
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $elimina=true;
            }
            else {
                $this->setMensaje("usuario->eliminar: " . $base->getError());
            } 	
        }
        else {
            $this->setMensaje("usuario->eliminar: " . $base->getError());
        }
        return $elimina;
    }
}
?>