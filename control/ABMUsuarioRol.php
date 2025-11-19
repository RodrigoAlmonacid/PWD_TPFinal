<?php

class AbmUsuarioRol
{


    private function cargarObjeto($param)
    {
        $obj = null;
        if (isset($param['idusuario']) && isset($param['idrol'])) {
            $obj = new UsuarioRol();
            $obj->cargar($param['idusuario'], $param['idrol']);
        }
        return $obj;
    }

    private function seteadosCamposClaves($param)
    {
        return (isset($param['idusuario']) && isset($param['idrol']));
    }



    public function alta($param)
    {
        $resp = false;
        $objUsuarioRol = $this->cargarObjeto($param);
        if ($objUsuarioRol != null) {
            $lista = $this->buscar($param);
            if (count($lista) == 0) {
                if ($objUsuarioRol->insertar()) {
                    $resp = true;
                }
            }
        }
        return $resp;
    }

    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objUsuarioRol = $this->cargarObjeto($param);
            if ($objUsuarioRol != null && $objUsuarioRol->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }


    public function modificacion($param)
    {
        $resp = false;

        if (isset($param['idusuario']) && isset($param['idrol']) && isset($param['nuevoidrol'])) {
            $paramBaja = [
                'idusuario' => $param['idusuario'],
                'idrol' => $param['idrol']
            ];
            if ($this->baja($paramBaja)) {
                $paramAlta = [
                    'idusuario' => $param['idusuario'],
                    'idrol' => $param['nuevoidrol']
                ];

                if ($this->alta($paramAlta)) {
                    $resp = true;
                }
            }
        }
        return $resp;
    }

    public function buscar($param)
    {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idusuario']))
                $where .= " and idusuario =" . $param['idusuario'];
            if (isset($param['idrol']))
                $where .= " and idrol =" . $param['idrol'];
        }
        $objUsuarioRol = new UsuarioRol();
        $arreglo = $objUsuarioRol->listar($where);
        return $arreglo;
    }
}
