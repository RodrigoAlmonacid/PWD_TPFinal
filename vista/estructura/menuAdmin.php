<div class="offcanvas offcanvas-end bg-secondary text-white" tabindex="-1" id="adminOffcanvas" aria-labelledby="adminOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="adminOffcanvasLabel">
            <i class="bi bi-person-workspace me-2"></i> Menú de Administración
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="list-group list-group-flush">
            <li class="list-group-item bg-secondary"><a href="/admin/dashboard" class="text-white text-decoration-none">Dashboard</a></li>
            <li class="list-group-item bg-secondary"><a href="<?= $ruta ?>/vista/adminUser.php" class="text-white text-decoration-none">Gestión de Usuarios (Super)</a></li>
            <li class="list-group-item bg-secondary"><a href="/admin/stock" class="text-white text-decoration-none">Control de Stock (Stock)</a></li>
            <li class="list-group-item bg-secondary"><a href="/admin/precios" class="text-white text-decoration-none">Gestión de Precios (Precio)</a></li>
        </ul>
        <div class="mt-4">
            <button class="btn btn-danger w-100">
                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
            </button>
        </div>
    </div>
</div>