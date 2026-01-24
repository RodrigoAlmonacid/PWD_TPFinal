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
//manejo de los botones + - y x 
$(document).ready(function () {

    // --- SUMAR O RESTAR CANTIDAD ---
    $('.btn-increase, .btn-decrease').on('click', function () {
        const btn = $(this);
        const idItem = btn.data('iditem');
        const esSuma = btn.hasClass('btn-increase');
        const delta = esSuma ? 1 : -1;
        $.ajax({
            url: 'accion/actualizarCantidad.php',
            type: 'POST',
            data: { idcompraitem: idItem, delta: delta },
            dataType: 'json',
            success: function (res) {
                if (res.exito) {
                    location.reload(); // Recargamos para actualizar subtotales y total
                } else {
                    alert(res.msg || "Error al actualizar");
                }
            }
        });
    });

    // --- ELIMINAR ITEM (La X) ---
    $('.btn-remove').on('click', function () {
        const btn = $(this);
        const idItem = btn.data('iditem');
        const idCompra = btn.data('idcompra');

        if (confirm('¿Deseas quitar este producto del carrito?')) {
            $.ajax({
                url: 'accion/eliminarItemCarrito.php',
                type: 'POST',
                data: { idcompraitem: idItem, idcompra: idCompra },
                dataType: 'json',
                success: function (res) {
                    if (res.exito) {
                        location.reload();
                    }
                }
            });
        }
    });
});