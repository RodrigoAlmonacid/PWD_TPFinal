<?php

class ABMProducto
{
    //Agregar mas validaciones//
    //crea un objeto producto
    private function cargar($param)
    {
        $objProducto = null;
        if (array_key_exists('pronombre', $param) && array_key_exists('prodetalle', $param) && array_key_exists('procantstock', $param) && array_key_exists('proimagen', $param)) {
            $objProducto = new Producto();
            $objProducto->cargar(
                $param['idproducto'] ?? null,
                $param['pronombre'],
                $param['prodetalle'],
                $param['procantstock'],
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
        if (isset($param['idproducto'])) {
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
}
