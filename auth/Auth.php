<?php
session_start();
switch ($_GET['op']) {
  case 'id':
    # code...
    echo json_encode(intval($_SESSION['idusuario']));
    break;
}
