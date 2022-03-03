<?php

session_start();

require_once '../modelos/Usuario.php';
require_once '../modelos/Sala.php';

$usuario = new Usuario();
$salas = new Sala();

$idusuario = isset($_POST["idusuario"]) ? limpiarCadena($_POST["idusuario"]) : "";
// $idsala = isset($_POST["idsala"]) ? limpiarCadena($_POST["idsala"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$tipo_documento = isset($_POST["tipo_documento"]) ? limpiarCadena($_POST["tipo_documento"]) : "";
$num_documento = isset($_POST["num_documento"]) ? limpiarCadena($_POST["num_documento"]) : "";
$direccion = isset($_POST["direccion"]) ? limpiarCadena($_POST["direccion"]) : "";
$telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";
$email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";
$cargo = isset($_POST["cargo"]) ? limpiarCadena($_POST["cargo"]) : "";
$login = isset($_POST["login"]) ? limpiarCadena($_POST["login"]) : "";
$clave = isset($_POST["clave"]) ? limpiarCadena($_POST["clave"]) : "";
$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";

switch ($_GET["op"]) {
    case 'guardaryeditar':

        if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
            $imagen = $_POST["imagenactual"];
        } else {
            $ext = explode(".", $_FILES["imagen"]["name"]);
            if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png") {
                $imagen = round(microtime(true)) . '.' . end($ext);
                move_uploaded_file($_FILES['imagen']['tmp_name'], "../files/usuarios/" . $imagen);
            }
        }

        //Hash SHA256 en la contraseña
        if (empty($clave)) {
            $rspta = $usuario->sinPass($idusuario, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $imagen, $_POST['permiso']);
            echo $rspta ? "Usuario actualizado" : "Usuario no se pudo actualizar";
        } else {
            $clavehash = hash("SHA256", $clave);

            if (empty($idusuario)) {
                $rspta = $usuario->insertar($nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clavehash, $imagen, $_POST['permiso']);
                echo $rspta ? "Usuario registrado" : "No se pudieron registrar todos los datos del usuario";
            } else {
                $rspta = $usuario->editar($idusuario, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clavehash, $imagen, $_POST['permiso']);
                echo $rspta ? "Usuario actualizado" : "Usuario no se pudo actualizar";
            }
        }


        break;

    case 'desactivar':
        $rspta = $usuario->desactivar($idusuario);
        echo $rspta ? "Usuario desactivado" : "Usuario no se pudo desactivar";
        break;

    case 'activar':
        $rspta = $usuario->activar($idusuario);
        echo $rspta ? "Usuario activado" : "Usuario no se pudo activar";
        break;

    case 'mostrar':
        $rspta = $usuario->mostrar($idusuario);
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspta = $usuario->listar();
        $data = array();
        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => '<div class="d-flex px-2 py-1">
                            <div>
                                <img src="../files/usuarios/' . $reg->imagen . '" class="avatar avatar-sm me-3">
                            </div>
                            <div class="d-flex flex-column justify-content-center align-items-start">
                                <h6 class="mb-0 text-xs">' . $reg->nombre . '</h6>
                                <p class="text-xs text-secondary mb-0">' . $reg->login . '</p>
                            </div>
                        </div>',
                "1" => '<p class="text-xs font-weight-bold mb-0">' . $reg->email . '</p>
                        <p class="text-xs text-secondary mb-0">(+55) ' . $reg->telefono . '</p>',
                "2" => '<p class="text-xs font-weight-bold mb-0">' . $reg->tipo_documento . '</p>
                        <p class="text-xs text-secondary mb-0">' . $reg->num_documento . '</p>',
                "3" => ($reg->condicion) ?
                    '<span class="badge bg-gradient-success">Activado</span>'
                    :
                    '<span class="badge bg-gradient-danger">Desactivado</span>',
                "4" => ($reg->condicion) ?
                    '
                        <div class="dropdown">
                            <button class="btn btn-link text-secondary mb-0" data-bs-toggle="dropdown" id="tabledropdown">
                                <span class="material-icons">
                                    more_vert
                                </span>
                            </button>
                            <ul class="dropdown-menu p-2 shadow-xxl" aria-labelledby="tabledropdown">
                                <li>
                                    <button class="dropdown-item justify-content-between" onclick="mostrar(' . $reg->idusuario . ')">Editar</button>
                                </li>
                                <li>
                                    <button class="dropdown-item justify-content-between" onclick="desactivar(' . $reg->idusuario . ')">Desactivar</button>
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
                        <ul class="dropdown-menu p-2 shadow-xxl" aria-labelledby="tabledropdown">
                            <li>
                                <button class="dropdown-item justify-content-between" onclick="mostrar(' . $reg->idusuario . ')">Editar</button>
                            </li>
                            <li>
                                <button class="dropdown-item justify-content-between" onclick="activar(' . $reg->idusuario . ')">Activar</button>
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

    case 'permisos':
        //obtenemos los permisos de la tabla permisos
        require_once '../modelos/Permiso.php';
        $permiso = new Permiso();
        $rspta = $permiso->listar();

        //Obtener los permisos del usuario
        $id = $_GET['id'];
        $marcados = $usuario->listarmarcados($id);

        //declaramos el array para almacenar todos los permisos marcados
        $valores = array();

        //Almacenar los permisos asignados al usuario en el array
        while ($per = $marcados->fetch_object()) {
            array_push($valores, $per->idpermiso);
        }

        while ($reg = $rspta->fetch_object()) {
            $sw = in_array($reg->idpermiso, $valores) ? 'checked' : '';

            echo '<li> 
                        <input type="checkbox" class="form-check-input" ' . $sw . ' name="permiso[]" value="' . $reg->idpermiso . '">'
                . $reg->nombre .
                '</li>';
        }
        break;

    case 'verificar':
        $logina = $_POST['logina'];
        $clavea = $_POST['clavea'];

        //Desencriptar clave SHA256
        $clavehash = hash("SHA256", $clavea);

        $rspta = $usuario->verificar($logina, $clavehash);
        // var_export($rspta);
        $fetch = $rspta->fetch_object();

        if (isset($fetch)) {
            //Declarando variables de session
            // new AuthController($fetch->nombre, $fetch->imagen, $fetch->login, $fetch->idusuario);
            $_SESSION['idusuario'] = $fetch->idusuario;
            $_SESSION['nombre'] = $fetch->nombre;
            $_SESSION['imagen'] = $fetch->imagen;
            $_SESSION['login'] = $fetch->login;
            // $_SESSION['idsala'] = $fetch->departamento_id;

            //Obtenemos los permisos del usuario
            $permisos = $usuario->listarmarcados($fetch->idusuario);

            //Array para almacenar los permisos
            $valores = array();

            while ($per = $permisos->fetch_object()) {
                array_push($valores, $per->idpermiso);
            }

            //Determinando los accesos del usuario
            in_array(1, $valores) ? $_SESSION['listar-usuarios'] = 1 : $_SESSION['listar-usuarios'] = 0;
            in_array(2, $valores) ? $_SESSION['crear-reserva'] = 1 : $_SESSION['crear-reserva'] = 0;
            in_array(3, $valores) ? $_SESSION['listar-reservas'] = 1 : $_SESSION['listar-reservas'] = 0;
            // in_array(4, $valores) ? $_SESSION['reportes-generales'] = 1 : $_SESSION['reportes-generales'] = 0;
            in_array(5, $valores) ? $_SESSION['listar-departamentos'] = 1 : $_SESSION['listar-departamentos'] = 0;
            in_array(6, $valores) ? $_SESSION['reservas-usuarios'] = 1 : $_SESSION['reservas-usuarios'] = 0;
            in_array(7, $valores) ? $_SESSION['listar-servicios'] = 1 : $_SESSION['listar-servicios'] = 0;
            in_array(8, $valores) ? $_SESSION['crear-servicios'] = 1 : $_SESSION['crear-servicios'] = 0;
            in_array(9, $valores) ? $_SESSION['editar-reservas'] = 1 : $_SESSION['editar-reservas'] = 0;
        }

        echo json_encode($fetch); //Retornando JSON
        break;

    case 'salir':
        session_unset(); //Limpiamos las variables de sesion
        session_destroy(); //Destriumos la sesion
        header("Location: ../index.php");
        break;
    case 'selectUsuarios':
        # code...
        // echo($usuario->listar())
        $res = $usuario->listar();
        // $ssalas = $salas->listar();
        while ($u = $res->fetch_object()) {
            echo '<option value="' . $u->idusuario . '">' . $u->nombre . '</option>';
        }

        break;
}
