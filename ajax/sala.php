<?php

require_once '../modelos/Sala.php';

$sala = new Sala();

$idsala = isset($_POST["idsala"]) ? limpiarCadena($_POST["idsala"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$ubicacion = isset($_POST["ubicacion"]) ? limpiarCadena($_POST["ubicacion"]) : "";
$descripcion = isset($_POST["descripcion"]) ? limpiarCadena($_POST["descripcion"]) : "";
$idusuario = isset($_POST["usuarios"]) ? limpiarCadena($_POST["usuarios"]) : "";

switch ($_GET["op"]) {
    case 'guardaryeditar':
        if (empty($idsala)) {
            $rspta = $sala->insertar($nombre, $ubicacion, $descripcion, $idusuario);
            echo $rspta ? "Sala registrada" : "Sala no se pudo registrar";
        } else {
            $rspta = $sala->editar($idsala, $nombre, $ubicacion, $descripcion, $idusuario);
            echo $rspta ? "Sala actualizada" : "Sala no se pudo actualizar";
        }
        break;

    case 'desactivar':
        $rspta = $sala->desactivar($idsala);
        echo $rspta ? "sala desactivada" : "sala no se pudos desactivar";
        break;

    case 'activar':
        $rspta = $sala->activar($idsala);
        echo $rspta ? "sala activada" : "sala no se pudos activar";
        break;

    case 'mostrar':
        $rspta = $sala->mostrar($idsala);
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspta = $sala->listar();
        // var_dump($rspta->fetch_object());
        $data = array();
        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => '<span class="text-xs justify-self-center">' . $reg->nombre . '</span>',
                "1" => '<span class="text-xs justify-self-center">' . $reg->ubicacion . '</span>',
                "2" => '<span class="text-xs justify-self-center">' . $reg->descripcion . '</span>',
                "3" => '<span class="text-xs justify-self-center">' . $reg->usuario . '</span>',
                "4" => ($reg->condicion) ?
                    '<span class="badge bg-success justify-self-center">Activado</span>'
                    :
                    '<span class="badge bg-danger justify-self-center">Desactivado</span>',
                "5" => ($reg->condicion) ?
                    '
                        <div class="dropdown">
    <button class="btn btn-link text-secondary mb-0" data-bs-toggle="dropdown" id="tabledropdown">
        <span class="material-icons">
            more_vert
        </span>
    </button>
    <ul class="dropdown-menu p-2" aria-labelledby="tabledropdown">
        <li>
            <button class="dropdown-item justify-content-between" onclick="mostrar(' . $reg->idsala . ')">Editar <span class="badge bg-secondary"><i class="fa fa-pencil"></i></span></button>
        </li>
        <li>
            <button class="dropdown-item justify-content-between" onclick="desactivar(' . $reg->idsala . ')">Desactivar <span class="badge bg-secondary"><i class="fa fa-close"></i></span></button>
        </li>
    </ul>
</div>
                    '
                    :
                    '
                    <div class="dropdown">
    <button class="btn btn-link text-secondary mb-0" data-bs-toggle="dropdown" id="tabledropdown">
        <span class="material-icons">
            more_vert
        </span>
    </button>
    <ul class="dropdown-menu p-2" aria-labelledby="tabledropdown">
        <li>
            <button class="dropdown-item justify-content-between" onclick="mostrar(' . $reg->idsala . ')">Editar <span class="badge bg-secondary"><i class="fa fa-pencil"></i></span></button>
        </li>
        <li>
            <button class="dropdown-item justify-content-between" onclick="activar(' . $reg->idsala . ')">Activar  <span class="badge bg-secondary"><i class="fa fa-check"></i></span></button>
        </li>
    </ul>
</div>
                    ',
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
}
