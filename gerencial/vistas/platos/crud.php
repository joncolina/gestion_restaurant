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
			$platos = PlatosModel::Listado( $idRestaurant );
        }
        else
        {
            $platos = PlatosModel::Listado( $idRestaurant, $buscar );
		}

		$data = [];
		foreach($platos as $plato)
		{
			$objPlato = new PlatoModel( $plato['idPlato'] );
			$objCategoria = new CategoriaModel( $objPlato->getIdCategoria() );

			array_push($data, [
				"id" => $objPlato->getId(),
				"categoria" => [
					"id" => $objCategoria->getId(),
					"nombre" => $objCategoria->getNombre()
				],
				"nombre" => $objPlato->getNombre(),
				"descripcion" => $objPlato->getDescripcion(),
				"imagen" => $objPlato->getImagen(),
				"activo" => $objPlato->getActivo(),
				"precioCosto" => $objPlato->getPrecioCosto(),
				"precioVenta" => $objPlato->getPrecioVenta(),
				"fecha_registro" => $objPlato->getFechaRegistro()
			]);
		}

		$respuesta['data'] = $data;
	break;

	case "REGISTRAR":
		$nombre = Input::POST("NombrePlato", TRUE);
		$descripcion = Input::POST("DescripPlato", TRUE);
		$idCategoria = Input::POST("CategoriaPlato", TRUE);
		$precioCosto = (int) Input::POST("PrecioCostoPlato", TRUE);
		$precioVenta = (int) Input::POST("PrecioVentaPlato", TRUE);
		$activo = (int) boolval( Input::POST("ActivoPlato", FALSE) );

		if($nombre == "") throw new Exception("El campo <b>nombre</b> no puede estar vacio.");
		if($descripcion == "") throw new Exception("El campo <b>descripcion</b> no puede estar vacio.");
		if($idCategoria == "") throw new Exception("El campo <b>categoria</b> no puede estar vacio.");
		if($precioCosto < 0) throw new Exception("El campo <b>precio costo</b> no puede ser un numero positivo.");
		if($precioVenta < 0) throw new Exception("El campo <b>precio venta</b> no puede ser un numero positivo.");

		$objPlato = PlatosModel::Registrar($idRestaurant, $nombre, $descripcion, $idCategoria, $precioCosto, $precioVenta, $activo);

		/**
         * Imagen
         */
        if($_FILES && $_FILES['img'] && $_FILES['img']['name'] != "")
        {
            /**
             * Extraemos la data
             */
            $img = $_FILES['img'];
            $carpetaImg = DIR_IMG_REST."/".$idRestaurant;
            $nombreImg = "plato-{$objPlato->getId()}";
            $aux = explode(".", $img['name']);
            $extensionImg = $aux[ sizeof($aux) - 1 ];
            
            /**
             * Subimos la imagen
             */
            SubirImagen($carpetaImg, $nombreImg, $img);

            /**
             * Guardamos en la base de datos
             */
            $objPlato->setImagen( "{$nombreImg}.{$extensionImg}" );
        }

		Conexion::getMysql()->Commit();

		$respuesta['data'] = [
			"id" => $objPlato->getId(),
			"nombre" => $objPlato->getNombre(),
			"descripcion" => $objPlato->getDescripcion(),
			"activo" => $objPlato->getActivo()
		];
	break;

	case "MODIFICAR":
		$idPlato = Input::POST("idPlato", TRUE);
		$objPlato = new PlatoModel( $idPlato );

		if($objPlato->getIdRestaurant() != $idRestaurant) {
			throw new Exception("No puede modificar platos de otros resturantes.");
		}

		$nombre = Input::POST("NombrePlato", TRUE);
		$descripcion = Input::POST("MDescripPlato", TRUE);
		$idCategoria = Input::POST("MCategoríaPlato", TRUE);
		$precioCosto = (int) Input::POST("MPrecioCostoPlato", TRUE);
		$precioVenta = (int) Input::POST("MPrecioVentaPlato", TRUE);
		$activo = (int) boolval( Input::POST("ActivoPlato", FALSE) );

		/**
         * Imagen
         */
        if($_FILES && $_FILES['img'] && $_FILES['img']['name'] != "")
        {
            /**
             * Extraemos la data
             */
            $img = $_FILES['img'];
            $carpetaImg = DIR_IMG_REST."/".$idRestaurant;
            $nombreImg = "plato-{$objPlato->getId()}";
            $aux = explode(".", $img['name']);
            $extensionImg = $aux[ sizeof($aux) - 1 ];
            
            /**
             * Subimos la imagen
             */
            SubirImagen($carpetaImg, $nombreImg, $img);

            /**
             * Guardamos en la base de datos
             */
            $objPlato->setImagen( "{$nombreImg}.{$extensionImg}" );
		}
		
		if($nombre == "") throw new Exception("El campo <b>nombre</b> no puede estar vacio.");
		if($descripcion == "") throw new Exception("El campo <b>descripcion</b> no puede estar vacio.");
		if($idCategoria == "") throw new Exception("El campo <b>categoria</b> no puede estar vacio.");
		if($precioCosto < 0) throw new Exception("El campo <b>precio costo</b> no puede ser un numero positivo.");
		if($precioVenta < 0) throw new Exception("El campo <b>precio venta</b> no puede ser un numero positivo.");

		$objPlato->setNombre( $nombre );
		$objPlato->setDescripcion( $descripcion );
		$objPlato->setIdCategoria( $idCategoria );
		$objPlato->setPrecioCosto( $precioCosto );
		$objPlato->setPrecioVenta( $precioVenta );
		$objPlato->setActivo( $activo );

        Conexion::getMysql()->Commit();
	break;

    case "ELIMINAR":
		$idPlato = Input::POST("idPlato", TRUE);
		$objPlato = new PlatoModel( $idPlato );

		if($objPlato->getIdRestaurant() != $idRestaurant) {
			throw new Exception("No puede eliminar platos de otros resturantes.");
		}

        $objPlato->Eliminar();
        Conexion::getMysql()->Commit();
    break;

	default:
		throw new Exception("Acción No Válida");
	break;
}

/*================================================================================
 * 
================================================================================*/
echo json_encode($respuesta);