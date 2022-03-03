<?php
require '../config/conexion.php';

class Usuario
{
    public function __construct()
    {
    }

    public function insertar($nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clave, $imagen, $permisos)
    {
        $sql = "INSERT INTO usuario (
                        nombre,
                        tipo_documento,
                        num_documento,
                        direccion,
                        telefono,
                        email,
                        cargo,
                        clave,
                        imagen,
                        login,
                        condicion
                    ) 
                    VALUES (
                        '$nombre',
                        '$tipo_documento',
                        '$num_documento',
                        '$direccion',
                        '$telefono',
                        '$email',
                        '$cargo',
                        '$clave',
                        '$imagen',
                        '$login',
                        '1'
                        )";

        //return ejecutarConsulta($sql);
        $idusuarionew = ejecutarConsulta_retornarID($sql);

        $num_elementos = 0;
        $sw = true;

        while ($num_elementos < count($permisos)) {
            $sql_detalle = "INSERT INTO usuario_permiso (
                                    idusuario,
                                    idpermiso
                                )
                                VALUES (
                                    '$idusuarionew',
                                    '$permisos[$num_elementos]'
                                )";

            ejecutarConsulta($sql_detalle) or $sw = false;

            $num_elementos = $num_elementos + 1;
        }

        return $sw;
    }

    public function editar($idusuario, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clave, $imagen, $permisos)
    {
        $sql = "UPDATE usuario SET 
                    nombre='$nombre', 
                    tipo_documento='$tipo_documento',
                    num_documento='$num_documento',
                    direccion='$direccion',
                    telefono='$telefono',
                    email='$email',
                    cargo='$cargo',
                    clave='$clave',
                    imagen='$imagen',
                    login='$login'
                    WHERE idusuario='$idusuario'";

        ejecutarConsulta($sql);

        //Eliminamos todos los permisos asignados para volverlos a registrar
        $sqldel = "DELETE FROM usuario_permiso
                        WHERE idusuario='$idusuario'";

        ejecutarConsulta($sqldel);

        $num_elementos = 0;
        $sw = true;

        while ($num_elementos < count($permisos)) {
            $sql_detalle = "INSERT INTO usuario_permiso(
                    idusuario,
                    idpermiso
                    )
                    VALUES (
                        '$idusuario',
                        '$permisos[$num_elementos]'
                    )";
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos = $num_elementos + 1;
        }

        return $sw;
    }
    public function sinPass($idusuario, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $imagen, $permisos)
    {
        $sql = "UPDATE usuario SET 
                    nombre='$nombre', 
                    tipo_documento='$tipo_documento',
                    num_documento='$num_documento',
                    direccion='$direccion',
                    telefono='$telefono',
                    email='$email',
                    cargo='$cargo',
                    imagen='$imagen',
                    login='$login'
                    WHERE idusuario='$idusuario'";

        ejecutarConsulta($sql);

        //Eliminamos todos los permisos asignados para volverlos a registrar
        $sqldel = "DELETE FROM usuario_permiso
                        WHERE idusuario='$idusuario'";

        ejecutarConsulta($sqldel);

        $num_elementos = 0;
        $sw = true;

        while ($num_elementos < count($permisos)) {
            $sql_detalle = "INSERT INTO usuario_permiso(
                    idusuario,
                    idpermiso
                    )
                    VALUES (
                        '$idusuario',
                        '$permisos[$num_elementos]'
                    )";
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos = $num_elementos + 1;
        }

        return $sw;
    }

    public function desactivar($idusuario)
    {
        $sql = "UPDATE usuario SET condicion='0' 
                   WHERE idusuario='$idusuario'";

        return ejecutarConsulta($sql);
    }

    public function activar($idusuario)
    {
        $sql = "UPDATE usuario SET condicion='1' 
                   WHERE idusuario='$idusuario'";

        return ejecutarConsulta($sql);
    }


    public function mostrar($idusuario)
    {
        $sql = "SELECT * FROM usuario 
                    WHERE idusuario='$idusuario'";

        return ejecutarConsultaSimpleFila($sql);
    }

    public function listar()
    {
        $sql = "SELECT * FROM usuario";

        return ejecutarConsulta($sql);
    }

    public function listarmarcados($idusuario)
    {
        $sql = "SELECT * FROM usuario_permiso
                    WHERE idusuario='$idusuario'";

        return ejecutarConsulta($sql);
    }

    //Verficacion de acceso
    public function verificar($login, $clave)
    {
        $sql = "SELECT 
                        *
                    FROM usuario
                    WHERE login='$login' 
                    AND clave='$clave'
                    AND condicion='1'";

        return ejecutarConsulta($sql);
    }
}
