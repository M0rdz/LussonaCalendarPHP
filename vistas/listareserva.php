<?php
//Activacion de almacenamiento en buffer
ob_start();
//iniciamos las variables de session
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: sign-in.php");
} else  //Agrega toda la vista
{
  require 'header.php';
  if ($_SESSION['listar-reservas'] === 1) {
    require('../modelos/Reserva.php');
    $reserva = new Reserva();
    $respuesta = $reserva->listar();
?>
    <div class="card my-4">
      <div class="card-header p-2 pt-2">
        <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
          <i class="material-icons opacity-10">weekend</i>
        </div>
        <div class="text-end pt-1">
          <p class="text-sm text-capitalize mb-0">Lista de reservas</p>
          <h4 class="mb-0">+<?= $respuesta->num_rows ?></h4>
        </div>
      </div>
      <div class="card-body px-2 pb-2">
        <table id="tblistado" class="table table-responsive table-sm py-4 px-3">
          <thead>
            <tr>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">Departamento</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">Reservado por</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">Fecha </th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($respuesta->num_rows > 0) {
              while ($row = $respuesta->fetch_object()) {
            ?>
                <tr key="<?= $row->id ?>">
                  <td><?= $row->Departamento_Nombre ?></td>
                  <td><?= $row->Reservado_Por ?></td>
                  <td>
                    <p class="text-secondary mb-1">
                      <b>Fecha Inicio: </b><?= date("F jS, Y", strtotime($row->Fecha_De_Inicio)) ?>
                    </p>
                    <p class="text-secondary mb-1">
                      <b>Fecha fin: </b><?= date("F jS, Y", strtotime($row->Fecha_Fin)) ?>
                    </p>
                  </td>
                </tr>
            <?php
              }
            }
            ?>
          </tbody>
        </table>
        <div class="mt-5" id="feedback"></div>
      </div>
    </div>

  <?php
  } else
    require('noacceso.php');


  require('footer.php');
  ?>
  <script>
    $("#tblistado")
      .DataTable({
        fixedHeader: true,
        select: true,
      })
  </script>
<?php

}
ob_end_flush();
