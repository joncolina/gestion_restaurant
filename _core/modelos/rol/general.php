<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Modelo GENERAL de ROL
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class RolesModel
{
	/*============================================================================
	 *
	 *	
	 *
	============================================================================*/
	public static function Listado($idRestaurant, $valor = "")
	{
		$idRestaurant = (int) $idRestaurant;
		$valor = Filtro::General($valor);

		if($valor == "")
        {
            $query = "SELECT * FROM roles ORDER BY idRol ASC";
        }
        else
        {
			if(is_numeric($valor))
			{
				$query = "SELECT * FROM roles WHERE idRestaurant = '{$idRestaurant}' AND idRol = '{$valor}' ORDER BY idRol";
			}
			else
			{
				$query = "SELECT * FROM roles WHERE idRestaurant = '{$idRestaurant}' AND nombre LIKE '%{$valor}%' ORDER BY idRol";
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
	public static function Existe($idRol)
    {
        $idRol = (int) $idRol;

        $query = "SELECT COUNT(*) AS cantidad FROM roles WHERE idRol = '{$idRol}'";
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
	public static function ExisteNombre($idRestaurant, $nombre)
	{
		$idRestaurant = (int) $idRestaurant;
		$nombre = Filtro::General($nombre);

		$query = "SELECT COUNT(*) AS cantidad FROM roles WHERE idRestaurant = '{$idRestaurant}' AND nombre = '{$nombre}'";
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
	public static function Registrar($idRestaurant, $nombre)
	{
		$idRol = Conexion::getMysql()->nextID("roles", "idRol");
		$idRestaurant = (int) $idRestaurant;
		$nombre = Filtro::General($nombre);

		$query = "INSERT INTO roles (idRol, idRestaurant, nombre) VALUES ('{$idRol}', '{$idRestaurant}', '{$nombre}')";
		$respuesta = Conexion::getMysql()->Ejecutar($query);
		if($respuesta === FALSE) {
			throw new Exception("Ocurrio un problema al intentar agregar el nuevo rol.<br>".Conexion::getMysql()->getError());
		}

		$objRol = new RolModel($idRol);
		return $objRol;
	}
}