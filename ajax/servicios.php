<?php

session_start();
require_once '../modelos/Servicio.php';

$servicio = new Servicio();

$id = isset($_POST['id']) ? limpiarCadena($_POST['id']) : "";
$nombre = isset($_POST['nombre']) ? limpiarCadena($_POST['nombre']) : "";
$descripcion = isset($_POST['descripcion']) ? limpiarCadena($_POST['descripcion']) : "";
$costehora = isset($_POST['costehora']) ? limpiarCadena($_POST['costehora']) : "";

switch ($_GET["op"]) {
	case "guardaryeditar":
		if (empty($id)) {
			$consulta = $servicio->store($nombre, $descripcion, $costehora);
			echo $consulta ? 'Servicio guardado correctamente!! ✔' : 'Ha ocurrido un error!! ❌';
		} else {
			$consulta = $servicio->update($id, $nombre, $descripcion, $costehora);
			echo $consulta ? 'Servicio actualizado correctamente!! ✔' : 'Ha ocurrido un error!! ❌';
		}
		break;

	case "mostrar":
		$consulta = $servicio->show($id);
		echo json_encode($consulta);
		break;
	case 'listar':
		# code...
		$res = $servicio->index();
		$data = array();
		while ($row = $res->fetch_object()) {
			$data[] = array(
				'0' => $row->nombre,
				'1' => $row->descripcion,
				'2' => $row->costehora,
				'3' => '
					<div class="dropdown">
            <button class="btn btn-link text-secondary mb-0" data-bs-toggle="dropdown" id="tabledropdown">
                <span class="material-icons">
                    more_vert
                  </span>
                </button>
                <ul class="dropdown-menu p-2 shadow-xxl" aria-labelledby="tabledropdown">
                  <li>
                    <button class="dropdown-item justify-content-between" id="btnEdit" onclick="mostrar(' . $row->id . '?>)">Editar</button>
                  </li>
                </ul>
              </div> 
            </td>'
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
