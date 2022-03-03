$("#frmAcceso").on('submit', function (e) {
    e.preventDefault();
    logina = $("#logina").val();
    clavea = $("#clavea").val();
    $.post("../ajax/usuario.php?op=verificar",
        {
            logina: logina,
            clavea: clavea
        },
        function (data) {
            // bootbox.alert(data)
            if (data != 'null') {
                console.log(data)
                $(location).attr('href', './escritorio.php');
            }
            else {

                return bootbox.alert({
                    title: "ERROR",
                    message: "<b>Usuario</b> o <b>contraseña</b> incorrecta",
                    size: "sm"
                });
            }
        }
    );
})