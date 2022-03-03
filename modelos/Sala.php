<?php
require '../config/conexion.php';

class Sala
{
    public function __construct()
    {
    }

    public function insertar($nombre, $ubicacion, $descripcion, $idusuario)
    {
        $sql = "INSERT INTO departamentos (room_name,location, description, usuario_id,status) 
                    VALUES ('$nombre', '$ubicacion','$descripcion', '$idusuario','1')";

        return ejecutarConsulta($sql);
    }

    public function editar($idsala, $nombre, $ubicacion, $descripcion, $idusuario)
    {
        $sql = "UPDATE departamentos SET room_name='$nombre', location = '$ubicacion', description='$descripcion', usuario_id='$idusuario'
                    WHERE id='$idsala'";

        return ejecutarConsulta($sql);
    }

    //METODOS PARA ACTIVAR salaS
    public function desactivar($idsala)
    {
        $sql = "UPDATE departamentos SET status='0' 
                   WHERE id='$idsala'";

        return ejecutarConsulta($sql);
    }

    public function activar($idsala)
    {
        $sql = "UPDATE departamentos SET status='1' 
                   WHERE id='$idsala'";

        return ejecutarConsulta($sql);
    }

    //METODO PARA MOSTRAR LOS DATOS DE UN REGISTRO A MODIFICAR
    public function mostrar($idsala)
    {
        $sql = "SELECT d.id as idsala,
                    d.room_name as nombre,
                    d.location as ubicacion,
                    d.description as descripcion , 
                    d.status as condicion,
                    u.nombre as usuario
                    FROM departamentos as d join usuarios as u on d.usuario_id = usuario.idusuario
                    WHERE id='$idsala'";

        return ejecutarConsultaSimpleFila($sql);
    }
    public function mostraru($idusuario)
    {
        $sql = "SELECT id as idsala,
                    room_name as nombre,
                    location as ubicacion,
                    description as descripcion , 
                    status as condicion
                    FROM departamentos 
                    WHERE usuario_id='$idusuario'";

        return ejecutarConsultaSimpleFila($sql);
    }

    //METODO PARA LISTAR LOS REGISTROS
    public function listar()
    {
        $sql = "SELECT d.id as idsala,
                            d.room_name as nombre,
                            d.location as ubicacion,
                            d.description as descripcion , 
                            d.status as condicion,
                            u.nombre as usuario
                            FROM departamentos as d join usuario as u on d.usuario_id = u.idusuario";

        return ejecutarConsulta($sql);
    }

    //METODO PARA LISTAR LOS REGISTROS Y MOSTRAR EN EL SELECT
    public function select()
    {
        $sql = "SELECT id as idsala,
                    room_name as nombre,
                    location as ubicacion,
                    description as descripcion , 
                    status as condicion
                    FROM departamentos
                    WHERE status = 1";

        return ejecutarConsulta($sql);
    }
}
