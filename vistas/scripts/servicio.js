var tabla;

//Funcion que se ejecuta al inicio
$(function () {
    mostrarForm(false);
    listar();

    $("#frm-servicio").on("submit", function (e) {
        saveEdit(e);
    })
})

//funcion limpiar
function limpiar() {
    $("#id").val("");
    $("#nombre").val("");
    $("#descripcion").val("");
    $("#costehora").val("");

    $("#nombre").parent().removeClass("is-filled");
    $("#descripcion").parent().removeClass("is-filled");
    $("#costehora").parent().removeClass("is-filled");
}

//funcion mostrar formulario
function mostrarForm(flag) {
    limpiar();

    if (flag) {
        $("#serviceList").hide();
        $("#formPane").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
    }
    else {
        $("#serviceList").show();
        $("#formPane").hide();
        $("#btnagregar").show();
    }
}

//Funcion cancelarform
function cancelarForm() {
    limpiar();
    mostrarForm(false);
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
                url: '../ajax/servicios.php?op=listar',
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
function saveEdit(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#frm-servicio")[0]);

    $.ajax({
        url: "../ajax/servicios.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            //console.log("succes");
            bootbox.alert(datos);
            mostrarForm(false);
            tabla.ajax.reload();
        },
        error: function (error) {
            console.log("error: " + error);
        }
    });

    limpiar();
}

function mostrar(id) {
    $.post(
        "../ajax/servicios.php?op=mostrar",
        { id: id },
        function (data, status) {
            data = JSON.parse(data);
            mostrarForm(true);
            $("#nombre").parent().addClass("is-filled");
            $("#descripcion").parent().addClass("is-filled");
            $("#costehora").parent().addClass("is-filled");

            $("#nombre").val(data.nombre);
            $("#costehora").val(data.costehora);
            $("#descripcion").val(data.descripcion);
            $("#id").val(data.id);
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