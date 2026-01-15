<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');
include_once(__DIR__.'/../modelo/Compra.php');
include_once(__DIR__.'/../modelo/Usuario.php');
include_once(__DIR__.'/ABMCompraEstado.php');
class ABMCompra
{
    //crea un objeto compra
    private function cargar($param)
    {
        $objCompra = null;
        if (array_key_exists('idcompra', $param) && array_key_exists('cofecha', $param) && array_key_exists('idusuario', $param)) {
            $objCompra = new Compra();
            $objCompra->cargar(
                $param['idcompra'],
                $param['cofecha'],
                $param['idusuario']
            );
        }
        return $objCompra;
    }

    private function cargarObjetoConClave($param)
    {
        $objCompra = null;

        if (isset($param['idcompra'])) {
            $objCompra = new Compra();
            $objCompra->setIdCompra($param['idcompra']);
        }
        return $objCompra;
    }


    private function seteadosCamposClaves($param)
    {
        $respuesta = false;
        if (!empty($param['idcompra'])) {
            $respuesta = true;
        }

        return $respuesta;
    }

    public function alta($param)
    {
        $respuesta = false;
        $objCompra = new Compra();
        $objUsuario = new Usuario();
        $objUsuario->buscar($param);
        $objCompra->setobjUsuario($objUsuario);
        if ($objCompra != null) {
            $respuesta = $objCompra->insertar();
        }
        return $respuesta;
    }

    public function modificar($param)
    {
        $respuesta = false;
        if ($this->seteadosCamposClaves($param)) {
            $objCompra = $this->cargarObjetoConClave($param);
            if ($objCompra != null && $objCompra->buscar($param['idcompra'])) {
                if (isset($param['cofecha'])) {
                    $objCompra->setFecha($param['cofecha']);
                }
                if (isset($param['idusuario'])) {
                    $objUsuario=new Usuario();
                    $objUsuario->buscar($param['idusuario']);
                    $objCompra->setObjUsuario($objUsuario);
                }

                $respuesta = $objCompra->modificar();
            }
        }

        return $respuesta;
    }

    public function baja($param)
    {
        $respuesta = false;
        if ($this->seteadosCamposClaves($param)) {
            $objCompra = $this->cargarObjetoConClave($param);
            if ($objCompra != null && $objCompra->buscar($param['idcompra'])) {
                $respuesta = $objCompra->eliminar();
            }
        }
        return $respuesta;
    }


public function buscar($param){
    $where = " true "; 
    if ($param != NULL){
        if  (isset($param['idcompra']))
            $where.=" and idcompra =".$param['idcompra'];
        if  (isset($param['cofecha']))
            $where.=" and cofecha ='" . $param['cofecha'] . "'";

        if  (isset($param['idusuario']))
            $where.=" and idusuario =".$param['idusuario'];
    }
    $objCompra = new Compra();
    $arreglo = $objCompra->listar($where); 
    
    return $arreglo; 
}
public function obtenerCarritoActivo($idUsuario) {
    $objAbmCompraEstado = new ABMCompraEstado();
    $carrito = null;
    $compras = $this->buscar(['idusuario' => $idUsuario]);
    $i = 0;
    $cantidadCompras = count($compras);
    $encontrado = false;
    while ($i < $cantidadCompras && !$encontrado) {
        $idCompraActual = $compras[$i]->getIdcompra();
        $estados = $objAbmCompraEstado->buscar([
            'idcompra' => $idCompraActual,
            'idcompraestadotipo' => 1,
            'cefechafin' => 'null' 
        ]);
        if (count($estados) > 0) {
            $encontrado = true;
            $carrito = $compras[$i];
        }     
        $i++;
    }
    return $carrito;
}
}