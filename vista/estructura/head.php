<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ponete Las Pilas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <?php
        include_once('ruta.php');
        $ruta=ruta();
        include_once('../control/Session.php');
        $objSession = new Session();
        $rolesUsuarioSimple = [];
        if ($objSession->activa()) {
            // 1. Session busca en la BD (usando ABMUsuarioRol y Rol)
            $listaRolesObjetos = $objSession->getRol(); 

            // 2. Convertimos OBJETOS a TEXTO para que JS lo entienda
            foreach ($listaRolesObjetos as $objRol) {
                // Usamos el método getDescripcion_rol() que vi en tu clase Rol.php
                $rolesUsuarioSimple[] = $objRol->getDescripcion_rol(); 
            }
        }
    
        // 3. Convertimos a formato JSON (Ej: '["SuperUsuario", "Cliente"]')
        $jsonRoles = json_encode($rolesUsuarioSimple);
    ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            
            // 1. INYECCIÓN PHP -> JS
            // Aquí PHP "escribe" el array directamente en el código JS del navegador.
            const misRoles = <?php echo $jsonRoles; ?>; 
            
            console.log("🕵️ Roles detectados en esta sesión:", misRoles);
        
            // 2. Definimos qué roles son "Jefes" (Ajusta los nombres EXACTOS de tu BD)
            const rolesDeAdmin = ['SuperUsuario', 'Administrador', 'Stock'];
        
            // 3. Verificamos si hay coincidencia
            // ¿Alguno de "misRoles" está incluido en "rolesDeAdmin"?
            const esAdmin = misRoles.some(rol => rolesDeAdmin.includes(rol));
        
            // 4. Mostramos el botón
            const adminBtn = document.getElementById('admin-menu-toggle');
            if (esAdmin && adminBtn) {
                adminBtn.style.display = 'block'; // Aparece el botón
                
                // Opcional: Agregar funcionalidad al clic
                adminBtn.addEventListener('click', function() {
                    // Redirigir a tu panel o abrir el menú lateral
                    window.location.href = '../vista/adminUser.php'; 
                });
            }
        });
    </script>
    <link rel="icon" href="<?=$ruta?>/vista/imagenes/logo.png" type="image/png">
    <link rel="stylesheet" href="<?php echo $ruta?>/vista/css/estilos.css">