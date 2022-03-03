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
  if ($_SESSION['crear-reserva'] == 1) {
    require_once '../modelos/Reserva.php';
    $id = $_SESSION['idusuario'];
    $reservas = new Reserva();
    $resultado = $reservas->listar();
?>

    <div class="row">
      <?php
      if ($resultado->num_rows < 9) { ?>
        <div class="col-md-3">
          <div class="sticky-top mb-3">
            <div class="card">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                  <h6 class="text-white text-capitalize ps-3">Formulario de reservas</h6>
                </div>
              </div>
              <div class="card-body px-3 pb-2">
                <!-- the events -->
                <div id="external-events">
                  <form name="formulario" id="formulario" method="POST">

                    <!-- <input type="hidden" name="idreserva" id="idreserva"> -->
                    <input type="hidden" name="nombre" id="nombre">
                    <!-- <div class="input-group input-group-static is-filled focused is-focused mb-4">
                      <label>Reserva a Nombre de:</label>
                    </div> -->

                    <div class="input-group input-group-static mb-4">
                      <label>Periodo de Reseva:</label>
                      <select name="periodo" id="periodo" class="form-control" required>
                        <option value="Semana">Semana 1</option>
                        <option value="Semana">Semana 2</option>
                        <option value="Semana">Semana 3</option>
                        <option value="Semana">Semana 4</option>
                        <option value="Semana">Semana 5</option>
                        <option value="Semana">Semana 6</option>
                        <option value="Semana">Semana 7</option>
                        <option value="Semana">Semana 8</option>
                        <option value="Semana">Semana 9</option>
                      </select>
                    </div>

                    <div class="input-group input-group-static mb-4">
                      <label>Desde:</label>
                      <input type="datetime-local" class="form-control" name="desde" id="desde" required>
                    </div>

                    <div class="input-group input-group-static mb-4">
                      <label>Hasta:</label>
                      <input type="datetime-local" class="form-control" name="hasta" id="hasta" required>
                    </div>


                    <div class="form-check my-3 px-0">
                      <label>Servicios:</label>
                      <ul style="list-style:none;" id="servicios">
                      </ul>
                    </div>

                    <div class="input-group input-group-static mb-4">
                      <label>Descripción:</label>
                      <textarea rows="3" class="form-control" name="descripcion" id="descripcion"></textarea>
                    </div>


                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <button class="btn bg-gradient-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                      <button class="btn bg-gradient-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                    </div>

                  </form>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
        </div>
      <?php } ?>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="card">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
              <h6 class="text-white text-capitalize ps-3">Calendario</h6>
            </div>
          </div>
          <div class="card-body p-3">
            <!-- THE CALENDAR -->
            <div id="calendar"></div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <!-- <div class="row">
            <div class="col-12">
              <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                  <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Lista de reservas</h6>
                  </div>
                </div>
                <div class="card-body px-0 pb-2">
                  <table id="tblistado" class="table-responsive table py-4 px-3">
                    <thead>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha Inicio</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha de Fin</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">Sala</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">Monto</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">Descripcion</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">Reservado</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">Observaciones</th>
                      <th></th>
                    </thead>
                    <tbody></tbody>
                  </table>
                  <div class="mt-5" id="feedback"></div>
                </div>
              </div>
            </div>
          </div> -->
    </div><!-- /.container-fluid -->
    </section>

    </div>


    <!-- Control Sidebar -->

    <!-- /.control-sidebar -->

    <!-- ./wrapper -->

    <!-- jQuery -->

    <!-- fullCalendar 2.2.5 -->




  <?php


  } //Llave de la condicion if de la variable de session

  else {
    require 'noacceso.php';
  }


  require 'footer.php';


  ?>

  <!-- Bootstrap -->
  <!-- jQuery UI -->
  <script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- fullCalendar 2.2.5 -->
  <script src="../plugins/moment/moment.min.js"></script>
  <script src="../plugins/fullcalendar/main.js"></script>

  <script src="./scripts/reservas.js"></script>
  <!-- AdminLTE for demo purposes -->

  <!-- Page specific script -->
  <script src="../public/js/JsBarcode.all.min.js"></script>
  <script src="../public/js/jquery.PrintArea.js"></script>
<?php

}
ob_end_flush(); //liberar el espacio del buffer
?>