$(function () {
    $.post(
        "../ajax/reserva.php?op=selectedSala", {
        idreserva: idreserva
    }
    )
})
function mostrar(idreserva) {
    $.post(
        "../ajax/reserva.php?op=mostrar",
        { idreserva: idreserva },
        function (data, status) {
            data = JSON.parse(data);
            mostrarform(true);

            $("#idsala").val(data.idsala);
            $("#idreserva").val(data.idreserva);
            $("#nombre").val(data.nombre);
            $("#periodo").val(data.periodo);
            $("#desde").val(data.desde);
            $("#hasta").val(data.hasta);
            $("#costo").val(data.costo);
            $("#descripcion").val(data.descripcion);
        }
    );
    $.post(
        "../ajax/usuario.php?op=servicios&id=" + idreserva,
        function (data) {
            $("#servicios").html(data);
        }
    );
}