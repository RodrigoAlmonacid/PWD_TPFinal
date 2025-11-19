<?php
class Session
{
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    //inicia la sesion del usuario
    public function iniciar($nombreUsuario, $psw)
    {
        $resp = false;
        $objAbmUsuario = new ABMUsuario();
        $param = ['usnombre' => $nombreUsuario];
        $listaUsuarios = $objAbmUsuario->buscar($param);
        if (count($listaUsuarios) > 0) {
            $usuario = $listaUsuarios[0];
            $estado = $usuario->getDesHabilitado_usuario();
            
            if ($estado === null || $estado == 0) {
                if ($psw === $usuario->getPass_usuario()) {
                    
                    $_SESSION['idusuario'] = $usuario->getId_usuario();
                    $_SESSION['usnombre'] = $usuario->getNom_usuario();
                    $_SESSION['usmail'] = $usuario->getEmail_usuario();
                    
                    $resp = true;
                }
            }
        }
        return $resp;
    }

    //valida si la sesion esta activa
    public function activa()
    {
        $resp = false;
        if (isset($_SESSION['idusuario'])) {
            $resp = true;
        }
        return $resp;
    }

    //devuelve el usuario logueado
    public function getUsuario()
    {
        $usuario = null;
        if ($this->activa()) {
            $objAbmUsuario = new ABMUsuario();
            $param = ['idusuario' => $_SESSION['idusuario']];
            $lista = $objAbmUsuario->buscar($param);
            if (count($lista) > 0) {
                $usuario = $lista[0];
            }
        }
        return $usuario;
    }

    //devuelve el rol del usuario logueado
    public function getRol()
    {
        $listaRoles = [];
        if ($this->activa()) {
            $objAbmUsuarioRol = new ABMUsuarioRol();
            $param = ['idusuario' => $_SESSION['idusuario']];
            $listaUsuarioRol = $objAbmUsuarioRol->buscar($param);
            foreach ($listaUsuarioRol as $objRelacion) {
                array_push($listaRoles, $objRelacion->getObjRol());
            }
        }
        return $listaRoles;
    }

    //cierra la sesion
    public function cerrar()
    {
        $resp = true;
        session_destroy();
        $_SESSION = array(); 
        return $resp;
    }
}
?>