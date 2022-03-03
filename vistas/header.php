<?php
if (strlen(session_id()) < 1) //Si la variable de session no esta iniciada
{
  session_start();
}
require_once '../config/global.php';

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= PRO_NOMBRE ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/material-dashboard.min.css" rel="stylesheet" />
  <link rel="apple-touch-icon" href="../public/img/apple-touch-icon.png">
  <link rel="shortcut icon" href="../public/img/lussona-logo-c.png">

  <!--DATATABLES-->
  <link rel="stylesheet" href="../public/datatables/jquery.dataTables.min.css">
  <link rel="stylesheet" href="../public/datatables/buttons.dataTables.min.css">
  <link rel="stylesheet" href="../public/datatables/responsive.dataTables.min.css">
  <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.4/datatables.min.css" />

  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.4/datatables.min.js"></script> -->

  <!-- <link rel="stylesheet" href="../public/css/bootstrap-select.min.css"> -->


  <style>
    tbody>tr {
      text-align: center;
    }
  </style>

  <!-- fullCalendar -->
  <link rel="stylesheet" href="../plugins/fullcalendar/main.css">
</head>

<body class="g-sidenav-show  bg-gray-200">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="#" target="_blank">
        <span class="ms-1 font-weight-bold text-white"><?= PRO_NOMBRE ?></span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto  vh-100" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-white" href="escritorio.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <?php
        if ($_SESSION['listar-reservas'] === 1) {
          echo '<li class="nav-item">
            <a class="nav-link text-white " href="listareserva.php">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">table_view</i>
              </div>
              <span class="nav-link-text ms-1">Mis reservas</span>
            </a>
          </li>';
        }
        if ($_SESSION['editar-reservas'] === 1) {
          echo '<li class="nav-item">
            <a class="nav-link text-white " href="reserva.php">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">phone</i>
              </div>
              <span class="nav-link-text ms-1">Lista de reservas</span>
            </a>
          </li>';
        }
        if ($_SESSION['crear-reserva'] === 1) {
          echo '<li class="nav-item">
            <a class="nav-link text-white " href="reservas.php">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">calendar_view_day</i>
              </div>
              <span class="nav-link-text ms-1">Crear reserva</span>
            </a>
          </li>';
        }
        if ($_SESSION['listar-usuarios'] === 1) {
          echo '<li class="nav-item">
            <a class="nav-link text-white " href="usuario.php">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">person</i>
              </div>
              <span class="nav-link-text ms-1">Lista de usuarios</span>
            </a>
          </li>';
        }
        if ($_SESSION['listar-departamentos'] === 1) {
          echo '<li class="nav-item">
            <a class="nav-link text-white " href="lista_salas.php">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">build</i>
              </div>
              <span class="nav-link-text ms-1">Lista de departamentos</span>
            </a>
          </li>';
        }
        if ($_SESSION['listar-servicios'] === 1) {
          echo '<li class="nav-item">
            <a class="nav-link text-white " href="listaservicios.php">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">build</i>
              </div>
              <span class="nav-link-text ms-1">Lista de servicios</span>
            </a>
          </li>';
        }
        ?>
      </ul>
    </div>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-md ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <h6 class="font-weight-bolder mb-0">Lussona</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group input-group-outline">
              <label class="form-label">Type here...</label>
              <input type="text" class="form-control">
            </div>
          </div>
          <div class="navbar-nav justify-content-end">
            <li class="nav-item d-flex dropdown align-items-center">
              <a href="javascript:;" class="nav-link text-body font-weight-bold px-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none">
                  <?php echo $_SESSION['nombre']; ?>
                </span>
              </a>
              <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item border-radius-md" href="../ajax/usuario.php?op=salir">
                  <div class="d-flex py-1">
                    <div class="my-auto">
                      <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="avatar avatar-sm bg-gradient-dark  me-3 ">
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="text-sm font-weight-normal mt-2">
                        <span class="font-weight-bold">Logout</span>
                      </h6>
                    </div>
                  </div>
                </a>
              </ul>
            </li>
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
          </div>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row min-vh-80 h-100">
        <div class="col-12">