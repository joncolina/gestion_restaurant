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

	public static function Registrar($nombre, $enviar)
	{
		//Busca el ID maximo e incrementa en 1
		$idCategoria = Conexion::getMysql()->NextID("categorias", "idCategoria");
		$idRestaurant = Sesion::getRestaurant()->getId();
		$nombre = Filtro::General(strtoupper($nombre));
		$enviar = Filtro::General(strtoupper($enviar));
		$fecha_registro = Time::get();

		$query = "INSERT INTO categorias (idCategoria, idRestaurant, nombre, Enviar, fecha_registro) VALUES ('{$idCategoria}', '{$idRestaurant}', '{$nombre}', '{$enviar}', '{$fecha_registro}')";
		$respuesta = Conexion::getMysql()->Ejecutar( $query );
		if($respuesta == FALSE) {
			throw new Exception("Ocurrio un error al intentar registrar la categoria.");
		}

		$objCategoria = new CategoriaModel($idCategoria);
		return $objCategoria;
	}
}