var tabla;

//Funcion que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();

    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    })
    $.post("../ajax/usuario.php?op=selectUsuarios", function (data) {
        $("#usuarios").html(data)
    })
}

//funcion limpiar
function limpiar() {
    $("#idsala").val("");
    $("#nombre").val("");
    $("#ubicacion").val("");
    $("#descripcion").val("");
    $("#idusuario").val("");
}

//funcion mostrar formulario
function mostrarform(flag) {
    limpiar();

    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
    }
    else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}

//Funcion cancelarform
function cancelarform() {
    limpiar();
    mostrarform(false);
}

//Funcion listar
function listar() {
    tabla = $('#tblistado')
        .dataTable({
            "aProcessing": true, //Activamos el procesamiento del datatables
            "aServerSide": true, //Paginacion y filtrado realizados por el servidor
            dom: "Bfrtip", //Definimos los elementos del control de tabla
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdf'
            ],
            "ajax": {
                url: '../ajax/sala.php?op=listar',
                type: "get",
                dataType: "json",
                error: function (e) {
                    console.log(e.responseText);
                    $("#feedback").html(e.responseText)
                }
            },
            "bDestroy": true,
            "iDisplayLength": 5, //Paginacion
            "order": [[0, "desc"]] //Ordenar (Columna, orden)

        })
        .DataTable();
}

//funcion para guardar o editar
function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/sala.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            //console.log("succes");
            bootbox.alert(datos);
            mostrarform(false);
            tabla.ajax.reload();
        },
        error: function (error) {
            console.log("error: " + error);
        }
    });

    limpiar();
}

function mostrar(idsala) {
    $.post(
        "../ajax/sala.php?op=mostrar",
        { idsala: idsala },
        function (data, status) {
            data = JSON.parse(data);
            mostrarform(true);
            console.log(data);
            $("#nombre").val(data.nombre);
            $("#ubicacion").val(data.ubicacion);
            $("#descripcion").val(data.descripcion);
            $("#idsala").val(data.idsala);
            $("#usuarios").val(data.usuario);

        }
    );
}

//funcion para descativar salas
function desactivar(idsala) {
    bootbox.confirm("¿Estas seguro de desactivar la sala?", function (result) {
        if (result) {
            $.post(
                "../ajax/sala.php?op=desactivar",
                { idsala: idsala },
                function (e) {
                    bootbox.alert(e);
                    tabla.ajax.reload();
                }
            );
        }
    });
}

function activar(idsala) {
    bootbox.confirm("¿Estas seguro de activar la sala?", function (result) {
        if (result) {
            $.post(
                "../ajax/sala.php?op=activar",
                { idsala: idsala },
                function (e) {
                    bootbox.alert(e);
                    tabla.ajax.reload();

                }
            );
        }
    });
}

init();