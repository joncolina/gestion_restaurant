<?php
class MesasModel
{
	public static function Listado( $buscar = "" )
	{
		//Filtramos el parametro
		//Lo que hace es que elimina simbolos no permitidos (<,>,",'...)
		$buscar = Filtro::General($buscar);

		/* El id del restaurant no hace falta pasarlo por parametro, ya que esta en
		todos lados gracias a la sesion */
		$idRestaurant = Sesion::getRestaurant()->getId();

		if($buscar == "")
		{
			$query = "SELECT * FROM mesas WHERE idRestaurant = '{$idRestaurant}' ORDER BY alias";
		}
		else
		{
			//Aqui decidimos por cual columnas buscar, por ahora aliass y ID
			$query = "SELECT * FROM platos WHERE
				idRestaurant = '{$idRestaurant}' AND
				(
					idMesa = '{$buscar}' OR
					alias LIKE '%{$buscar}%'
				)
			ORDER BY alias";
		}

		//Aqui esta toda la informacion
		$datos = Conexion::getMysql()->Consultar($query);
		return $datos;
	}
}