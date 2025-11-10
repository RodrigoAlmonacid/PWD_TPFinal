<?php
include_once('Usuario.php');
include_once('Rol.php');
class UsuarioRol{
    //atributos
    private $colUsuario; //coleccion de usuarios
    private $colRol; //coleccion de roles
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

    //buscar un roles por id usuario o por id rol, mando el parámetro correspondiente
    public function buscar($params){
        $where = "TRUE";
        $respuesta=false;
        $arreglo=[];
        $arreglo['respuesta']=$respuesta;
        if ($params['id_usuario']){
            $where .= " AND id_usuario = ". $params['id_usuario'];
            $objUsuario=new Usuario();
            $objUsuario->buscar($params['id_usuario']);
            $arreglo['usuario']=$objUsuario;
        };
        if ($params['id_rol']){
            $where .= " AND id_rol = ". $params['id_rol'];
            $objRol=new Rol();
            $objRol->buscar($params['id_rol']);
            $arreglo['rol']=$objRol;
        };
        $base=new BaseDatos();
        $consulta="SELECT * FROM usuariorol WHERE $where;";
            if($base->Iniciar()){
                if($base->Ejecutar($consulta)){
                    $row=$base->Registro();
                    if($row){
                        $respuesta=true;
                        if()
                        do{ //Continuar arreglando según la consulta  <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
                        $objUsuario=new Usuario();
                        $objUsuario->setId_usuario($row['id_usuario']);
                        $objUsuario->setNom_usuario($row['nom_usuario']);
                        $objUsuario->setEmail_usuario($row['email_usuario']);
                        $objUsuario->setDesHabilitado_usuario($row['desHabilitado_usuario']);  
                        array_push($arregloUsuario, $objUsuario);
                    }while($row = $base->Registro()); 
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
        $consulta="SELECT * FROM rol;";
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
        $consulta="INSERT INTO rol (descripcion_rol) VALUES";
        $consulta.="('".$this->getDescripcion_rol()."');";
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

    /** Funcion que me permite modificar un rol
     * @return bool
     */
    public function modificar(){
        $base=new BaseDatos();
        $modifica=false;
        $consulta="UPDATE rol SET ";
        $consulta.="descripcion_rol='".$this->getDescripcion_rol();
        $consulta.="' WHERE id_rol=".$this->getId_rol().";";        
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
        $consulta="DELETE FROM rol WHERE id_rol=".$this->getId_rol().";";
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