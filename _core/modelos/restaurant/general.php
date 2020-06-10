<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Modelo GENERAL de RESTAURANTES
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class RestaurantesModel
{
	/*============================================================================
	 *
	 *	
	 *
	============================================================================*/
	public static function Listado($valor = "")
	{
		if($valor == "")
        {
            $query = "SELECT * FROM restaurantes ORDER BY nombre ASC";
        }
        else
        {
            $query = "SELECT * FROM restaurantes WHERE
            documento LIKE '%{$valor}%' OR
            nombre LIKE '%{$valor}%'
            ORDER BY nombre ASC";
        }

        $datos = Conexion::getMysql()->Consultar($query);
        return $datos;
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public static function Existe($documento, $nombre)
    {
        $documento = Filtro::General($documento);
        $nombre = Filtro::General($nombre);

        $query = "SELECT COUNT(*) AS cantidad FROM restaurantes WHERE documento = '{$documento}' AND nombre = '{$nombre}'";
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
    public static function Registrar($documento, $nombre, $direccion, $telefono, $correo)
    {
        $idRestaurant = Conexion::getMysql()->NextID("restaurantes", "idRestaurant");
        $documento = Filtro::General($documento);
        $nombre = Filtro::General($nombre);
        $direccion = Filtro::General($direccion);
        $telefono = Filtro::General($telefono);
        $correo = Filtro::General($correo);
        $activo = (int) TRUE;
        $fecha_registro = Time::get();

        $query = "INSERT INTO restaurantes
        (idRestaurant, documento, nombre, direccion, telefono, correo, activo, fecha_registro)
        VALUES
        ('{$idRestaurant}', '{$documento}', '{$nombre}', '{$direccion}', '{$telefono}', '{$correo}', '{$activo}', '{$fecha_registro}')";
        $resp = Conexion::getMysql()->Ejecutar($query);
        if($resp === FALSE) {
            throw new Exception("Error al intentar registrar el restaurant.");
        }

        $objRestaurant = new RestaurantModel($idRestaurant);
        return $objRestaurant;
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public static function CantidadResponsables($idRestaurant)
    {
        $query = "SELECT COUNT(*) AS cantidad FROM usuarios A, roles B WHERE A.idRol = B.idRol AND B.idRestaurant = '{$idRestaurant}' AND B.responsable = '1'";
        $datos = Conexion::getMysql()->Consultar($query);
        $cantidad = $datos[0]['cantidad'];

        return $cantidad;
    }
}