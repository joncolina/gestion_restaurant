<?php
class PlatillosModel
{
	public static function Listado( $buscar = "" )
	{
		$buscar = Filtro::General($buscar);
		$idRestaurant = Sesion::getRestaurant()->getId();

		if($buscar == "")
		{
			$query = "SELECT * FROM platos WHERE idRestaurant = '{$idRestaurant}' ORDER BY nombre";
		}
		else
		{
			$query = "SELECT * FROM platos WHERE
				idRestaurant = '{$idRestaurant}' AND
				(
					idPlato = '{$buscar}' OR
					nombre LIKE '%{$buscar}%'
				)
			ORDER BY nombre";
		}

		$datos = Conexion::getMysql()->Consultar($query);
		return $datos;
	}
}