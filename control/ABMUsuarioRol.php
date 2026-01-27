<?php
include_once __DIR__ . '/../modelo/UsuarioRol.php';
class ABMUsuarioRol {
    
    private function cargarObjetoWithKey($param){
        $obj = null;
        if( isset($param['idusuario']) && isset($param['idrol']) ){
            $obj = new UsuarioRol();
            
            $objUsuario = new Usuario();
            $objUsuario->setId_usuario($param['idusuario']);
            
            $objRol = new Rol();
            $objRol->setId_rol($param['idrol']);

            $obj->setObjUsuario($objUsuario);
            $obj->setObjRol($objRol);
        }
        return $obj;
    }
    
    private function seteadosCamposClaves($param){
        return (isset($param['idusuario']) && isset($param['idrol']));
    }
    
    public function alta($param){
        $resp = false;
        $objUsuarioRol = $this->cargarObjetoWithKey($param);
        if ($objUsuarioRol!=null and $objUsuarioRol->insertar()){
            $resp = true;
        }
        return $resp;
    }
    
    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $objUsuarioRol = $this->cargarObjetoWithKey($param);
            if ($objUsuarioRol!=null && $objUsuarioRol->eliminar()){
                $resp = true;
            }
        }
        return $resp;
    }
    
    public function buscar($param){
        $where = " true ";
        if ($param<>NULL){
            if  (isset($param['idusuario']))
                $where.=" and idusuario =".$param['idusuario'];
            if  (isset($param['idrol']))
                $where.=" and idrol =".$param['idrol'];
        }
        $objUsuarioRol = new UsuarioRol();
        $arreglo = $objUsuarioRol->listar($where);
        return $arreglo;
    }
}
?>
