<?php
    include_once('conector/conector.php');
    include_once('Usuario.php');
    include_once(__DIR__.'/../control/ABMUsuario.php');
    class PassReset{
        //atributos
        private $idPassReset;
        private Usuario $objUsuario;
        private $token;
        private $vencimiento;
        private $usado;
        private $mensaje;

        //constructor
        public function __construct()
        {
            $this->idPassReset=null;
            $this->objUsuario=new Usuario();
            $this->token="";
            $this->vencimiento="";
            $this->usado="";
            $this->mensaje="";
        }

        //metodos de acceso
        public function getIdPass(){
            return $this->idPassReset;
        }
        public function setIdPass($pass){
            $this->idPassReset=$pass;
        }

        public function getObjUsuario(){
            return $this->objUsuario;
        }
        public function setObjUsuario($usuario){
            $this->objUsuario=$usuario;
        }

        public function getToken(){
            return $this->token;
        }
        public function setToken($token){
            $this->token=$token;
        }

        public function getVencimiento(){
            return $this->vencimiento;
        }
        public function setVencimiento($vencimiento){
            $this->vencimiento=$vencimiento;
        }

        public function getUsado(){
            return $this->usado;
        }
        public function setUsado($usado){
            $this->usado=$usado;
        }

        public function getMensaje(){
            return $this->mensaje;
        }
        public function setMensaje($mensaje){
            $this->mensaje=$mensaje;
        }

        //método __tostring
        public function __toString()
        {
            throw new \Exception('Not implemented');
        }

        public function cargar($mail, $token, $vencimiento){
            $abmUsuario=new ABMUsuario();
            $busca=$abmUsuario->buscar(['usmail'=>$mail]);
            if($busca){
                $objUsuario=$busca[0];
            }
            else{ $objUsuario=null; }
            $this->setObjUsuario($objUsuario);
            $this->setToken($token);
            $this->setVencimiento($vencimiento);
        }

    /** funcion que me permite insertar un un token
     * @return bool
     */
    public function insertar(){
        $agrega=false;
        $base=new BaseDatos();
        $mail=$this->getObjUsuario()->getEmail_usuario();
        $token=$this->getToken();
        $vencimiento=$this->getVencimiento();
        $consulta="INSERT INTO pass_reset(usmail, token, vencimiento) VALUES";
        $consulta.="('".$mail."', '".$token."', '".$vencimiento."');";
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $agrega=true;
            }
            else {
                $this->setMensaje("pass_reset->insertar: " . $base->getError());
            } 	
        }
        else {
            $this->setMensaje("pass_reset->insertar: " . $base->getError());
        }
        return $agrega;   
    }

    /** Funcion que me permite modificar si un token fue usado
     * @return bool
     */
    public function modificar(){
        $base=new BaseDatos();
        $usado=$this->getUsado();
        $modifica=false;
        $consulta="UPDATE pass_reset SET ";
        $consulta.="usado=".$usado;
        $consulta.=" WHERE id=".$this->getIdPass().";";        
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
            $modifica=true;
            }
            else {
                $this->setMensaje("pass_reset->modificar: " . $base->getError());
            }
        }
        else {
            $this->setMensaje("pass_reset->modificar: " . $base->getError());
        }
        return $modifica;
    }

    /** funcion que me permite eliminar un pedido de reseteo
     * @return bool
     */
    public function eliminar(){
        $base=new BaseDatos();
        $elimina=false;
        $idPassReset=$this->getIdPass();
        $consulta="DELETE FROM pass_reset WHERE id=".$idPassReset.";";
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $elimina=true;
            }
            else {
                $this->setMensaje("pass_reset->eliminar: " . $base->getError());
            } 	
        }
        else {
            $this->setMensaje("pass_reset->eliminar: " . $base->getError());
        }
        return $elimina;
    }

    /** función para buscar un pass_reset
     * @return bool
     */
    public function buscar($where){
        $base=new BaseDatos();
        $encuentra=false;
        $consulta="SELECT * FROM pass_reset WHERE $where";
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $encuentra=true;
                $row=$base->Registro();
                $this->setIdPass($row['id']);
                $this->setToken($row['token']);
                $this->setVencimiento($row['vencimiento']);
                $abmUsuario=new ABMUsuario();
                $objUsuario=$abmUsuario->buscar(['usmail'=>$row['usmail']])[0];
                $this->setObjUsuario($objUsuario);
            }
        }
        return $encuentra;
    }
    }
?>