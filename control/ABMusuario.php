<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');
class ABMUsuario
{
    //carga un objeto usuario
    private function cargar($param)
    {
        //$objUsuario = null;
        $objUsuario = new Usuario();

        if (isset($param['usnombre']) && isset($param['uspass']) && isset($param['usmail'])) {

            //$objUsuario = new Usuario();

            $objUsuario->cargar(
                $param['usnombre'],
                $param['usmail'],
                $param['uspass']
            );
        }
        return $objUsuario;
    }

    private function cargarObjetoConClave($param)
    {
        $objUsuario = null;
        if (isset($param['idusuario'])) {
            $objUsuario = new Usuario();
            $objUsuario->setId_usuario($param['idusuario']);
        }
        return $objUsuario;
    }

    private function seteadosCamposClaves($param)
    {
        $respuesta = false;
        if (!empty($param['idusuario'])) {
            $respuesta = true;
        }
        return $respuesta;
    }

    //alta usuario
    public function alta($param)
    {
        $respuesta = false;
        $objUsuario = $this->cargar($param);

        if ($objUsuario != null) {
            $respuesta = $objUsuario->insertar();
        }
        return $respuesta;
    }

    //modificar usuario
    public function modificar($param)
    {
        $respuesta = false;
        if ($this->seteadosCamposClaves($param)) {

            $objUsuario = $this->cargarObjetoConClave($param);

            if ($objUsuario != null && $objUsuario->buscar($param['idusuario'])) {

                if (isset($param['usnombre'])) $objUsuario->setNom_usuario($param['usnombre']);
                if (isset($param['usmail'])) $objUsuario->setEmail_usuario($param['usmail']);

                if (isset($param['uspass']) && $param['uspass'] != "") {
                    $objUsuario->setPass_usuario($param['uspass']);
                }
                if (isset($param['usdeshabilitado']) && $param['usdeshabilitado']==1) {
                    $objUsuario->setDesHabilitado_usuario("null");
                }
                elseif (isset($param['usdeshabilitado']) && $param['usdeshabilitado']==0) {
                    $date=date('Y-m-d H:i:s');
                    $objUsuario->setDesHabilitado_usuario($date);
                }
                $respuesta = $objUsuario->modificar();
            }
        }
        return $respuesta;
    }

    //baja usuario
    public function baja($param)
    {
        $respuesta = false;
        if ($this->seteadosCamposClaves($param)) {
            $objUsuario = $this->cargarObjetoConClave($param);
            if ($objUsuario != null && $objUsuario->buscar($param['idusuario'])) {
                $respuesta = $objUsuario->estado();
            }
        }
        return $respuesta;
    }

    //buscar usuario
    public function buscar() //$param
    {/*
        $where = " true ";
        if ($param != NULL) {
            if (isset($param['idusuario']))
                $where .= " and idusuario =" . $param['idusuario'];
            if (isset($param['usnombre']))
                $where .= " and usnombre ='" . $param['usnombre'] . "'";
            if (isset($param['usmail']))
                $where .= " and usmail ='" . $param['usmail'] . "'";
            if (isset($param['usdeshabilitado'])) {
                $where .= " and usdeshabilitado =" . $param['usdeshabilitado'];
            }
        }*/

        $objUsuario = new Usuario();
        $arreglo = $objUsuario->listar();
        return $arreglo;
    }
}
?>