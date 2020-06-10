<?php
class CategoriasModel
{
	public static function Listado( $buscar = "" )
	{
		$buscar = Filtro::General($buscar);

		$idRestaurant = Sesion::getRestaurant()->getId();

		if($buscar == "")
		{
			$query = "SELECT * FROM categorias WHERE idRestaurant = '{$idRestaurant}' ORDER BY nombre";
		}
		else
		{
			$query = "SELECT * FROM categorias WHERE
				idRestaurant = '{$idRestaurant}' AND
				(
					idCategoria = '{$buscar}' OR
					nombre LIKE '%{$buscar}%'
				)
			ORDER BY nombre";
		}

		$datos = Conexion::getMysql()->Consultar($query);
		return $datos;
	}
}