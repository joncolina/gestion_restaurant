<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Modelo GENERAL de USUARIO
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class UsuariosModel
{
    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public static function BuscarPorUsuario($idRestaurant, $usuario)
    {
        $query = "SELECT idUsuario FROM usuarios WHERE idRestaurant = '{$idRestaurant}' AND usuario = '{$usuario}'";
        $datos = Conexion::getMysql()->Consultar($query);
        if(sizeof($datos) == 0) {
            throw new Exception("El usuario <b>{$usuario}</b> no existe en el restaurant <b>codigo: {$idRestaurant}</b>.");
        }

        $idUsuario = $datos[0]['idUsuario'];
        $objUsuario = new UsuarioModel($idUsuario);
        return $objUsuario;
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public static function Existe($idRestaurant, $usuario)
    {
        $query = "SELECT COUNT(*) AS cantidad FROM usuarios WHERE idRestaurant = '{$idRestaurant}' AND usuario = '{$usuario}'";
        $datos = Conexion::getMysql()->Consultar($query);
        $cantidad = $datos[0]['cantidad'];

        if($cantidad > 0) return TRUE;
        else return FALSE;
    }

	/*============================================================================
	 *
	 *	
	 *
	============================================================================*/
	public static function Listado($valor = "", $idRestaurant = "")
	{
        $valor = Filtro::General($valor);

        if($idRestaurant == "")
        {
            if($valor == "")
            {
                $query = "SELECT * FROM usuarios ORDER BY usuario ASC";
            }
            else
            {
                $query = "SELECT * FROM usuarios A, restaurantes B WHERE A.idRestaurant = B.idRestaurant AND
                ( A.usuario LIKE '%{$valor}%' OR A.nombre LIKE '%{$valor}%' OR B.nombre LIKE '%{$valor}%' )
                ORDER BY A.nombre ASC";
            }
        }
        else
        {
            $idRestaurant = (int) $idRestaurant;

            if($valor == "")
            {
                $query = "SELECT * FROM usuarios WHERE idRestaurant = '{$idRestaurant}' ORDER BY usuario ASC";
            }
            else
            {
                $query = "SELECT * FROM usuarios A, restaurantes B WHERE A.idRestaurant = B.idRestaurant AND idRestaurant = '{$idRestaurant}' AND
                ( A.usuario LIKE '%{$valor}%' OR A.nombre LIKE '%{$valor}%' OR B.nombre LIKE '%{$valor}%' )
                ORDER BY A.nombre ASC";
            }
        }

        $datos = Conexion::getMysql()->Consultar($query);
        return $datos;
    }

    /*============================================================================
	 *
	 *	
	 *
	============================================================================*/
    public static function Filtros($idRestaurant, $usuario, $nombre, $activo)
    {
        $idRestaurant = (int) $idRestaurant;
        $usuario = Filtro::General($usuario);
        $nombre = Filtro::General($nombre);

        $where = "";
        if($idRestaurant != "") {
            if($where != "") $where .= " AND ";
            $where .= "B.idRestaurant = '{$idRestaurant}'";
        }
        if($usuario != "") {
            if($where != "") $where .= " AND ";
            $where .= "A.usuario LIKE '%{$usuario}%'";
        }
        if($nombre != "") {
            if($where != "") $where .= " AND ";
            $where .= "A.nombre LIKE '%{$nombre}%'";
        }
        if($activo !== "") {
            $activo = (int) $activo;
            if($where != "") $where .= " AND ";
            $where .= "A.activo = '{$activo}'";
        }

        $query = "SELECT * FROM usuarios A, restaurantes B WHERE A.idRestaurant = B.idRestaurant AND ({$where}) ORDER BY A.nombre ASC";
        $datos = Conexion::getMysql()->Consultar($query);
        return $datos;
    }
    
	/*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public static function Registrar($usuario, $idRestaurant, $clave, $documento, $nombre, $idRol, $direccion, $telefono, $correo)
    {
        $idUsuario = Conexion::getMysql()->NextID("usuarios", "idUsuario");
        $idRestaurant = (int) $idRestaurant;
        $usuario = Filtro::General($usuario);
        $clave = Filtro::General($clave);
        $documento = Filtro::General($documento);
        $nombre = Filtro::General($nombre);
        $idRol = (int) $idRol;
        $direccion = Filtro::General($direccion);
        $telefono = Filtro::General($telefono);
        $correo = Filtro::General($correo);
        $activo = (int) TRUE;
        $fecha_registro = Time::get();

        $query = "INSERT INTO usuarios
        (idUsuario, idRestaurant, usuario, clave, documento, nombre, idRol, direccion, telefono, correo, activo, fecha_registro)
        VALUES
        ('{$idUsuario}', '{$idRestaurant}', '{$usuario}', '{$clave}', '{$documento}', '{$nombre}', '{$idRol}', '{$direccion}', '{$telefono}', '{$correo}', '{$activo}', '{$fecha_registro}')";
        $respuesta = Conexion::getMysql()->Ejecutar($query);
        if($respuesta === FALSE) {
            throw new Exception("Ocurrio un error al intentar registrar el usuario.<br>{$query}");
        }

        $objUsuario = new UsuarioModel($idUsuario);
        return $objUsuario;
    }
}