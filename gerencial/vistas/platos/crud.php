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
			$platillos = PlatillosModel::Listado();
        }
        else
        {
        	//Utilizamos el mismo metodo pero pasandole el parametro buscar
            $platillos = PlatillosModel::Listado( $buscar );
        }

		//Haremos un bucle para indicar, exactamente la informacion que devolveremos.
		//O podemos retornamos todo
		$respuesta['data'] = $platillos;

		//No se que pasa si se envia asi, pero veamos
	break;

	default:
		throw new Exception("Accion invalida");
	break;
}

/**
 * Retornamos la respuesta
 * La variable ya esta definida, asi que no generara problema alguno asi como esta
 */
echo json_encode($respuesta);