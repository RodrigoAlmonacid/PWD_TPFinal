// --- Funciones del Carrito (Solo Frontend/AJAX) ---

document.addEventListener('DOMContentLoaded', () => {
    
    // Función genérica para enviar actualizaciones al servidor
    const updateCartItem = (productId, newQuantity) => {
        console.log(`AJAX: Producto ID ${productId} actualizado a cantidad: ${newQuantity}`);
        
        // ⚠️ Aquí es donde harías una llamada AJAX a tu controlador PHP:
        /*
        fetch('/carrito/update', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ id: productId, cantidad: newQuantity })
        })
        .then(response => response.json())
        .then(data => {
            // Actualizar los totales de la página con la respuesta del servidor (data.newTotal, etc.)
            console.log('Respuesta del servidor:', data);
            // location.reload(); // O actualizas los valores sin recargar
        })
        .catch(error => console.error('Error al actualizar:', error));
        */
       
       // Por ahora, solo simula la acción
       alert(`El carrito se actualizará al cambiar el producto ID ${productId} a ${newQuantity}.`);
    };

    // 1. Manejo de Botones de Cantidad (+ / -)
    const cartContainer = document.querySelector('.table-responsive');

    if (cartContainer) {
        cartContainer.addEventListener('click', (e) => {
            const btn = e.target;
            const isDecrease = btn.classList.contains('btn-decrease');
            const isIncrease = btn.classList.contains('btn-increase');
            
            if (isDecrease || isIncrease) {
                const inputGroup = btn.closest('.input-group');
                const input = inputGroup.querySelector('.quantity-input');
                let quantity = parseInt(input.value);
                const productId = input.getAttribute('data-product-id');

                if (isDecrease && quantity > 1) {
                    quantity--;
                } else if (isIncrease) {
                    quantity++;
                } else if (isDecrease && quantity === 1) {
                    // Puedes preguntar si quiere eliminar si llega a 0
                    if(confirm("¿Quieres eliminar este producto del carrito?")) {
                       // Llama a la función de eliminación
                       // removeCartItem(productId);
                       return;
                    }
                }
                
                input.value = quantity;
                updateCartItem(productId, quantity);
            }
        });
    }

    // 2. Manejo de Botón Eliminar
    const removeBtns = document.querySelectorAll('.btn-remove');
    removeBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const productId = btn.getAttribute('data-product-id');
            if (confirm("¿Estás seguro de que quieres eliminar este producto?")) {
                console.log(`AJAX: Eliminando producto ID ${productId}`);
                // Aquí harías la llamada AJAX al endpoint /carrito/remove/{id}
                // Si la eliminación es exitosa, eliminas la fila de la tabla (btn.closest('tr').remove();)
                alert(`Producto ID ${productId} eliminado. Recarga la página para ver el cambio real.`);
            }
        });
    });

    // 3. Manejo de Código de Descuento (Simulación)
    const applyCouponBtn = document.getElementById('applyCoupon');
    const couponInput = document.getElementById('couponCode');

    if (applyCouponBtn) {
        applyCouponBtn.addEventListener('click', () => {
            const code = couponInput.value.trim();
            if (code) {
                console.log(`AJAX: Aplicando código de descuento: ${code}`);
                // Llamada AJAX a /cupones/aplicar con el código
                alert(`Simulación: Aplicando código ${code}.`);
            } else {
                alert('Ingresa un código válido.');
            }
        });
    }
});