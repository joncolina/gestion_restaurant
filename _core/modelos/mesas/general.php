<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Modelo GENERAL de MESAS
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class MesasModel
{
	/*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
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
			$query = "SELECT * FROM mesas WHERE
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

	/*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
	public static function Registrar($idRestaurant, $alias, $usuario, $clave)
	{
		$idMesa = Conexion::getMysql()->NextID("mesas", "idMesa");
		$idRestaurant = (int) $idRestaurant;
		$status = "DISPONIBLE";
		$alias = Filtro::General(strtoupper($alias));
		$usuario = Filtro::General($usuario);
		$clave = Filtro::General($clave);
		$aux_1 = "";
		$aux_2 = "";
		$aux_3 = "";
		$fecha_registro = Time::get();

		$query = "INSERT INTO mesas (idMesa, idRestaurant, status, alias, usuario, clave, aux_1, aux_2, aux_3, fecha_registro) VALUES ('{$idMesa}', '{$idRestaurant}', '{$status}', '{$alias}', '{$usuario}', '{$clave}', '{$aux_1}', '{$aux_2}', '{$aux_3}', '{$fecha_registro}')";
		$respuesta = Conexion::getMysql()->Ejecutar( $query );
		if($respuesta == FALSE) {
			throw new Exception("Ocurrio un error al intentar registrar la Mesa.");
		}

		$objMesa = new MesaModel($idMesa);
		return $objMesa;
	}
}