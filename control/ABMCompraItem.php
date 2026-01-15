<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');
include_once(__DIR__.'/../modelo/CompraItem.php');
include_once(__DIR__.'/../modelo/Usuario.php');
class ABMCompraItem
{
    //crea un objeto cet
    private function cargar($param)
    {
        $objCompraItem = null;
        if (array_key_exists('idcompraitem', $param) && array_key_exists('idproducto', $param) && array_key_exists('idcompra', $param)&& array_key_exists('cicantidad', $param)) {
            $objCompraItem = new CompraItem();
            $objCompraItem->cargar(
                $param['idcompraitem'],
                $param['idproducto'],
                $param['idcompra'], 
                $param['cicantidad']
            );
        }
        return $objCompraItem;
    }

    private function cargarObjetoConClave($param)
    {
        $objCompraItem = null;

        if (isset($param['idcompraitem'])) {
            $objCompraItem = new CompraItem();
            $objCompraItem->setIdCompraItem($param['idcompraitem']);
        }
        return $objCompraItem;
    }


    private function seteadosCamposClaves($param)
    {
        $respuesta = false;
        if (!empty($param['idcompraitem'])) {
            $respuesta = true;
        }

        return $respuesta;
    }

    public function alta($param)
    {
        $respuesta = false;
        $objCompraItem = $this->cargar($param);
        if ($objCompraItem != null) {
            $respuesta = $objCompraItem->insertar();
        }
        return $respuesta;
    }

    public function modificar($param)
    {
        $respuesta = false;
        if ($this->seteadosCamposClaves($param)) {
            $objCompraItem = $this->cargarObjetoConClave($param);
            if ($objCompraItem != null && $objCompraItem->buscar($param['idcompraitem'])) {
                if (isset($param['idusuario'])) {
                    $objProducto=new Producto();
                    $objProducto->buscar($param['idusuario']);
                    $objCompraItem->setObjProducto($objProducto);
                }
                if (isset($param['idcompra'])) {
                    $objCompra=new Compra();
                    $objCompra->buscar($param['idcompra']);
                    $objCompraItem->setObjProducto($objCompra);
                }
                if (isset($param['cicantidad'])) {
                    $objCompraItem->setCantidad($param['cicantidad']);
                }
                $respuesta = $objCompraItem->modificar();
            }
        }

        return $respuesta;
    }

    public function baja($param)
    {
        $respuesta = false;
        if ($this->seteadosCamposClaves($param)) {
            $objCompraItem = $this->cargarObjetoConClave($param);
            if ($objCompraItem != null && $objCompraItem->buscar($param['idcompraItem'])) {
                $respuesta = $objCompraItem->eliminar();
            }
        }
        return $respuesta;
    }


public function buscar($param){
    $where = " true "; 
    if ($param != NULL){
        if  (isset($param['idcompraitem']))
            $where.=" and idcompraitem =".$param['idcompraitem'];
        if  (isset($param['idproducto']))
            $where.=" and idproducto ='" . $param['idproducto'] . "'";

        if  (isset($param['idcompra']))
            $where.=" and idcompra = ".$param['idcompra'];
        if  (isset($param['cicantidad']))
            $where.=" and cicantidad = ".$param['cicantidad'];
    }
    $objCompraItem = new CompraEstadoTipo();
    $arreglo = $objCompraItem->listar($where); 
    
    return $arreglo; 
}

}