<?php
include_once('../control/ABMMenuRol.php');
include_once('../modelo/Menu.php');
// Recuperamos los roles 
$rolesUsuarioSimple = [];
$menuSegunRol=[];
$ejemplo=[];
//$_SESSION=[];
if ($objSession->activa()) {
    $listaRolesObjetos = $objSession->getRol();
    foreach ($listaRolesObjetos as $objRol) {
        $objMenuRol=new ABMMenuRol();
        $param['idrol']=$objRol->getId_rol();
        $menuRol=$objMenuRol->buscar($param);
        array_push($menuSegunRol, $menuRol);
        $rolesUsuarioSimple[]=$objRol->getId_rol();
    }
    if(count($menuSegunRol)>0){
        foreach($menuSegunRol as $objMenuRol){
            for($i=0; $i<count($objMenuRol); $i++){
                $objMenu=$objMenuRol[$i]->getObjMenu();
                $variable=$objMenu->getMeDescripcion();
                array_push($ejemplo, $variable);
            }
        }
    }
    else{
        $ejemplo="No trae nada";
    }
}
// Preparamos el array JSON para el JavaScript
$jsonRoles = json_encode($rolesUsuarioSimple);
$jsonRolesMenu=json_encode($ejemplo);
?>

<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand text-warning fw-bold fs-4" href="<?= $ruta ?>/vista/index.php">
                <i class="bi bi-lightning-charge-fill me-2"></i>Ponete Las Pilas
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#categoryNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="categoryNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="<?= $ruta ?>/vista/index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= $ruta ?>/vista/productoAA.php">Pilas AA</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= $ruta ?>/vista/productoAAA.php">Pilas AAA</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= $ruta ?>/vista/pruductoEspeciales.php">Especiales</a></li>
                </ul>

                <div class="d-flex align-items-center">
                    <button class="btn btn-outline-warning me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas">
                        <i class="bi bi-cart-fill"></i> <span class="d-none d-md-inline">Carrito</span> (<span id="cart-count">0</span>)
                    </button>
                    
                    <?php if (!$objSession->activa()): ?>
                    <a href="<?= $ruta ?>/vista/login.php" class="btn btn-primary me-2">
                        <i class="bi bi-person-circle"></i> Ingresar
                    </a>
                    <?php endif; ?>
                    <?php if ($objSession->activa()): ?>    
                    <button class="btn btn-warning me-2" type="button" id="admin-menu-toggle" style="display:block;" 
                        data-bs-toggle="offcanvas" data-bs-target="#adminOffcanvas">
                        <i class="bi bi-gear-fill"></i> <?php echo $objSession->activa() ? $_SESSION['usnombre'] : 'Invitado'; ?>
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
</header>

<div class="offcanvas offcanvas-end bg-dark text-white" tabindex="-1" id="adminOffcanvas" aria-labelledby="adminOffcanvasLabel">
    <div class="offcanvas-header border-bottom border-secondary">
        <h5 class="offcanvas-title" id="adminOffcanvasLabel">
            <i class="bi bi-person-workspace me-2 text-warning"></i> Panel de Control
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="mb-4 text-center">
            <i class="bi bi-person-circle" style="font-size: 3rem;"></i>
            <p class="mt-2 fw-bold text-warning">
                <?php echo $objSession->activa() ? $_SESSION['usnombre'] : 'Invitado'; ?>
            </p>
            <p class="text-muted small">
                <?php echo implode(", ", $rolesUsuarioSimple); ?>
            </p>
        </div>

        <ul class="list-group list-group-flush rounded">
        <!--    ejemplo del manejo del menú dinámico
                        en el href pongo la ruta (la guardo en la descripcion  de la clase menu)
                        al lado del botón pongo el nombre del menu
                        trato de agregar una seccion para el icono (luego agrego alguno predeterminado para nuevos menus)
        foreach($menues as $menu){
                if($menu->menuHabilitado()){
                <li class="list-group-item bg-dark text-white border-secondary">
                    <a href="<?php  //echo $ruta  ?> /vista/index.php" class="text-decoration-none text-light d-block">
                        <i class="bi bi-speedometer2 me-2"></i> $menu->nombre
                    </a>
                </li>    
                }
            }
                    -->
            <?php if (count($rolesUsuarioSimple) > 0): ?>
                <li class="list-group-item bg-dark text-white border-secondary">
                    <a href="<?= $ruta ?>/vista/index.php" class="text-decoration-none text-light d-block">
                    <i class="bi bi-speedometer2 me-2"></i> Inicio
                    </a>
                </li>
            <?php endif; ?>
            <?php
            foreach($menuSegunRol as $menu){
                if(isset($menu[0])){
                    for($i=0; $i<count($menu); $i++){
                        $objMenu=$menu[$i]->getObjMenu();
                        if(!$objMenu->getMeDeshabilitado()){
                            ?> 
                            <li class="list-group-item bg-dark text-white border-secondary">
                                <a href="<?php  echo $ruta.$objMenu->getMeDescripcion() ?>" class="text-decoration-none text-light d-block">
                                <i class="<?php  echo $objMenu->getIconoBootstrap() ?>"></i> <?php  echo $objMenu->getMeNombre() ?>
                                </a>
                            </li>
                        <?php
                        }
                    }
                }
            }
            ?> 
        </ul>

        <div class="mt-auto pt-5">
            <a href="<?= $ruta ?>/vista/accion/cerrarSesion.php" class="btn btn-danger w-100">
                <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Inyectamos el array de roles
        const misRoles = <?php echo $jsonRoles; ?>;
        const RolesMenu = <?php echo $jsonRolesMenu; ?>;
        console.log('roles de usuario', misRoles);
        console.log('menuRol: ', RolesMenu);
        // Roles permitidos (los puse a mano))
        const rolesDeAdmin = ['Root', 'Administrador', 'Cliente'];
        
        // Verificamos coincidencia
        const esAdmin = misRoles.some(rol => rolesDeAdmin.includes(rol));
        
        const adminBtn = document.getElementById('admin-menu-toggle');
        

    });
</script>