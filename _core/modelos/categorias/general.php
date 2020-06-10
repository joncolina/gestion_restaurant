<?php
class CategoriasModel
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
			$query = "SELECT * FROM categorias WHERE idRestaurant = '{$idRestaurant}' ORDER BY nombre";
		}
		else
		{
			//Aqui decidimos por cual columnas buscar, por ahora nombre y ID
			$query = "SELECT * FROM categorias WHERE
				idRestaurant = '{$idRestaurant}' AND
				(
					idCategoria = '{$buscar}' OR
					nombre LIKE '%{$buscar}%'
				)
			ORDER BY nombre";
		}

		//Aqui esta toda la informacion
		$datos = Conexion::getMysql()->Consultar($query);
		return $datos;
	}
}