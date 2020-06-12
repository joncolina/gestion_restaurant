<?php
class PlatosModel
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

	//public static function Registrar($nombre,$descripcion,$imagen,$activo,$precioCosto,$precioVenta,$idStatus,$aux_1,$aux_2,$aux_3,$fecha_registro)

	public static function Registrar($nombre,$descripcion,$idCategoria,$imagen,$precioCosto,$precioVenta,$activo)

	{

		//Busca el ID maximo e incrementa en 1
		$idPlato = Conexion::getMysql()->NextID("platos", "idPlato");
		$idRestaurant = Sesion::getRestaurant()->getId();
		$idCategoria = (int) $idCategoria;
		$nombre = Filtro::General(strtoupper($nombre));

		$descripcion = Filtro::General(strtoupper($descripcion));

		$imagen = Filtro::General(strtoupper($imagen));
		
		$activo = (int) $activo;
		$precioCosto = (int) $precioCosto;
		$precioVenta = (int) $precioVenta;
		$idStatus = "";
		$aux_1 = "";
		$aux_2 = "";
		$aux_3 = "";
		$fecha_registro = Time::get();
		
		

		$query = "INSERT  INTO platos (idPlato, idRestaurant, idCategoria, nombre, descripcion, imagen, activo, precioCosto, precioVenta, idStatus,aux_1, aux_2, aux_3,fecha_registro) VALUES ('{$idPlato}','{$idRestaurant}' ,'{$idCategoria}' ,'{$nombre}', '{$descripcion}','{$imagen}','{$activo}','{$precioCosto}','{$precioVenta}', '{$activo}','{$aux_1}', '{$aux_2}', '{$aux_3}','{$fecha_registro}')";
		$respuesta = Conexion::getMysql()->Ejecutar( $query );
		if($respuesta == FALSE) {
			throw new Exception("Ocurrio un error al intentar registrar el Plato.");
		}

		$objPlato = new PlatilloModel($idPlato);
		return $objPlato;
	}
}