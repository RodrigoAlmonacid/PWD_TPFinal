<?php
include_once('conector/conector.php');
date_default_timezone_set('America/Argentina/Buenos_Aires');
class Usuario{
    //atributos
    private $id_usuario;
    private $nom_usuario;
    private $pass_usuario;
    private $email_usuario;
    private $desHabilitado_usuario;
    private $mensaje;

    public function __construct()
    {
        $this->id_usuario=null;
        $this->nom_usuario="";
        $this->pass_usuario="";
        $this->email_usuario="";
        $this->desHabilitado_usuario=date('Y-m-d H:i:s');
        $this->mensaje=null;
    }
    
    //Métodos de acceso
    public function getId_usuario(){
        return $this->id_usuario;
    }
    public function setId_usuario($id){
        $this->id_usuario=$id;
    }

    public function getNom_usuario(){
        return $this->nom_usuario;
    }
    public function setNom_usuario($nombre){
        $this->nom_usuario=$nombre;
    }

    public function getPass_usuario(){
        return $this->pass_usuario;
    }
    public function setPass_usuario($pass){
        $this->pass_usuario=$pass;
    }

    public function getEmail_usuario(){
        return $this->email_usuario;
    }
    public function setEmail_usuario($email){
        $this->email_usuario=$email;
    }

    public function getDesHabilitado_usuario(){
        return $this->desHabilitado_usuario;
    }
    public function setDesHabilitado_usuario($desHabilitado){
        $this->desHabilitado_usuario=$desHabilitado;
    }

    public function getMensaje(){
        return $this->mensaje;
    }
    public function setMensaje($mensaje){
        $this->mensaje=$mensaje;
    }

    //método toString
    public function __toString()
    {
        $usuario="ID: ".$this->getId_usuario()."\n";
        $usuario.="Nombre: ".$this->getNom_usuario()."\n";
        $usuario.="Email: ".$this->getEmail_usuario()."\n";
        $usuario.="Estado: ";
        $fecha=$this->getDesHabilitado_usuario();
        if($fecha){
            $usuario.="deshabilitado desde ".$fecha."\n";
        }
        else{
            $usuario.="habilitado.\n";
        }
        return $usuario;
    }

    //cargar usuario
    public function cargar($nombre, $email, $contraseña){
        $this->setNom_usuario($nombre);
        $this->setEmail_usuario($email);
        $this->setPass_usuario($contraseña);
    }

    //buscar un usuario por id
    public function buscar($id){
        $base=new BaseDatos();
        $consulta="SELECT * FROM usuario WHERE id_usuario=".$id.";";
        $respuesta=false;
        if($base->Iniciar()){
            if($base->Ejecutar($consulta)){
                $row=$base->Registro();
                if($row){
                    $respuesta=true;
                    $this->setId_usuario($row['id_usuario']);
                    $this->setNom_usuario($row['nom_usuario']);
                    $this->setEmail_usuario($row['email_usuario']);
                    $this->setDesHabilitado_usuario($row['desHabilitado_usuario']);    
                }
            }
            else {
                $this->setMensaje("usuario->buscar: " . $base->getError());
            }
        }
        else {
            $this->setMensaje("usuario->buscar: " . $base->getError());
        }
        return $respuesta;
    }

    /** funcion para listar todos los usuarios
     * @return array
     * */
    public function listar(){
        $base=new BaseDatos();
        $consulta="SELECT * FROM usuario;";
        $arregloUsuario=[];
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $row=$base->Registro();
                if($row){
                    do{
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
                $this->setMensaje("usuario->listar: " . $base->getError());
            }
        }
        else {
            $this->setMensaje("usuario->listar: " . $base->getError());
        }
        return $arregloUsuario;
    }

    /** funcion que me permite insertar un vehiculo
     * @return bool
     */
    public function insertar(){
        $agrega=false;
        $base=new BaseDatos();
        $consulta="INSERT INTO usuario (nom_usuario, pass_usuario, email_usuario, desHabilitado_usuario) VALUES";
        $consulta.="('".$this->getNom_usuario()."', '".$this->getPass_usuario()."', '".$this->getEmail_usuario()."', '".$this->getDesHabilitado_usuario()."');";
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $agrega=true;
            }
            else {
                $this->setMensaje("usuario->listar: " . $base->getError());
            } 	
        }
        else {
            $this->setMensaje("usuario->listar: " . $base->getError());
        }
        return $agrega;   
    }

    /** Funcion que me permite modificar un vehiculo
     * @return bool
     */
    public function modificar(){
        $base=new BaseDatos();
        $modifica=false;
        $consulta="UPDATE usuario SET ";
        $consulta.="nom_usuario='".$this->getNom_usuario()."', email_usuario='".$this->getEmail_usuario()."', desHabilitado_usuario='".$this->getDesHabilitado_usuario();
        $consulta.="' WHERE id_usuario=".$this->getId_usuario().";";        
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
            $modifica=true;
            }
            else {
                $this->setMensaje("usuario->modificar: " . $base->getError());
            }
        }
        else {
            $this->setMensaje("usuario->modificar: " . $base->getError());
        }
        return $modifica;
    }

    /** funcion que me permite eliminar un vehiculo
     * @param int $idVisita
     * @return bool
     */
    public function eliminar(){
        $base=new BaseDatos();
        $elimina=false;
        $consulta="DELETE FROM auto WHERE id_usuario='".$this->getId_usuario()."';";
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