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
			$status = $objMesa->getStatus();
			$nombreStatus = STATUS_MESAS[$status];

			array_push($data, [
				"id" => $objMesa->getId(),
				"alias" => $objMesa->getAlias(),
				"status" => [
					"key" => $status,
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
			"status" => [
				"key" => $objMesa->getStatus(),
				"nombre" => STATUS_MESAS[$objMesa->getStatus()]
			],
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

		if($objMesa->getStatus() != "OCUPADA")
		{
			if(Input::POST("cerrado", FALSE) === FALSE)
			{
				$objMesa->setStatus( "DISPONIBLE" );
			}
			else
			{
				$objMesa->setStatus( "CERRADA" );
			}
		}

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