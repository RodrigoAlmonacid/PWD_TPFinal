<?php
class ABMMenu {
    
    // Carga un objeto Menu desde un array de parámetros
    private function cargarObjeto($param){
        $obj = null;
        if( array_key_exists('menombre',$param) && array_key_exists('medescripcion',$param) ){
            $obj = new Menu();
            
            $obj->setMeNombre($param['menombre']);
            $obj->setMeDescripcion($param['medescripcion']);
            $obj->setIconoBootstrap($param['iconoBootstrap']);
            
            // Manejo de ID Padre (puede ser null)
            if (isset($param['idpadre']) && $param['idpadre'] != "" && $param['idpadre'] != "null"){
                $obj->setIdPadre($param['idpadre']);
            } else {
                $obj->setIdPadre(null);
            }
            
            // Manejo de Deshabilitado
            if(isset($param['medeshabilitado'])){
                $obj->setMeDeshabilitado($param['medeshabilitado']);
            } else {
                $obj->setMeDeshabilitado(null);
            }
        }
        return $obj;
    }
    
    // Carga solo con la clave primaria (para eliminar o buscar específico)
    private function cargarObjetoConClave($param){
        $obj = null;
        if( isset($param['idmenu']) ){
            $obj = new Menu();
            $obj->setIdMenu($param['idmenu']);
        }
        return $obj;
    }
    
    private function seteadosCamposClaves($param){
        return (isset($param['idmenu']));
    }
    
    public function alta($param){
        $resp = false;
        // Al crear, el ID es nulo o autoincremental, no lo seteamos
        $objMenu = $this->cargarObjeto($param);
        if ($objMenu!=null && $objMenu->insertar()){
            $resp = true;
        }
        return $resp;
    }
    
    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $objMenu = $this->cargarObjetoConClave($param);
            if ($objMenu!=null and $objMenu->eliminar()){
                $resp = true;
            }
        }
        return $resp;
    }
    
    public function modificacion($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $objMenu = $this->cargarObjeto($param);
            if($objMenu != null){
                $objMenu->setIdMenu($param['idmenu']);
                if($objMenu->modificar()){
                    $resp = true;
                }
            }
        }
        return $resp;
    }
    
    public function buscar($param){
        $where = " true ";
        if ($param<>NULL){
            if  (isset($param['idmenu']))
                $where.=" and idmenu =".$param['idmenu'];
            if  (isset($param['menombre']))
                $where.=" and menombre ='".$param['menombre']."'";
            if  (isset($param['medescripcion']))
                $where.=" and medescripcion ='".$param['medescripcion']."'";
            if  (isset($param['idpadre']))
                $where.=" and idpadre =".$param['idpadre'];
            if  (isset($param['medeshabilitado']))
                $where.=" and medeshabilitado ='".$param['medeshabilitado']."'";
        }
        $objMenu = new Menu();
        $arreglo = $objMenu->listar($where);
        return $arreglo;
    }
}
?>