<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *  Modelo GENERAL de COMBOS
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class CombosModel
{
    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
	public static function Listado( $idRestaurant, $buscar = "" )
	{
		$buscar = Filtro::General($buscar);
		$idRestaurant = (int) $idRestaurant;

		if($buscar == "")
		{
			$query = "SELECT * FROM combos WHERE idRestaurant = '{$idRestaurant}' ORDER BY nombre";
		}
		else
		{
			$query = "SELECT * FROM combos WHERE
				idRestaurant = '{$idRestaurant}' AND
				(
					idCombo = '{$buscar}' OR
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
	public static function ListadoCliente( $idRestaurant )
	{
		$idRestaurant = (int) $idRestaurant;
		$query = "SELECT * FROM combos WHERE idRestaurant = '{$idRestaurant}' AND activo = '1' ORDER BY nombre";
		$datos = Conexion::getMysql()->Consultar($query);
		return $datos;
	}
	
	/*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
	public static function Registrar($idRestaurant, $nombre, $descripcion, $descuento)
	{
		//Busca el ID maximo e incrementa en 1
		$idCombo = Conexion::getMysql()->NextID("combos", "idCombo");
		$idRestaurant = (int) $idRestaurant;
		$nombre = Filtro::General(strtoupper($nombre));
		$descripcion = Filtro::General($descripcion);
		$descuento = Filtro::General($descuento);
		$activo = (int) TRUE;
		$fecha_registro = Time::get();
		
		$query = "INSERT INTO combos (idCombo, idRestaurant, nombre, descripcion, descuento, activo, fecha_registro)
			VALUES
			('{$idCombo}', '{$idRestaurant}', '{$nombre}', '{$descripcion}', '{$descuento}', '{$activo}', '{$fecha_registro}')"
		;
		$respuesta = Conexion::getMysql()->Ejecutar( $query );
		if($respuesta == FALSE) {
			throw new Exception("Ocurrio un error al intentar registrar el combo.");
		}

		$objCombo = new ComboModel($idCombo);
		return $objCombo;
	}
}