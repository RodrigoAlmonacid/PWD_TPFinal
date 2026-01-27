<?php
include_once(__DIR__.'/../modelo/Menu.php');
include_once(__DIR__.'/../modelo/Rol.php');
include_once(__DIR__.'/../modelo/MenuRol.php');
class ABMMenuRol {
    
    // En MenuRol la clave es compuesta (idmenu + idrol)
    private function cargarObjetoWithKey($param){
        $obj = null;
        if( isset($param['idmenu']) && isset($param['idrol']) ){
            $obj = new MenuRol();
            // Necesitamos los objetos Menu y Rol completos
            $objMenu = new Menu();
            $objMenu->buscar($param['idmenu']); 
            
            $objRol = new Rol();
            $objRol->buscar($param['idrol']);

            $obj->setObjMenu($objMenu);
            $obj->setObjRol($objRol);
        }
        return $obj;
    }
    
    private function seteadosCamposClaves($param){
        return (isset($param['idmenu']) && isset($param['idrol']));
    }
    
    public function alta($param){
        $resp = false;
        $objMenuRol = $this->cargarObjetoWithKey($param);
        if ($objMenuRol!=null and $objMenuRol->insertar()){
            $resp = true;
        }
        return $resp;
    }
    
    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $objMenuRol = $this->cargarObjetoWithKey($param);
            if ($objMenuRol!=null and $objMenuRol->eliminar()){
                $resp = true;
            }
        }
        return $resp;
    }
    
    public function buscar($param){
        $where = " true ";
        if ($param<>NULL){
            if  (isset($param['idmenu']))
                $where.=" and idmenu =".$param['idmenu'];
            if  (isset($param['idrol']))
                $where.=" and idrol =".$param['idrol'];
        }
        $objMenuRol = new MenuRol();
        $arreglo = $objMenuRol->listar($where);
        return $arreglo;
    }
}
?>