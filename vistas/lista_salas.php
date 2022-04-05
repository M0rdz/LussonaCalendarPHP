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

  if ($_SESSION['listar-departamentos'] == 1) {


?>
    <div class="card my-4">
      <!-- <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2"> -->
      <div class="card-header p-2 pt-2">
        <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
          <i class="material-icons opacity-10">home</i>
        </div>
        <div class="text-end pt-1">
          <p class="text-lg mb-0 text-capitalize">Lista de departamentos</p>
          <!-- <button class="btn mb-n1" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button> -->
          <button class="btn btn-link bmb-n1" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button>
        </div>
      </div>
      <!-- /.box-header -->
      <!-- centro -->

      <hr class="dark horizontal mx-4 my-0">
      <div class="card-body px-4 py-2 pb-2">
        <div class=" panel-body table-responsive" id="listadoregistros">
          <table id="tblistado" class="table table-sm align-items-center mb-0">
            <thead>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Departamento</th>
              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ubicacion</th>
              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Descripcion</th>
              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Propietario</th>
              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estado</th>
              <th></th>
            </thead>
            <tbody>

            </tbody>
          </table>
          <div class="mt-5" id="feedback"></div>
        </div>
        <div class="panel-body" style="height: 400px;" id="formularioregistros">
          <form name="formulario" id="formulario" method="POST">
            <div class="input-group input-group-static mb-4">
              <label>Nombre:</label>
              <input type="hidden" name="idsala" id="idsala">
              <input type="text" class="form-control" name="nombre" id="nombre" maxlength="50" placeholder="Nombre" required>
            </div>

            <div class="input-group input-group-static mb-4">
              <label>Ubicacion:</label>
              <input type="text" class="form-control" name="ubicacion" id="ubicacion" maxlength="256" placeholder="Ubicacion">
            </div>


            <div class="input-group input-group-static mb-4">
              <label>Descripción:</label>
              <input type="text" class="form-control" name="descripcion" id="descripcion" maxlength="256" placeholder="Descripción">
            </div>
            <div class="input-group input-group-static mb-4">
              <label>Usuarios:</label>
              <select name="usuarios" id="usuarios" class="form-control"></select>
            </div>

            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

              <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
            </div>

          </form>
        </div>
      </div>
      <!--Fin centro -->
    </div>


  <?php

  } //Llave de la condicion if de la variable de session

  else {
    require 'noacceso.php';
  }

  require 'footer.php';
  ?>

  <script src="./scripts/sala.js"></script>

<?php
}
ob_end_flush(); //liberar el espacio del buffer
?>