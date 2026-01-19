<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');
include_once(__DIR__.'/../modelo/CompraItem.php');
include_once(__DIR__.'/../modelo/Compra.php');
include_once(__DIR__.'/../modelo/CompraEstadoTipo.php');
include_once(__DIR__.'/../modelo/CompraEstado.php');
class ABMCompraEstado
{
    //crea un objeto cet
    private function cargar($param)
    {
        $objCompraEstado = null;
        if (array_key_exists('idcompraestado', $param) && array_key_exists('idcompra', $param) && array_key_exists('idcompraestadotipo', $param) && array_key_exists('cefechaini', $param) && array_key_exists('cefechafin', $param)) {
            $objCompraEstado = new CompraEstado();
            $objCompraEstado->cargar(
                $param['idcompraestado'],
                $param['idcompra'],
                $param['idcompraestaditipo'],
                $param['cefechaini'],
                $param['cefechafin']
            );
        }
        return $objCompraEstado;
    }

    private function cargarObjetoConClave($param)
    {
        $objCompraEstado = null;

        if (isset($param['idcompraestado'])) {
            $objCompraEstado = new CompraEstado();
            $objCompraEstado->setIdCompraEstado($param['idcompraestado']);
        }
        return $objCompraEstado;
    }


    private function seteadosCamposClaves($param)
    {
        $respuesta = false;
        if (!empty($param['idcompraestado'])) {
            $respuesta = true;
        }

        return $respuesta;
    }

    public function alta($param)
    {
        $respuesta = false;
        $objCompraEstado = new CompraEstado();
        $objCompraEstadoTipo = new CompraEstadoTipo;
        $objCompraEstadoTipo->buscar($param['idcompraestadotipo']);
        $objCompraEstado->setObjCompraEstadoTipo($objCompraEstadoTipo);
        $objCompra = new Compra();
        $objCompra->buscar($param['idcompra']); //********** 
        $objCompraEstado->setobjCompra($objCompra);
        if ($objCompraEstado != null) {
            $respuesta = $objCompraEstado->insertar();
        }
        return $respuesta;
    }

    public function modificar($param)
    {
        $respuesta = false;
        if ($this->seteadosCamposClaves($param)) {
            $objCompraEstado = $this->cargarObjetoConClave($param);
            if ($objCompraEstado != null && $objCompraEstado->buscar($param['idcompraestado'])) {
                if (isset($param['idcompra'])) {
                    $objCompra=new Compra();
                    $objCompra->buscar($param['idcompra']);
                    $objCompraEstado->setobjCompra($objCompra);
                }
                if (isset($param['idcompraestadotipo'])) {
                    $objCompraEstadoTipo=new CompraEstadoTipo();
                    $objCompraEstadoTipo->buscar($param['idcompraestadotipo']);
                    $objCompraEstado->setObjCompraEstadoTipo($objCompraEstadoTipo);
                }
                if (isset($param['cefechaini'])) {
                    $objCompraEstado->setFechaIni($param['cefechaini']);
                }
                if (isset($param['cefechafin'])) {
                    $objCompraEstado->setFechaIni($param['cefechaini']);
                }
                $respuesta = $objCompraEstado->modificar();
            }
        }

        return $respuesta;
    }

    public function baja($param)
    {
        $respuesta = false;
        if ($this->seteadosCamposClaves($param)) {
            $objCompraEstado = $this->cargarObjetoConClave($param);
            if ($objCompraEstado != null && $objCompraEstado->buscar($param['idcompraestado'])) {
                $respuesta = $objCompraEstado->eliminar();
            }
        }
        return $respuesta;
    }


public function buscar($param){
    $where = " true "; 
    if ($param != NULL){
        if  (isset($param['idcompraestado']))
            {$where.=" and idcompraestado =".$param['idcompraestado'];}
        if  (isset($param['idcompra']))
            {$where.=" and idcompra ='" . $param['idcompra'] . "'";}
        if  (isset($param['idcompraestadotipo']))
            {$where.=" and idcompraestadotipo = ".$param['idcompraestadotipo'];}
        if (isset($param['cefechafin']) && $param['cefechafin'] == 'null') {
            $where .= " AND cefechafin IS NULL";
        }
    }
    $objCompraEstado = new CompraEstado();
    $arreglo = $objCompraEstado->listar($where); 
    
    return $arreglo; 
}
/**
 * Cierra el estado actual y abre uno nuevo
 */
public function cambiarEstado($idCompra, $nuevoEstadoTipo) {
    // 1. Buscamos el estado actual (el que tiene cefechafin en NULL)
    $estados = $this->buscar(['idcompra' => $idCompra, 'cefechafin' => 'null']);
    
    if (count($estados) > 0) {
        $objEstadoActual = $estados[0];
        $ahora = date('Y-m-d H:i:s');
        
        // 2. Cerramos el estado actual (UPDATE)
        $this->modificar([
            'idcompraestado' => $objEstadoActual->getIdcompraestado(),
            'idcompra' => $idCompra,
            'idcompraestadotipo' => $objEstadoActual->getObjCompraEstadoTipo()->getIdcompraestadotipo(),
            'cefechaini' => $objEstadoActual->getCefechaini(),
            'cefechafin' => $ahora
        ]);
        
        // 3. Abrimos el nuevo estado (INSERT)
        return $this->alta([
            'idcompra' => $idCompra,
            'idcompraestadotipo' => $nuevoEstadoTipo,
            'cefechaini' => $ahora
        ]);
    }
    return false;
}

//busqueda de compras segun estado
public function buscarCompraEstado($estado){
    $resultado=[];
    if($estado=="Iniciada"){
        $resultado=$this->buscar(['idcompraestadotipo'=>1]);
    }
    if($estado=="Pendiente"){
        $resultado=$this->buscar(['idcompraestadotipo'=>2]);
    }
    if($estado=="Aprobada"){
        $resultado=$this->buscar(['idcompraestadotipo'=>3]);
    }
    if($estado=="Cancelada"){
        $resultado=$this->buscar(['idcompraestadotipo'=>4]);
    }
    if($estado=="Pagada"){
        $resultado=$this->buscar(['idcompraestadotipo'=>5]);
    }
    return $resultado;
}
}