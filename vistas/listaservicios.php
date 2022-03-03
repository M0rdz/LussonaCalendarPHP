<?php
ob_start();
session_start();

if (!isset($_SESSION['idusuario'])) {
  return header('location: sign_in.php');
} else {
  require './header.php';
  if ($_SESSION['listar-servicios'] === 1) {
    require '../modelos/Servicio.php';

    $servicios = new Servicio();
    $respuesta = $servicios->index();
?>
    <div class="card my-3">
      <div class="card-header py-0">
        <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
          <i class="material-icons opacity-10">home</i>
        </div>
        <div class="text-end pt-1">
          <p class="text-lg mb-0 text-capitalize">Lista de servicios</p>
          <?php
          if ($_SESSION['crear-servicios'] === 1) {
          ?>
            <button class="btn btn-link mb-n1" id="btnAgregar" onclick="mostrarForm(true)">
              <i class="fa fa-plus-circle"></i> Agregar
            </button>
          <?php } ?>
        </div>
      </div>
      <hr class="dark horizontal opacity-10 mx-3">
      <div class="card-body p-2 pt-2">
        <div class="panel-body my-3" id="serviceList">
          <table class="table-responsive table-sm table my-4 py-2" id="tblistado">
            <thead>
              <tr>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Descripción</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Horas</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
        <div class="panel-body my-3" id="formPane">
          <div class="px-3">
            <form method="post" id="frm-servicio">
              <input type="disabled" name="id" class="d-none">
              <div id="frm-nombre" class="input-group input-group-outline my-4">
                <label for="nombre" class="form-label">Nombre: *</label>
                <input type="text" name="nombre" id="nombre" class="form-control">
              </div>

              <div id="frm-description" class="input-group input-group-outline my-4">
                <label for="nombre" class="form-label">Descripción: *</label>
                <input type="text" name="descripcion" id="descripcion" class="form-control">
              </div>
              <div id="frm-coste" class="input-group input-group-outline my-4">
                <label for="nombre" class="form-label">Coste por hora: *</label>
                <input type="double" name="costehora" id="costehora" class="form-control" min="0" max="999">
              </div>
              <div class="row col-12">
                <button type="submit" class="btn btn-success" id="btnGuardar">Enviar</button>
                <button type="button" class="btn btn-secondary" onclick="cancelarForm()">Cancelar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  <?php
  } else {
    require 'noacceso.php';
  }
  require 'footer.php';
  ?>
  <script src="./scripts/servicio.js" defer></script>
<?php
}
ob_end_flush();
?>