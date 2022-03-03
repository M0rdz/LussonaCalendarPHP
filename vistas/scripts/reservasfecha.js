var tabla;

//Funcion que se ejecuta al inicio
function init()
{
    listar();

    //Cargamos los items al select proveedor
    $.post("../ajax/reserva.php?op=SelectSala", function (r) {
        $("#idsala").html(r);
        $('#idsala').selectpicker('refresh');
    });	

}

function listar()
{
    var desde = $("#desde").val();
    var hasta = $("#hasta").val();
    var idsala = $("#idsala").val();

    tabla = $('#tblistado')
        .dataTable(
            {
                "aProcessing":true, //Activamos el procesamiento del datatables
                "aServerSide":true, //Paginacion y filtrado realizados por el servidor
                dom: "Bfrtip", //Definimos los elementos del control de tabla
                buttons:[
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdf'
                ],
                "ajax":{
                    url: '../ajax/reserva.php?op=reservafecha',
                    data:{desde:desde, hasta:hasta,idsala:idsala},
                    type: "get",
                    dataType:"json",
                    error: function(e) {
                        console.log(e.responseText);
                    }
                },
                "bDestroy": true,
                "iDisplayLength": 5, //Paginacion
                "order": [[0,"desc"]] //Ordenar (Columna, orden)
            
            })
        .DataTable();
}


init();