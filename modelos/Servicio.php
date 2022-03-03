<?php
require '../config/conexion.php';

class Servicio
{
  public function __construct()
  {
  }

  public function index()
  {
    $sql = "SELECT * FROM servicios";
    return ejecutarConsulta($sql);
  }
  public function store($nombre, $descripcion, $costehora)
  {
    $sql = "INSERT INTO servicios (
      nombre,
      descripcion,
      costehora
    ) VALUES (
      $nombre,
      $descripcion,
      $costehora
    )";
    if (ejecutarConsulta($sql)) {
      return true;
    }
    return false;
  }
  public function show($id)
  {
    $sql = "SELECT * FROM servicios WHERE id = $id";
    return ejecutarConsultaSimpleFila($sql);
  }
  public function update($id, $nombre, $descripcion, $costehora)
  {
    $sql = "UPDATE servicios SET 
      nombre = $nombre,
      descripcion = $descripcion,
      costehora = $costehora
        WHERE id = $id;";
  }
  public function disable($id)
  {
    $sql = "UPDATE servicios SET status = 0 WHERE id = $id";
    return ejecutarConsulta($sql);
  }

  public function enable($id)
  {
    $sql = "UPDATE servicios SET status = 1 WHERE id = $id";
    return ejecutarConsulta($sql);
  }
  public function pluck()
  {
    $sql = "SELECT id, nombre FROM servicios";
    return ejecutarConsulta($sql);
  }
  public function listarMarcados($idreserva)
  {
    $sql = "SELECT * FROM servicio_reserva
                    WHERE reserva_id='$idreserva'";

    return ejecutarConsulta($sql);
  }
}
