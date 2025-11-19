<?php

class AbmRol
{
    //carga objeto rol
    private function cargarObjeto($param)
    {
        $obj = null;
        if (isset($param['rodescripcion'])) {
            $obj = new Rol();

            $id = $param['idrol'] ?? null;
            
            $obj->cargar($id, $param['rodescripcion']);
        }
        return $obj;
    }

    //carga objeto rol con id
    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idrol'])) {
            $obj = new Rol();
            $obj->setId_rol($param['idrol']);
        }
        return $obj;
    }

   
    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param['idrol'])) {
            $resp = true;
        }
        return $resp;
    }

    //ata de rol
    public function alta($param)
    {
        $resp = false;
        // Forzamos null en idrol para asegurar que sea un alta
        $param['idrol'] = null;
        
        $objRol = $this->cargarObjeto($param);
        
        if ($objRol != null && $objRol->insertar()) {
            $resp = true;
        }
        return $resp;
    }

   //baja de rol
    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objRol = $this->cargarObjetoConClave($param);
            if ($objRol != null && $objRol->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    //modificacion de rol
    public function modificacion($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            
            $objRol = $this->cargarObjetoConClave($param);
            
            if($objRol != null && $objRol->buscar($param['idrol'])){
                
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