<?php
include_once __DIR__ . '/ABMusuario.php';
include_once __DIR__ . '/ABMUsuarioRol.php';
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
        
        //Buscamos el usuario por nombre
        $param = ['usmail' => $nombreUsuario];
        $listaUsuarios = $objAbmUsuario->buscar($param);
        if (count($listaUsuarios) > 0) {
            $usuario = $listaUsuarios[0];
            //Verificamos si está habilitado (null o fecha 0000...)
            $fechaBaja = $usuario->getDesHabilitado_usuario();
            $habilitado = ($fechaBaja === null);
            if ($habilitado) {
                // Comparamos el MD5 de lo que escribió el usuario contra el MD5 guardado en la BD
                if (md5($psw) === $usuario->getPass_usuario()) {
                    
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

   public function cerrar()
{
    // Asegura que la sesión esté iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Vacía el array de sesión
    $_SESSION = [];

    // Elimina cookie de sesión si existe
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], 
            $params["domain"],
            $params["secure"], 
            $params["httponly"]
        );
    }

    // Destruye la sesión
    session_destroy();

    return true;
}

}
?>