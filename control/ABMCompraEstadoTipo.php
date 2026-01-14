<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');
include_once(__DIR__.'/../modelo/CompraEstadoTipo.php');
class ABMCompraEstadoTipo
{
    //crea un objeto cet
    private function cargar($param)
    {
        $objCompraEstadoTipo = null;
        if (array_key_exists('idcompraestadotipo', $param) && array_key_exists('cetdescripcion', $param) && array_key_exists('cetdetalle', $param)) {
            $objCompraEstadoTipo = new CompraEstadoTipo();
            $objCompraEstadoTipo->cargar(
                $param['idcompraestadotipo'],
                $param['cetdetalle'],
                $param['cetdescripcion']
            );
        }
        return $objCompraEstadoTipo;
    }

    private function cargarObjetoConClave($param)
    {
        $objCompraEstadoTipo = null;

        if (isset($param['idcompraestadotipo'])) {
            $objCompraEstadoTipo = new CompraEstadoTipo();
            $objCompraEstadoTipo->setIdCompraEstadoTipo($param['idcompraestadotipo']);
        }
        return $objCompraEstadoTipo;
    }


    private function seteadosCamposClaves($param)
    {
        $respuesta = false;
        if (!empty($param['idcompraestadotipo'])) {
            $respuesta = true;
        }

        return $respuesta;
    }

    public function alta($param)
    {
        $respuesta = false;
        $objCompraEstadoTipo = $this->cargar($param);
        if ($objCompraEstadoTipo != null) {
            $respuesta = $objCompraEstadoTipo->insertar();
        }
        return $respuesta;
    }

    public function modificar($param)
    {
        $respuesta = false;
        if ($this->seteadosCamposClaves($param)) {
            $objCompraEstadoTipo = $this->cargarObjetoConClave($param);
            if ($objCompraEstadoTipo != null && $objCompraEstadoTipo->buscar($param['idcompraestadotipo'])) {
                if (isset($param['cetdetalle'])) {
                    $objCompraEstadoTipo->setCetDetalle($param['cetdetalle']);
                }
                if (isset($param['cetdescripcion'])) {
                    $objCompraEstadoTipo->setCetDescripcion($param['cetdescripcion']);
                }
                $respuesta = $objCompraEstadoTipo->modificar();
            }
        }

        return $respuesta;
    }

    public function baja($param)
    {
        $respuesta = false;
        if ($this->seteadosCamposClaves($param)) {
            $objCompraEstadoTipo = $this->cargarObjetoConClave($param);
            if ($objCompraEstadoTipo != null && $objCompraEstadoTipo->buscar($param['idcompraestadotipo'])) {
                $respuesta = $objCompraEstadoTipo->eliminar();
            }
        }
        return $respuesta;
    }


public function buscar($param){
    $where = " true "; 
    if ($param != NULL){
        if  (isset($param['idcompraestadotipo']))
            $where.=" and idcompraestadotipo =".$param['idcompraestadotipo'];
        if  (isset($param['cetdetalle']))
            $where.=" and cetdetalle ='" . $param['cetdetalle'] . "'";

        if  (isset($param['cetdescripcion']))
            $where.=" and cetdescripcion = ".$param['cetdescripcion'];
    }
    $objCompraEstadoTipo = new CompraEstadoTipo();
    $arreglo = $objCompraEstadoTipo->listar($where); 
    
    return $arreglo; 
}

}