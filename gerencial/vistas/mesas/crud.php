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
			$mesas = MesasModel::Listado();
        }
        else
        {
            $mesas = MesasModel::Listado( $buscar );
		}

		$data = [];
		foreach($mesas as $mesa)
		{
			$objMesa = new MesaModel( $mesa['idMesa'] );
			$idStatus = $objMesa->getIdStatus();
			$nombreStatus = STATUS_MESAS[$idStatus]['nombre'];

			array_push($data, [
				"alias" => $objMesa->getAlias(),
				"status" => [
					"id" => $idStatus,
					"nombre" => $nombreStatus
				],
				"usuario" => $objMesa->getUsuario(),
				"clave" => $objMesa->getClave(),
				"fecha_registro" => $objMesa->getFechaRegistro()
			]);
		}
		
		$respuesta['data'] = $data;
	break;

	case "REGISTRAR":
		$alias = Input::POST("alias", TRUE);
		$usuario = Input::POST("usuario", TRUE);
		$clave = Input::POST("clave", TRUE);

		$objMesa = MesasModel::Registrar($idRestaurant, $alias, $usuario, $clave);
		Conexion::getMysql()->Commit();

		$respuesta['data'] = [
			"id" => $objMesa->getId(),
			"alias" => $objMesa->getAlias(),
			"idStatus" => $objMesa->getIdStatus(),
			"fecha_registro" => $objMesa->getFechaRegistro()
		];
	break;

	case "MODIFICAR":
		$idMesa = Input::POST("MIdMesa", TRUE);
		$alias = Input::POST("alias", TRUE);
		$usuario = Input::POST("usuario", TRUE);
		$clave = Input::POST("clave", TRUE);

		$objMesa = new MesaModel( $idMesa );

		$objMesa->setAlias( $alias );
		$objMesa->setUsuario( $usuario );
		$objMesa->setClave( $clave );
		Conexion::getMysql()->Commit();
	

		$respuesta['data'] = [
			"id" => $objMesa->getId(),
			"alias" => $objMesa->getalias()
			
		];
	break;

	case "ELIMINAR":
		$idMesa = Input::POST("EidMesa", TRUE);
		$objMesa = new MesaModel( $idMesa );
		$objMesa->Eliminar( $objMesa->getId() );
		Conexion::getMysql()->Commit();
		$respuesta['data'] = [];
	break;

	default:
		throw new Exception("Acción No Válida");
	break;
}

/*================================================================================
 * 
================================================================================*/
echo json_encode($respuesta);