document.addEventListener('DOMContentLoaded', () => {
    
    // 1. Contador y Simulación de "Añadir al Carrito"
    const addToCartBtns = document.querySelectorAll('.add-to-cart');
    const cartCount = document.getElementById('cart-count');
    let count = 0;

    addToCartBtns.forEach(button => {
        button.addEventListener('click', () => {
            // Lógica de Llama a tu controlador/API de PHP para añadir el producto real
            const productId = button.getAttribute('data-product-id');
            console.log(`Añadiendo producto ID: ${productId} - Lógica backend pendiente.`);

            // Actualización visual del contador (solo frontend)
            count++;
            if (cartCount) {
                cartCount.textContent = count;
            }
            
            // Opcional: Abrir el carrito (Offcanvas) para mostrar la adición
            // Necesitas acceder a la instancia de Offcanvas de Bootstrap
            const cartOffcanvasEl = document.getElementById('cartOffcanvas');
            const cartOffcanvas = bootstrap.Offcanvas.getInstance(cartOffcanvasEl) || new bootstrap.Offcanvas(cartOffcanvasEl);
            cartOffcanvas.show();
        });
    });
/*
    // 2. Lógica de Roles (Manejo del botón de Admin con tu lógica PHP/JS)
    // El botón de Admin DEBE ser ocultado por defecto y solo mostrarse si hay un usuario logueado con rol de administrador.
    const adminToggleBtn = document.getElementById('admin-menu-toggle');
    
    // Ejemplo: función que tu PHP llamaría después de un login exitoso
    window.updateAdminMenuVisibility = (userRole) => {
        if (userRole === 'SuperUsuario' || userRole === 'Stock' || userRole === 'Precio') {
             adminToggleBtn.style.display = 'block'; // Mostrar
             // Aquí también generarías dinámicamente los <li> del Offcanvas Admin
        } else {
             adminToggleBtn.style.display = 'none'; // Ocultar
        }
    };

    // Inicialmente, ocultamos el botón de Admin si no hay una sesión activa.
    if (adminToggleBtn) {
        // Inicialmente oculto (tu CSS puede manejar esto o un script de PHP al inicio)
        adminToggleBtn.style.display = 'none'; 
    }
*/
});

