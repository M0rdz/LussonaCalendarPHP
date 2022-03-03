<?php
//Activacion de almacenamiento en buffer
ob_start();
//iniciamos las variables de session
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: sign-in.html");
} else  //Agrega toda la vista
{
  require 'header.php';

  if ($_SESSION['listar-reservas'] == 1) {

?>

    <div class="card">
      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
          <h6 class="text-white text-capitalize ps-3">Detalle de reserva</h6>
        </div>
      </div>
      <div class="card-body">
        <!-- dispose information -->
        <form name="formulario" id="formulario" method="POST">

          <div class="input-group input-group-outline my-3">
            <label>Seleccionar Sala:</label>
            <select name="idsala" id="idsala" class="form-control" required></select>
          </div>

          <div class="input-group input-group-outline my-3">
            <label>Reserva a Nombre de:</label>
            <input type="hidden" name="idreserva" id="idreserva" value="<?php echo $idreserva; ?>" />
            <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required />
          </div>

          <div class="input-group input-group-outline my-3">
            <label>Periodo de Reseva:</label>
            <select name="periodo" id="periodo" class="form-control" required>
              <option value="Dia">Dia</option>
              <option value="Semana">Semana</option>
              <option value="Quincena">Quincena</option>
              <option value="Mes">Mes</option>
            </select>
          </div>

          <div class="input-group input-group-outline my-3">
            <label>Desde: </label>
            <input type="datetime-local" class="form-control" name="desde" id="desde" required />
          </div>

          <div class="input-group input-group-outline my-3">
            <label>Hasta:</label>
            <input type="datetime-local" class="form-control" name="hasta" id="hasta" required />
          </div>

          <div class="input-group input-group-outline my-3">
            <label>Costo de Reserva:</label>
            <input type="number" class="form-control" name="costo" id="costo" maxlength="100" placeholder="Monto" required disabled />
          </div>
          <div class="form-check my-3 px-0">
            <label>Servicios:</label>
            <ul style="list-style:none;" id="servicios">
            </ul>
          </div>

          <div class="input-group input-group-outline my-3">
            <label>Descripción:</label>
            <textarea rows="3" class="form-control" name="descripcion" id="descripcion"></textarea>
          </div>

          <div class="input-group input-group-outline my-3">
            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

            <a class="btn btn-danger" href="reservas.php" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</a>
          </div>

        </form>
        <!-- end dispose information -->
      </div>
    </div>

  <?php


  } //Llave de la condicion if de la variable de session

  else {
    require 'noacceso.php';
  }


  require 'footer.php';


  ?>

  <script src="scripts/detalle_reserva.js"></script>

<?php

}
ob_end_flush(); //liberar el espacio del buffer
?>