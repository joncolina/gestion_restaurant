<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	CRUD DE PLATOS
 *
 *--------------------------------------------------------------------------------
================================================================================*/

/*================================================================================
 * Tomamos los parametros
================================================================================*/
 $accion = Input::POST("accion");
 $objRestaurant = Sesion::getRestaurant();

/*================================================================================
 * 
================================================================================*/
switch($accion)
{
	case "CONSULTAR":
		$buscar = Input::POST("buscar", FALSE);
		if($buscar === FALSE)
		{
			$platillos = PlatillosModel::Listado();
        }
        else
        {
            $platillos = PlatillosModel::Listado( $buscar );
		}
		
		$respuesta['data'] = $platillos;
	break;
	case "REGISTRAR":
		$nombre = Input::POST("NombrePlato", TRUE);
		$descripcion = Input::POST("DescripPlato", TRUE);
		$idCategoria = Input::POST("CategoriaPlato", TRUE);
		//$imagen = Input::POST("ImagenPlato", TRUE);
		$imagen=$_FILES['ImagenPlato']['name'];
		$precioCosto = Input::POST("PrecioCostoPlato");
		$precioVenta = Input::POST("PrecioVentaPlato");
		$activo = Input::POST("ActivoPlato", FALSE);

		if($activo) $activo = "1";
		else $activo = "0";
		
		$objRestaurant = Sesion::getRestaurant();

		$objPlatillo = PlatillosModel::Registrar($nombre, $descripcion, $idCategoria, $imagen,$precioCosto,$precioVenta, $activo);
		Conexion::getMysql()->Commit();

		$respuesta['data'] = [
			"id" => $objPlatillo->getId(),
			"nombre" => $objPlatillo->getNombre(),
			"descripcion" => $objPlatillo->getDescripcion(),
			"activo" => $objPlatillo->getActivo()
		];
	break;

	default:
		throw new Exception("Acción No Válida");
	break;
}

/*================================================================================
 * 
================================================================================*/
echo json_encode($respuesta);