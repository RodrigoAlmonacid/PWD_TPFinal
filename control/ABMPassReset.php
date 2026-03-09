<?php
include_once __DIR__ . '/../modelo/PassReset.php';
class ABMPassReset {
    
    //carga objeto 
    private function cargarObjeto($param)
    {
        $objPass = null;
        if (isset($param['token']) && isset($param['vencimiento']) && isset($param['usmail'])) {
            $objPass = new PassReset();
            $objPass->cargar($param['usmail'], $param['token'], $param['vencimiento']);
        }
        return $objPass;
    }

    //carga pass con id
    private function cargarObjetoConClave($param)
    {
        $objPass = null;
        if (isset($param['id'])) {
            $objPass = new PassReset();
            $objPass->setIdPass($param['id']);
        }
        return $objPass;
    }

   
    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param['id'])) {
            $resp = true;
        }
        return $resp;
    }

    //ata de pass_reset
    public function alta($param)
    {
        $resp = false;
        // Forzamos null en idrol para asegurar que sea un alta
        $param['id'] = null;
        
        $objPass = $this->cargarObjeto($param);
        
        if ($objPass != null && $objPass->insertar()) {
            $resp = true;
        }
        return $resp;
    }

   //baja de pass_reset -> no lo voy a usar
    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objPass = $this->cargarObjetoConClave($param);
            if ($objPass != null && $objPass->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    //modificacion pass_reset
    public function modificacion($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            
            $objPass = $this->cargarObjetoConClave($param);
            
            if($objPass != null && $objPass->buscar($param['id'])){
                
                if(isset($param['usado'])){
                    $objPass->setUsado($param['usado']);
                }
                
                if ($objPass->modificar()) {
                    $resp = true;
                }
            }
        }
        return $resp;
    }

    //busca de pass_reset
    public function buscar($param)
    {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['id']))
                $where .= " and id =" . $param['id'];
            if (isset($param['usado']))
                $where .= " and usado =" . $param['usado'];
            if (isset($param['token']))
                $where .= " and token ='" . $param['token'] . "'";
            if (isset($param['vencimiento']))
                $where .= " and vencimiento ='" . $param['vencimiento'] . "'";
            if (isset($param['usmail']))
                $where .= " and usmail ='" . $param['usmail'] . "'";
        }
        
        $objPass = new PassReset();
        $encuentra=$objPass->buscar($where);
        if(!$encuentra){
            $objPass=null;
        }
        return $objPass;
    }

    /** le paso un token y chequea si es válido
     * @param STRING $token
     * @return STRING devuellvo el error, si lleva texto algo salió mal, sino manda null
     */
    public function validaToken($token){
        $error = null;
        $abmPass=new ABMPassReset();
        $objPass=$abmPass->buscar(['token'=>$token, 'usado'=>0]); //miro el estado del token ('usado'=0 => no fue usado, 'usado'=1 => ya está usado)

        if ($objPass) {   
            //Validamos el vencimiento (cuando armo el token le doy una hora)
            $ahora = date("Y-m-d H:i:s"); //hora actual
            if ($ahora > $objPass->getVencimiento()) { //la hora actual debe ser anterior a la del token
                $error = "El enlace ha expirado. Los tokens duran solo 1 hora.";
            }
        } else {
            // Si no encontró nada o ya fue usado
            $error = "El enlace es inválido o ya fue utilizado previamente.";
        }
        return $error;
    }
}
?>
