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

  if ($_SESSION['listar-usuarios'] === 1) {
    require '../modelos/Usuario.php';
    $usuarios = new Usuario();
    $resultado = $usuarios->listar();
?>

    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="card my-4">
      <div class="card-header p-2 pt-2">
        <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
          <i class="material-icons opacity-10">person</i>
        </div>
        <div class="text-end pt-1">
          <p class="text-lg mb-0 text-capitalize">Lista de usuarios</p>
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
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Usuario</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Contacto</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fracción</th> 
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estado</th>

                <th></th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
        <div class="panel-body" id="formularioregistros">
          <form name="formulario" id="formulario" method="POST">
            <div class="input-group input-group-static my-3 gap-2 align-items-center">
              <label>Nombre(*):</label>
              <input type="hidden" name="idusuario" id="idusuario">
              <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required>
            </div>
            <div class="input-group input-group-static my-3 gap-2 align-items-center">
              <label>Campos:</label>
              <select name="tipo_documento" id="tipo_documento" class="form-control col-6" required>
                <option value="Fraccion">Fracción</option>
              </select>
              <input type="text" class="form-control col" name="num_documento" id="num_documento" maxlength="20" placeholder="Numero Fracción" required>
            </div>
            <!-- <div class="input-group input-group-static my-3 gap align-items-center">
              <label for="">Departamento</label>
              <select name="" id="idsala" class="fotm-control" required></select>
            </div> -->
            <div class="input-group input-group-static my-3 gap-2 align-items-center">
              <label>Direccion:</label>
              <input type="text" class="form-control" name="direccion" id="direccion" maxlength="70" placeholder="Direccion">
            </div>
            <div class="input-group input-group-static my-3 gap-2 align-items-center">
              <label>Telefono:</label>
              <input type="text" class="form-control" name="telefono" id="telefono" maxlength="20" placeholder="Telefono">
            </div>
            <div class="input-group input-group-static my-3 gap-2 align-items-center">
              <label>Email:</label>
              <input type="email" class="form-control" name="email" id="email" maxlength="50" placeholder="Email">
            </div>
            <div class="input-group input-group-static my-3 gap-2 align-items-center">
              <label>Cargo:</label>
              <input type="text" class="form-control" name="cargo" id="cargo" maxlength="20" placeholder="Cargo">
            </div>
            <div class="input-group input-group-static my-3 gap-2 align-items-center">
              <label>Login(*):</label>
              <input type="text" class="form-control" name="login" id="login" maxlength="20" placeholder="Login" required>
            </div>
            <div class="input-group input-group-static my-3 gap-2 align-items-center">
              <label>Clave:</label>
              <input type="password" class="form-control" name="clave" id="clave" maxlength="64" placeholder="Clave">
            </div>

            <div class="form-check my-3">
              <label>Permisos:</label>
              <ul style="list-style:none;" id="permisos">
              </ul>
            </div>


            <div class="input-group input-group-static my-3 gap-2 align-items-center">
              <label>Imagen:</label>
              <input type="file" class="form-control" name="imagen" id="imagen">
              <input type="hidden" class="form-control" name="imagenactual" id="imagenactual">
              <img src="" width="150px" height="120px" id="imagenmuestra">
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
  <script src="./scripts/usuario.js"></script>

<?php

}
ob_end_flush(); //liberar el espacio del buffer
?>