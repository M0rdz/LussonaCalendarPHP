<?php

require_once '../modelos/Servicio.php';
require_once '../modelos/Reserva.php';

$reserva = new Reserva();

$idreserva = isset($_POST["idreserva"]) ? limpiarCadena($_POST["idreserva"]) : "";
// $idsala = isset($_POST["idsala"]) ? limpiarCadena($_POST["idsala"]) : "";
$idusuario = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$periodo = isset($_POST["periodo"]) ? limpiarCadena($_POST["periodo"]) : "";
$desde = isset($_POST["desde"]) ? limpiarCadena($_POST["desde"]) : "";
$hasta = isset($_POST["hasta"]) ? limpiarCadena($_POST["hasta"]) : "";
// $costo = isset($_POST["costo"]) ? limpiarCadena($_POST["costo"]) : "";
$descripcion = isset($_POST["descripcion"]) ? limpiarCadena($_POST["descripcion"]) : "";

switch ($_GET["op"]) {
    case 'guardaryeditar':
        // var_dump(array($idreserva, $idusuario, $periodo, $desde, $hasta, $descripcion));
        if (empty($idreserva)) {
            $rspta = $reserva->insertar($idusuario, $periodo, $desde, $hasta, $descripcion, $_POST['servicios']);
            // var_dump($rspta);
            echo $rspta ? "Reserva registrada" : "Reserva no se pudo registrar";
        } else {
            $rspta = $reserva->editar($idreserva, $idusuario, $periodo, $desde, $hasta, $descripcion, $_POST['servicios']);
            // var_dump($rspta);
            echo $rspta ? "Reserva actualizada" : "Reserva no se pudo actualizar";
        }
        break;

    case 'desactivar':
        $rspta = $reserva->desactivar($idreserva);
        echo $rspta ? "Reserva desactivada" : "Reserva no se pudos desactivar";
        break;

    case 'activar':
        $rspta = $reserva->activar($idreserva);
        echo $rspta ? "Reserva activada" : "Reserva no se pudos activar";
        break;

    case 'mostrar':
        $rspta = $reserva->mostrar($idreserva);
        // $desde = strtotime($rspta['desde']);
        // $hasta = strtotime($rspta['hasta']);
        // // var_dump(date("Y-m-d\TH:i:sP", $desde));
        // $rspta['desde'] = date("Y-m-d\TH:i:sP", $desde);
        // $rspta['hasta'] = date("Y-m-d\TH:i:sP", $hasta);
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspta = $reserva->listarTodo();
        $data = array();
        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => '<p class="text-secondary text-xs mb-1">
                      <b>Fecha Inicio: </b><time>' . date("F jS, Y", strtotime($reg->datetime_start)) . '
                    </time></p>
                    <p class="text-secondary text-xs mb-1">
                      <b>Fecha fin: </b><time>' . date("F jS, Y", strtotime($reg->datetime_end)) . '
                    </time></p>',
                "1" => '<p class="text-secondary text-xs mb-1">
                      <b>Usuario: </b>' . $reg->reserved_by . '
                    </p>
                    <p class="text-secondary text-xs mb-1 text-break">
                      <b>Descripcion: </b>' . $reg->schedule_remarks . '
                    </p>',
                "2" => ($reg->status === 1) ?
                    '<span class="badge text-xs bg-success">Activado</span>'
                    :
                    '<span class="badge text-xs bg-danger">Desactivado</span>',
                "3" => ($reg->status === 1) ?
                    '<div class="dropdown">
                            <button class="btn btn-link text-secondary mb-0" data-bs-toggle="dropdown" id="tabledropdown">
                                <span class="material-icons">
                                    more_vert
                                </span>
                            </button>
                            <ul class="dropdown-menu p-2 shadow-xxl" aria-labelledby="tabledropdown">
                                <li>
                                    <button class="dropdown-item justify-content-between" onclick="mostrar(' . $reg->id . ')">Editar</button>
                                </li>
                                <li>
                                    <button class="dropdown-item justify-content-between" onclick="desactivar(' . $reg->id . ')">Desactivar</button>
                                </li>
                            </ul>
                        </div>' :
                    '<div class="dropdown">
                            <button class="btn btn-link text-secondary mb-0" data-bs-toggle="dropdown" id="tabledropdown">
                                <span class="material-icons">
                                    more_vert
                                </span>
                            </button>
                            <ul class="dropdown-menu p-2 shadow-xxl" aria-labelledby="tabledropdown">
                                <li>
                                    <button class="dropdown-item justify-content-between" onclick="mostrar(' . $reg->id . ')">Editar</button>
                                </li>
                                <li>
                                    <button class="dropdown-item justify-content-between" onclick="activar(' . $reg->id . ')">Activar</button>
                                </li>
                            </ul>
                        </div>'
            );
        }
        $results = array(
            "sEcho" => 1, //Informacion para el datable
            "iTotalRecords" => count($data), //enviamos el total de registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);
        break;

    case 'SelectSala':

        $rspta = $reserva->selectSala();
        while ($reg = $rspta->fetch_object()) {
            // $sw = in_array($reg->idsala, $marcados) ? 'selected' : '';
            echo '<option value="' . $reg->idsala . '">' . $reg->nombre . '</option>';
        }
        break;
    case 'SelectedSala':

        $rspta = $reserva->SelectedSala();
        $id = $_GET['id'];
        $marcados = $reserva->mostrar($id);
        // var_export($marcados);
        //declaramos el array para almacenar todos los permisos marcados
        $valores = array();

        while ($reg = $rspta->fetch_object()) {
            $sw = in_array($reg->idsala, $marcados) ? 'selected' : '';
            echo '<option value="' . $reg->idsala . '" ' . $sw . '>' . $reg->nombre . '</option>';
        }
        break;

    case 'calendar':
        $rspta = $reserva->calendar();
        $data = array();

        $i = 0;
        while ($reg = $rspta->fetch_object()) {

            $data[$i] = $reg;
            $i++;
        };

        echo json_encode($data);
        break;

    case 'reservafecha':

        $desde = $_REQUEST["desde"];
        $hasta = $_REQUEST["hasta"];
        $idsala = $_REQUEST["idsala"];

        $rspta = $reserva->reservafecha($desde, $hasta, $idsala);
        $data = array();

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => $reg->desde,
                "1" => $reg->hasta,
                "2" => $reg->sala,
                "3" => $reg->costo,
                "4" => $reg->descripcion,
                "5" => $reg->periodo,
                "6" => $reg->dueño,
                "7" => ($reg->estado == '1') ?
                    '<span class="badge bg-success">Aceptado</span>'
                    :
                    '<span class="badge bg-danger">Anulado</span>'
            );
        }
        $results = array(
            "sEcho" => 1, //Informacion para el datable
            "iTotalRecords" => count($data), //enviamos el total de registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);
        break;
    case 'serviciosList':
        $servicios = new Servicio();
        $res = $servicios->pluck();

        while ($row = $res->fetch_object()) {
            // $sw = in_array($row->id, $valores) ? 'checked' : '';
            echo '<li> <input class="form-check-input" type="checkbox"  name="servicios[]" id="servicios[]" value="' . $row->id . '" />' . $row->nombre . '</li>';
        }
        break;
    case 'serviciosListed':
        $servicios = new Servicio();
        $res = $servicios->pluck();
        $id = $_GET['id'];
        $marcados = $servicios->listarmarcados($id);

        //declaramos el array para almacenar todos los permisos marcados
        $valores = array();

        //Almacenar los permisos asignados al usuario en el array
        while ($serv = $marcados->fetch_object()) {
            array_push($valores, $serv->servicio_id);
        }

        while ($row = $res->fetch_object()) {
            $sw = in_array($row->id, $valores) ? 'checked' : '';
            echo '<li> <input class="form-check-input" type="checkbox" ' . $sw . ' name="servicios[]" value="' . $row->id . '" />' . $row->nombre . '</li>';
        }
        break;
}
