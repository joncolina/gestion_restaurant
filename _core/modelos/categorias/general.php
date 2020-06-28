<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *  Modelo GENERAL de CATEGORIAS
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class CategoriasModel
{
	/*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
	public static function Listado( $idRestaurant, $buscar = "" )
	{
		$idRestaurant = (int) $idRestaurant;
		$buscar = Filtro::General($buscar);

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

	/*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
	public static function Registrar($nombre, $idAreaMonitoreo, $idRestaurant)
	{
		$idCategoria = Conexion::getMysql()->NextID("categorias", "idCategoria");
		$idRestaurant = (int) $idRestaurant;
		$nombre = Filtro::General(strtoupper($nombre));
		$idAreaMonitoreo = (int) $idAreaMonitoreo;
		$fecha_registro = Time::get();

		$query = "INSERT INTO categorias (idCategoria, idRestaurant, nombre, idAreaMonitoreo, fecha_registro) VALUES ('{$idCategoria}', '{$idRestaurant}', '{$nombre}', '{$idAreaMonitoreo}', '{$fecha_registro}')";
		$respuesta = Conexion::getMysql()->Ejecutar( $query );
		if($respuesta == FALSE) {
			throw new Exception("Ocurrio un error al intentar registrar la categoria.");
		}

		$objCategoria = new CategoriaModel($idCategoria);
		return $objCategoria;
	}
}