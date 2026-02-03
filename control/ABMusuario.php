<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');
include_once __DIR__ . '/../modelo/Usuario.php';
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
        
        //Encriptamos la clave antes de cargar el objeto
        if (isset($param['uspass'])) {
            $param['uspass'] = md5($param['uspass']);
        }

        $objUsuario = $this->cargar($param);

        if ($objUsuario != null) {
            $respuesta = $objUsuario->insertar();
        }
        return $respuesta;
    }

    // Modifica usuario
    public function modificar($param)
    {
        $respuesta = false;
        $olvida=false;
        if ($this->seteadosCamposClaves($param)) {
            $objUsuario = $this->cargarObjetoConClave($param);
            if ($objUsuario != null && $objUsuario->buscar($param['idusuario'])) {
                if (isset($param['usnombre'])){
                    $objUsuario->setNom_usuario($param['usnombre']);
                }
                if (isset($param['usmail'])){ 
                    $objUsuario->setEmail_usuario($param['usmail']);
                }

                // contraseña para agregar a otro módulo
                if (isset($param['uspass']) && $param['uspass'] != "") {
                    $passEncriptada = md5($param['uspass']);
                    $objUsuario->setPass_usuario($passEncriptada);
                    $olvida=true;
                }
                
                //lógica de deshabilitado (con problemaas)
                if (isset($param['usdeshabilitado']) && ($param['usdeshabilitado']=="Habilitado" || $param['usdeshabilitado']==null || $param['usdeshabilitado']=="")) {
                    $objUsuario->setDesHabilitado_usuario("null");
                }
                elseif (isset($param['usdeshabilitado']) && $param['usdeshabilitado']=="Deshabilitado") {
                    $date=date('Y-m-d H:i:s');
                    $objUsuario->setDesHabilitado_usuario($date);
                }

                $respuesta = $objUsuario->modificar($olvida);
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
                $respuesta = $objUsuario->eliminar();
            }
        }
        return $respuesta;
    }


    public function buscar($param = null){
        $where = " true "; // Inicia con true para facilitar los concatenados

        if ($param <> null){
            if  (isset($param['idusuario']))
                $where .= " and idusuario =".$param['idusuario'];
            if  (isset($param['usnombre']))
                $where .= " and usnombre ='".$param['usnombre']."'";
            if  (isset($param['usmail']))
                $where .= " and usmail ='".$param['usmail']."'";
            if  (isset($param['uspass']))
                $where .= " and uspass ='".$param['uspass']."'";
        }
        $objUsuario = new Usuario();
        $arreglo = $objUsuario->listar($where);
        return $arreglo;
    }
}
?>