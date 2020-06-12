<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	CRUD DE CATEGORIAS
 *
 *--------------------------------------------------------------------------------
================================================================================*/

/*================================================================================
 * Tomamos los parametros
================================================================================*/
 $accion = Input::POST("accion");
 $objRestaurant = Sesion::getRestaurant();
 $idRestaurant = $objRestaurant->getId();

/*================================================================================
 * 
================================================================================*/
switch($accion)
{
	case "CONSULTAR":
		$buscar = Input::POST("buscar", FALSE);

		if($buscar === FALSE)
		{
			$categorias = CategoriasModel::Listado( $idRestaurant );
        }
        else
        {
            $categorias = CategoriasModel::Listado( $idRestaurant, $buscar );
		}

		$data = [];
		foreach($categorias as $categoria)
		{
			$objCategoria = new CategoriaModel( $categoria['idCategoria'] );
			$objArea = new AreaMonitoreoModel( $objCategoria->getIdAreaMonitoreo() );

			array_push( $data, [
				"id" => $objCategoria->getId(),
				"nombre" => $objCategoria->getNombre(),
				"atiende" => [
					"id" => $objArea->getId(),
					"nombre" => $objArea->getNombre()
				],
				"fecha_registro" => $objCategoria->getFechaRegistro()
			] );
		}

		$respuesta['data'] = $data;
	break;

	case "REGISTRAR":
		$nombre = Input::POST("NombreCategoria", TRUE);
		$idAreaMonitoreo = Input::POST("EnviaCategoria", TRUE);

		$objArea = new AreaMonitoreoModel( $idAreaMonitoreo );
		$objCategoria = CategoriasModel::Registrar($nombre, $objArea->getId(), $idRestaurant);
		Conexion::getMysql()->Commit();

		$respuesta['data'] = [
			"id" => $objCategoria->getId(),
			"nombre" => $objCategoria->getNombre(),
			"atiende" => [
				"id" => $objArea->getId(),
				"nombre" => $objArea->getNombre()
			],
			"fecha_registro" => $objCategoria->getFechaRegistro()
		];
	break;

	case "MODIFICAR":
		$idCategoria = Input::POST("idCategoria", TRUE);
		$nombre = Input::POST("NombreCategoria", TRUE);
		$idAreaMonitoreo = Input::POST("EnviaCategoria", TRUE);

		$objArea = new AreaMonitoreoModel( $idAreaMonitoreo );
		$objCategoria = new CategoriaModel( $idCategoria );

		$objCategoria->setNombre( $nombre );
		$objCategoria->setIdAreaMonitoreo( $idAreaMonitoreo );
		Conexion::getMysql()->Commit();
		
		$respuesta['data'] = [
			"id" => $objCategoria->getId(),
			"nombre" => $objCategoria->getNombre(),
			"atiende" => [
				"id" => $objArea->getId(),
				"nombre" => $objArea->getNombre()
			],
			"fecha_registro" => $objCategoria->getFechaRegistro()
		];
	break;

	case "ELIMINAR":
		$idCategoria = Input::POST("idCategoria", TRUE);
		$idCategoriaReemplazo = Input::POST("EIdCategoriaReemplazo", TRUE);

		$objCategoria = new CategoriaModel( $idCategoria );
		$objCategoriaReemplazo = new CategoriaModel( $idCategoriaReemplazo );

		if($objCategoria->getId() == $objCategoriaReemplazo->getId()) {
			throw new Exception("Las categorias a eliminar y de reemplazo no puedes ser iguales.");
		}

		$objCategoria->Eliminar( $objCategoriaReemplazo->getId() );
		Conexion::getMysql()->Commit();
		$respuesta['data'] = [];
	break;

	default:
		throw new Exception("Accion invalida");
	break;
}

/*================================================================================
 * Retornamos la salida
================================================================================*/
echo json_encode( $respuesta );