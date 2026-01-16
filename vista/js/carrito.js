// --- Funciones del Carrito (Solo Frontend/AJAX) ---

document.addEventListener('DOMContentLoaded', () => {
    
$('#btnFinalizar').click(function() {
    if(confirm("¿Confirmar el pedido? Ya no podrás editar las cantidades.")){
        $.ajax({
            url: 'accion/finalizarCarrito.php',
            type: 'POST',
            data: { idcompra: idDeLaCompraActual },
            success: function(response) {
                // Redirigir a una página de "Gracias por tu compra"
                window.location.href = 'pedidoEnviado.php';
            }
        });
    }
});
});