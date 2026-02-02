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
                
                if(isset($param['rodescripcion'])){
                    $objRol->setDescripcion_rol($param['rodescripcion']);
                }
                
                if ($objRol->modificar()) {
                    $resp = true;
                }
            }
        }
        return $resp;
    }

    //busca de rol
    public function buscar($param)
    {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idrol']))
                $where .= " and idrol =" . $param['idrol'];
            
            if (isset($param['rodescripcion']))
                $where .= " and rodescripcion ='" . $param['rodescripcion'] . "'";
        }
        
        $objRol = new Rol();
        $arreglo = $objRol->listar($where);
        return $arreglo;
    }
}
?>
