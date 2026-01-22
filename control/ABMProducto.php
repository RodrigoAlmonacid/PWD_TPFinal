<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');
include_once(__DIR__.'/../modelo/Producto.php');
include_once('ABMCompraItem.php');
include_once('ABMCompraEstado.php');
class ABMProducto
{
    //crea un objeto producto
    private function cargar($param)
    {
        $objProducto = null;
        if (array_key_exists('pronombre', $param) && array_key_exists('prodetalle', $param) && array_key_exists('procantstock', $param) && array_key_exists('proimagen', $param) && array_key_exists('proprecio', $param)) {
            $objProducto = new Producto();
            $objProducto->cargar(
                $param['pronombre'],
                $param['prodetalle'],
                $param['procantstock'],
                $param['proprecio'],
                $param['proimagen']
            );
        }
        return $objProducto;
    }

    private function cargarObjetoConClave($param)
    {
        $objProducto = null;

        if (isset($param['idproducto'])) {
            $objProducto = new Producto();
            $objProducto->setIdProducto($param['idproducto']);
        }
        return $objProducto;
    }


    private function seteadosCamposClaves($param)
    {
        $respuesta = false;
        if (!empty($param['idproducto'])) {
            $respuesta = true;
        }

        return $respuesta;
    }

    public function alta($param)
    {
        $respuesta = false;
        $objProducto = $this->cargar($param);
        if ($objProducto != null) {
            $respuesta = $objProducto->insertar();
        }
        return $respuesta;
    }

    public function modificar($param)
    {
        $respuesta = false;
        if ($this->seteadosCamposClaves($param)) {
            $objProducto = $this->cargarObjetoConClave($param);
            if ($objProducto != null && $objProducto->buscar($param['idproducto'])) {
                if (isset($param['pronombre'])) {
                    $objProducto->setNomProducto($param['pronombre']);
                }
                if (isset($param['prodetalle'])) {
                    $objProducto->setDetallesProd($param['prodetalle']);
                }
                if (isset($param['procantstock'])) {
                    $objProducto->setStockProducto($param['procantstock']);
                }
                if (isset($param['proimagen'])) {
                    $objProducto->setImgProd($param['proimagen']);
                }
                if(isset($param['proprecio'])) {
                    $objProducto->setProPrecio($param['proprecio']);
                }
                if (isset($param['prodeshabilitado']) && $param['prodeshabilitado']=="Habilitado") {
                    $objProducto->setProDeshabilitado("null");
                }
                elseif (isset($param['prodeshabilitado']) && $param['prodeshabilitado']=="Deshabilitado") {
                    $date=date('Y-m-d H:i:s');
                    $objProducto->setProDeshabilitado($date);
                }

                $respuesta = $objProducto->modificar();
            }
        }

        return $respuesta;
    }

    public function baja($param)
    {
        $respuesta = false;
        if ($this->seteadosCamposClaves($param)) {
            $objProducto = $this->cargarObjetoConClave($param);
            if ($objProducto != null && $objProducto->buscar($param['idproducto'])) {
                $respuesta = $objProducto->eliminar();
            }
        }
        return $respuesta;
    }


public function buscar($param){
    $where = " true "; 
    if ($param != NULL){
        if  (isset($param['idproducto']))
            $where.=" and idproducto =".$param['idproducto'];
        if  (isset($param['pronombre']))
            $where.=" and pronombre ='" . $param['pronombre'] . "'";

        if  (isset($param['prodeshabilitado']))
            $where.=" and prodeshabilitado IS ".$param['prodeshabilitado'];
    }
    $objProducto = new Producto();
    $arreglo = $objProducto->listar($where); 
    
    return $arreglo; 
}

/** actualiza stock
 *  $compraItem=$objABMCompraItem->buscar(['idcompra' => $idCompra]); Aca ya logré obtener los items
 */
public function actualizarStock($idCompra, $estado){
    $objABMCompraItem=new ABMCompraItem();
    $compraItem=$objABMCompraItem->buscar(['idcompra' => $idCompra]);
    $objABMCompraEstado=new ABMCompraEstado();
    $estadoAprobada=$objABMCompraEstado->buscar(['idcompra'=>$idCompra, 'idcompraestadotipo'=>3]);
    foreach($compraItem as $unItem){
        $objProducto=$unItem->getobjProducto();
        $stockActual=$objProducto->getStockProducto();
        $cantidad=$unItem->getCantidad();
        $nuevoStock=$objProducto->getStockProducto();
        if($estado==3){
            $nuevoStock = $stockActual - $cantidad;
        }
        else if($estado==4 && count($estadoAprobada)>0){
            $nuevoStock = $stockActual + $cantidad;
        }
        $this->modificar(['idproducto'=>$objProducto->getIdProducto(), 'procantstock'=>$nuevoStock]);
    }
}
}



