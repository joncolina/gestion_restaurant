<?php
/**
 * Por defecto ya esta definido un array con la siguiente estructura:
 * 
 * [
 *     'status' => TRUE,
 *     'mensaje' => '...',
 *     'data' => []
 * ]
 */

 $accion = Input::POST("accion");
 $objRestaurant = Sesion::getRestaurant();
 $idRestaurant = $objRestaurant->getId();
 /**
 * Verificamos la accion con un switch
 * Aqui tu elijes cuales son las acciones
 */
switch($accion)
{
	case "CONSULTAR":
		//La clase POST recibe 2 parametros
		//La key a buscar ($_POST[$KEY])
		//esObligatorio?: boolean por defecto es TRUE
		//Es decir, si es obligatorio y no existe, genera exception
		//Si no, retorna FALSE
		$buscar = Input::POST("buscar", FALSE);
		if($buscar === FALSE)
		{
            /* Vamos a buscar todos los platos del restaurant */
			//Los modelos los trabajo de dos formas:
			//General: Realiza acciones sobre toda una tabla
			//Especifico: Obtiene informacion de un unico registro y realiza acciones
			//Ejemplo: Listado, filtros, Busquedas -> General
			//Eliminar, modificar -> Especifico
			$mesas = MesasModel::Listado();
        }
        else
        {
        	//Utilizamos el mismo metodo pero pasandole el parametro buscar
            $mesas = MesasModel::Listado( $buscar );
        }

		//Haremos un bucle para indicar, exactamente la informacion que devolveremos.
		//O podemos retornamos todo
		$respuesta['data'] = $mesas;

		//No se que pasa si se envia asi, pero veamos
	break;

	case "REGISTRAR":
		$idRestaurant = $objRestaurant->getId();
		$alias = Input::POST("aliasmesa", TRUE);
		$activa = (int) boolval( Input::POST("ActivaMesa", FALSE) );
		
		//$objArea = new AreaMonitoreoModel( $idAreaMonitoreo );
		$objMesa = MesasModel::Registrar($idRestaurant,$alias);
		Conexion::getMysql()->Commit();

		$respuesta['data'] = [
			"id" => $objMesa->getId(),
			"alias" => $objMesa->getalias(),
			"activa" => $objMesa->getactiva(),
			"fecha_registro" => $objMesa->getfecha_registro()
		];
	break;

	case "MODIFICAR":
		$idMesa = Input::POST("MIdMesa", TRUE);
		$alias = Input::POST("Maliasmesa", TRUE);
		$objMesa = new MesaModel( $idMesa );

		$objMesa->setalias( $alias );
		Conexion::getMysql()->Commit();
	

		$respuesta['data'] = [
			"id" => $objMesa->getId(),
			"alias" => $objMesa->getalias()
			
		];
	break;

	case "ELIMINAR":
		$idMesa = Input::POST("EidMesa", TRUE);
		//$alias = Input::POST("Maliasmesa", TRUE);

		$objMesa = new MesaModel( $idMesa );
		//$objMesa->setalias( $alias );
		/*$objCategoriaReemplazo = new CategoriaModel( $idCategoriaReemplazo );

		if($objCategoria->getId() == $objCategoriaReemplazo->getId()) {
			throw new Exception("Las categorias a eliminar y de reemplazo no puedes ser iguales.");
		}*/

		$objMesa->Eliminar( $objMesa->getId() );
		Conexion::getMysql()->Commit();
		$respuesta['data'] = [];
	break;

	default:
		throw new Exception("Acción No Válida");
	break;
}

/**
 * Retornamos la respuesta
 * La variable ya esta definida, asi que no generara problema alguno asi como esta
 */
echo json_encode($respuesta);