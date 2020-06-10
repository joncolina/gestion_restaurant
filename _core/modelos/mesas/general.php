<?php
class MesasModel
{
	public static function Listado( $buscar = "" )
	{
		$buscar = Filtro::General($buscar);

		$idRestaurant = Sesion::getRestaurant()->getId();

		if($buscar == "")
		{
			$query = "SELECT * FROM mesas WHERE idRestaurant = '{$idRestaurant}' ORDER BY alias";
		}
		else
		{
			$query = "SELECT * FROM platos WHERE
				idRestaurant = '{$idRestaurant}' AND
				(
					idMesa = '{$buscar}' OR
					alias LIKE '%{$buscar}%'
				)
			ORDER BY alias";
		}

		$datos = Conexion::getMysql()->Consultar($query);
		return $datos;
	}
}