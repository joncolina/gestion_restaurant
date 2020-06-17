<?php
class PlatosModel
{
	public static function Listado( $idRestaurant, $buscar = "" )
	{
		$buscar = Filtro::General($buscar);
		$idRestaurant = (int) $idRestaurant;

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

	public static function ListadoCliente( $idRestaurant )
	{
		$idRestaurant = (int) $idRestaurant;
		$query = "SELECT * FROM platos WHERE idRestaurant = '{$idRestaurant}' AND activo = '1' ORDER BY nombre";
		$datos = Conexion::getMysql()->Consultar($query);
		return $datos;
	}
	
	public static function Registrar($idRestaurant, $nombre, $descripcion, $idCategoria, $precioCosto, $precioVenta, $activo)
	{
		//Busca el ID maximo e incrementa en 1
		$idPlato = Conexion::getMysql()->NextID("platos", "idPlato");
		$idRestaurant = (int) $idRestaurant;
		$nombre = Filtro::General(strtoupper($nombre));
		$descripcion = Filtro::General(strtoupper($descripcion));
		$idCategoria = (int) $idCategoria;
		$precioCosto = (int) $precioCosto;
		$precioVenta = (int) $precioVenta;
		$activo = (int) $activo;
		$fecha_registro = Time::get();
		
		$query = "INSERT  INTO platos (idPlato, idRestaurant, idCategoria, nombre, descripcion, activo, precioCosto, precioVenta, fecha_registro)
			VALUES
			('{$idPlato}', '{$idRestaurant}', '{$idCategoria}', '{$nombre}', '{$descripcion}', '{$activo}', '{$precioCosto}', '{$precioVenta}', '{$fecha_registro}')"
		;
		$respuesta = Conexion::getMysql()->Ejecutar( $query );
		if($respuesta == FALSE) {
			throw new Exception("Ocurrio un error al intentar registrar el Plato.");
		}

		$objPlato = new PlatoModel($idPlato);
		return $objPlato;
	}
}