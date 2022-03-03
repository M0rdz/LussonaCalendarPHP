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

  if ($_SESSION['editar-reservas'] === 1) {
    require '../modelos/Reserva.php';
    require '../modelos/Usuario.php';
    $reservas = new Reserva();
    $resultado = $reservas->listarTodo();

    $usuarios = new Usuario();
    $res = $usuarios->listar();
?>

    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="card my-4">
      <div class="card-header p-2 pt-2">
        <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
          <i class="material-icons opacity-10">phone</i>
        </div>
        <div class="text-end pt-1">
          <p class="text-lg mb-0 text-capitalize">Lista de reservas</p>
          <button class="btn btn-link mb-n1" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button>
        </div>
      </div>
      <hr class="dark horizontal mx-4 my-0">
      <div class="card-body p-3">
        <!-- /.box-header -->
        <!-- centro -->
        <div class="panel-body py-4" id="listadoregistros">
          <table id="tblistado" class="table table-sm align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">Fecha </th>
                <!-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">Sala</th> -->
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">Detalles</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">Estado</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
        <div class="panel-body" id="formularioregistros">
          <form name="formulario" id="formulario" method="POST">
            <input type="hidden" name="idreserva" id="idreserva">
            <div class="input-group input-group-static mb-4">
              <label>Reserva a Nombre de:</label>
              <!-- <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required readonly> -->
              <select name="nombre" id="nombre">
                <?php
                while ($usuario = $res->fetch_object()) {
                  echo '<option value="' . $usuario->idusuario . '">' . $usuario->nombre . '</option>';
                }
                ?>
              </select>
            </div>
            <div class="input-group input-group-static mb-4">
              <label>Periodo de reserva:</label>
              <input type="text" class="form-control" name="periodo" id="periodo" placeholder="Nombre" required>
            </div>

            <div class="input-group input-group-static mb-4">
              <label>Desde:</label>
              <input type="datetime" class="form-control" name="desde" id="desde" placeholder="Nombre" required>
            </div>

            <div class="input-group input-group-static mb-4">
              <label>Hasta:</label>
              <input type="datetime" class="form-control" name="hasta" id="hasta" placeholder="Nombre" required>
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
              <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

              <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
            </div>
          </form>
        </div>
      </div>
    </div>


  <?php

  } //Llave de la condicion if de la variable de session

  else {
    require 'noacceso.php';
  }

  require 'footer.php';
  ?>
  <script src="./scripts/reservas.js"></script>

<?php

}
ob_end_flush(); //liberar el espacio del buffer
?>