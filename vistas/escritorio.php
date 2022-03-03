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
    // var_dump($_SESSION);
    require_once '../modelos/Consultas.php';


?>
    <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Dashboard</h6>
            </div>
        </div>
        <div class="card-body px-4 pt-3 text-center">
            <h4>Bienvenido a tu calendario, <?php echo $_SESSION['nombre'] ?></h4>
            <?php
            require_once '../modelos/Sala.php';
            $sala = new Sala();
            $s = $sala->mostraru($_SESSION['idusuario']);
            // var_dump($s);
            ?>
            <h5>Este es tu departamento</h5>
            <table class="table table-striped table-responsive table-sm">
                <tbody>
                    <tr>
                        <td class="text-end"><b>Departamento:</b></td>
                        <td class="text-start"><?= $s['nombre'] ?></td>
                    </tr>
                    <tr>
                        <td class="text-end"><b>Ubicacion:</b></td>
                        <td class="text-start"><?= $s['ubicacion'] ?></td>
                    </tr>
                    <tr>
                        <td class="text-end"><b>Descripcion:</b></td>
                        <td class="text-start"><?= $s['descripcion'] ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <?php
    require 'footer.php';
    ?>


<?php
}
ob_end_flush(); //liberar el espacio del buffer