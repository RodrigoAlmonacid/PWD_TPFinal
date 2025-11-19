<?php

class ABMProducto
{
    //crea un objeto producto
    private function cargar($param)
    {
        $objProducto = null;
        if (array_key_exists('pronombre', $param) && array_key_exists('prodetalle', $param) && array_key_exists('procantstock', $param) && array_key_exists('proimagen', $param) && array_key_exists('proprecio', $param) && array_key_exists('prodeshabilitado', $param)) {
            $objProducto = new Producto();
            $objProducto->cargar(
                $param['idproducto'] ?? null,
                $param['pronombre'],
                $param['prodetalle'],
                $param['procantstock'],
                $param['proimagen'],
                $param['proprecio'],
                $param['prodeshabilitado']
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
                if(isset($param['prodeshabilitado'])) {
                    $objProducto->setProDeshabilitado($param['prodeshabilitado']);
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
            $where.=" and prodeshabilitado =".$param['prodeshabilitado'];
    }
    $objProducto = new Producto();
    $arreglo = $objProducto->listar($where); 
    
    return $arreglo; 
}

}



