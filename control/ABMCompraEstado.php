<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');
include_once(__DIR__.'/../modelo/CompraItem.php');
include_once(__DIR__.'/../modelo/Compra.php');
include_once(__DIR__.'/../modelo/CompraEstadoTipo.php');
include_once(__DIR__.'/../modelo/CompraEstado.php');
include_once(__DIR__.'/../utils/funciones.php');
include_once('ABMProducto.php');
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
                    $objCompraEstado->setFechaFin($param['cefechafin']);
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
    //Busco el estado actual y lo cierro
    $estados = $this->buscar(['idcompra' => $idCompra, 'cefechafin' => 'null']);
    $cambia=false;
    $cierro=false;
    if (count($estados) > 0) {
        $objEstadoActual = $estados[0];
        $estadoTipoActual=$objEstadoActual->getObjCompraEstadoTipo()->getIdcompraestadotipo();
        $ahora = date('Y-m-d H:i:s');
        if($estadoTipoActual != $nuevoEstadoTipo){
            $cierro=$this->modificar([
                'idcompraestado' => $objEstadoActual->getIdCompraEstado(),
                'idcompra' => $idCompra,
                'idcompraestadotipo' => $estadoTipoActual,
                'cefechaini' => $objEstadoActual->getFechaIni(),
                'cefechafin' => $ahora
            ]);
        }
        //Si se cerró el anterior abro el nuevo
        if($cierro){
            $cambia= $this->alta([
                'idcompra' => $idCompra,
                'idcompraestadotipo' => $nuevoEstadoTipo,
                'cefechaini' => $ahora
            ]);
            $this->avisoCambioEstado($idCompra, $nuevoEstadoTipo);
        }
    }
    if($nuevoEstadoTipo==3 || $nuevoEstadoTipo==4){
        $objABMProducto=new ABMProducto();
        $objABMProducto->actualizarStock($idCompra, $nuevoEstadoTipo);
    }
    return $cambia;
}

/**
 * busqueda de compras segun estado
 */
public function buscarCompraEstado($estado){
    $resultado=[];
    if($estado=="Iniciada"){
        $resultado=$this->buscar(['idcompraestadotipo'=>1]);
    }
    if($estado=="Pendiente"){
        $resultado=$this->buscar(['idcompraestadotipo'=>2, 'cefechafin' => 'null']);
    }
    if($estado=="Aprobada"){
        $resultado=$this->buscar(['idcompraestadotipo'=>3, 'cefechafin' => 'null']);
    }
    if($estado=="Cancelada"){
        $resultado=$this->buscar(['idcompraestadotipo'=>4]);
    }
    if($estado=="Pagada"){
        $resultado=$this->buscar(['idcompraestadotipo'=>5]);
    }
    return $resultado;
}

/**
 * aviso por email al usuario del nuevo estado de la compra
 */
public Function avisoCambioEstado($idCompra, $estado){
    $objCompra=new Compra();
    $objCompra->buscar($idCompra);
    $objCompraEstadoTipo=new CompraEstadoTipo();
    $objCompraEstadoTipo->buscar($estado);
    $nuevoEstado=$objCompraEstadoTipo->getCetDescripcion();
    $objUsuario=$objCompra->getObjUsuario();
    $destinatario=$objUsuario->getEmail_usuario();
    $nombre=$objUsuario->getNom_usuario();
    $asunto="Su compra ha cambiado de estado - Ponete las pilas";
    $cuerpo="<h2>Estado de compra Actualizado</h2><br>
    <p>Hola $nombre. Nos comunicamos para informarte que su compra N° $idCompra ha cambiado a <b>estado: $nuevoEstado</b>.</p>
    <p>Recordamos el significado de cada estado:
        <ul>
            <li>Iniciada: es un borrador, el cual podés editar, enviar o cancelar desde la sección 'carrito'.</li>
            <li>Pendiente: se encuentra en proceso de evaluación por un administrador, quien aprobará o cancelará tu solicitud.</li>
            <li>Aprobada: orden aprobada y lista para el pago, al cual podrás acceder desde la sección 'mis pedidos' en el menú principal.</li>
            <li>Cancelada: orden cancelada.</li>
            <li>Pagada: compra realizada con éxito, desde logística te contactarán para coordinar la entrega de productos.</li>
        </ul>
    </p>
    <p>Saludos cordiales, el equipo de Ponete las pilas.</p>";
    $avisa=enviarMail($destinatario, $asunto, $cuerpo);
    return $avisa;
}
}