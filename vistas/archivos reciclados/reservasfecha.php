<?php
//Activacion de almacenamiento en buffer
ob_start();
//iniciamos las variables de session
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else  //Agrega toda la vista
{
  require 'header.php';

  if ($_SESSION['reservas'] == 1) {
?>

    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">Consulta de Reservas por Fechas</h1>
                <div class="box-tools pull-right">
                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              <div class="panel-body table-responsive" id="listadoregistros">
                <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <label for="">Fecha Inicio</label>
                  <input type="date" class="form-control" name="desde" id="desde" value="<?php echo date("Y-m-d"); ?>">
                </div>
                <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <label for="">Fecha Fin</label>
                  <input type="date" class="form-control" name="hasta" id="hasta" value="<?php echo date("Y-m-d"); ?>">
                </div>

                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <button class="btn btn-success" onclick="listar()">Mostrar</button>
                  <label for="">Sala</label>

                  <select name="idsala" id="idsala" class="form-control selectpicker" data-live-search="true" required></select>

                </div>

              </div>
              <!--Fin centro -->
            </div><!-- /.box -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
    <!--Fin-Contenido-->


  <?php

  } //Llave de la condicion if de la variable de session

  else {
    require 'noacceso.php';
  }

  require 'footer.php';
  ?>

  <script src="./scripts/reservasfecha.js"></script>

<?php
}
ob_end_flush(); //liberar el espacio del buffer
?>