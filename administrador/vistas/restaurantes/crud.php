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

/**
  * Tomamos la accion a realizar
  *
  * Clase Input
  * ->Metodo POST($key: string, $esObligatorio: boolean = TRUE)
  * $key es el equivalente al valor a buscar en el array $_POST.
  * $esObligatorio indica si el parametro a solicitar es necesario o no:
  * si es TRUE, cuando no se envie el parametro generara una exception.
  * si es FALSE, cuando no se envie el parametro, retornara FALSE.
  */
$accion = Input::POST("accion");

/**
 * Verificamos la accion con un switch
 */
switch($accion)
{
    case "REGISTRAR":
        /**
         * Tomamos los datos del resturant
         */
        $documento_restaurant = Input::POST("documento-restaurant");
        $nombre_restaurant = Input::POST("nombre-restaurant");
        $direccion_restaurant = Input::POST("direccion-restaurant");
        $telefono_restaurant = Input::POST("telefono-restaurant");
        $correo_restaurant = Input::POST("correo-restaurant");

        /**
         * Tomamos los datos del gerente
         */
        $documento_gerente = Input::POST("documento-gerente");
        $nombre_gerente = Input::POST("nombre-gerente");
        $direccion_gerente = Input::POST("direccion-gerente");
        $telefono_gerente = Input::POST("telefono-gerente");
        $correo_gerente = Input::POST("correo-gerente");
        $usuario_gerente = Input::POST("usuario-gerente");
        $clave_gerente = Input::POST("clave-gerente");
        $clave2_gerente = Input::POST("clave2-gerente");

        /**
         * Validamos los datos
         */
        if( RestaurantesModel::Existe($documento_restaurant, $nombre_restaurant) ) {
            throw new Exception("Ya se encuentra un restaurant con los siguientes datos:<br>Documento: {$documento_restaurant}<br>Nombre: {$nombre_restaurant}");
        }

        if( UsuariosModel::Existe($usuario_gerente) ) {
            throw new Exception("Ya se encuentra registrado el usuario <b>{$usuario_gerente}</b>.");
        }

        if($clave_gerente != $clave2_gerente) {
            throw new Exception("Las contraseñas tienen que ser iguales.");
        }
        
        /**
         * Registramos al restaurant
         */
        $objRestaurant = RestaurantesModel::Registrar(
            $documento_restaurant,
            $nombre_restaurant,
            $direccion_restaurant,
            $telefono_restaurant,
            $correo_restaurant
        );

        /**
         * Registramos los roles
         */
        $objRolGerente = RolesModel::Registrar( $objRestaurant->getId(), "GERENTE", "");
        $objRolBasico = RolesModel::Registrar( $objRestaurant->getId(), "BASICO", "");

        /**
         * Registramos los permisos
         */

        //GERENTE
        $objRolGerente->setPermisosA(1, TRUE);
        $objRolGerente->setPermisosA(2, TRUE);
        $objRolGerente->setPermisosA(3, TRUE);
        $objRolGerente->setPermisosA(4, TRUE);
        $objRolGerente->setPermisosA(5, TRUE);
        $objRolGerente->setPermisosA(6, TRUE);
        $objRolGerente->setPermisosA(7, TRUE);
        $objRolGerente->setPermisosA(8, TRUE);

        $objRolBasico->setPermisosB(1, TRUE);
        $objRolBasico->setPermisosB(2, TRUE);
        $objRolBasico->setPermisosB(3, TRUE);
        $objRolBasico->setPermisosB(4, TRUE);
        $objRolBasico->setPermisosB(5, TRUE);

        //BASICO
        $objRolGerente->setPermisosA(2, TRUE);
        $objRolGerente->setPermisosA(3, TRUE);
        $objRolGerente->setPermisosA(4, TRUE);
        $objRolGerente->setPermisosA(7, TRUE);
        $objRolGerente->setPermisosA(8, TRUE);

        /**
         * Registramos el gerente
         */
        $objUsuario = UsuariosModel::Registrar(
            $usuario_gerente,
            $objRestaurant->getId(),
            $clave_gerente,
            $documento_gerente,
            $nombre_gerente,
            $objRolGerente->getId(),
            $direccion_gerente,
            $telefono_gerente,
            $correo_gerente
        );

        /**
         * Guardamos los cambios
         */
        Conexion::getMysql()->Commit();

        /**
         * Retornamos los datos imporantes
         */
        $respuesta['data'] = [
            "id" => $objRestaurant->getId()
        ];
    break;

    case "CONSULTAR":
        $buscar = Input::POST("buscar", FALSE);

        if($buscar === FALSE) {
            $restaurantes = RestaurantesModel::Listado();
        } else {
            $restaurantes = RestaurantesModel::Listado( $buscar );
        }

        $datos = [];
        for($I=0; $I<sizeof($restaurantes); $I++)
        {
            $datos[$I] = [
                "id" => $restaurantes[$I]['idRestaurant'],
                "nombre" => $restaurantes[$I]['nombre'],
                "documento" => $restaurantes[$I]['documento'],
                "activo" => boolval( $restaurantes[$I]['activo'] ),
                "fecha_registro" => $restaurantes[$I]['fecha_registro']
            ];
        }

        $respuesta['data'] = $datos;
    break;

    case "MODIFICAR":
        $idRestaurant = Input::POST("idRestaurant");
        $objRestaurant = new RestaurantModel($idRestaurant);

        $documento = Input::POST("documento", FALSE);
        $nombre = Input::POST("nombre", FALSE);
        $direccion = Input::POST("direccion", FALSE);
        $telefono = Input::POST("telefono", FALSE);
        $correo = Input::POST("correo", FALSE);
        $activo = Input::POST("activo", FALSE);

        if($documento !== FALSE) {
            if($documento == "") throw new Exception("El documento no puede estar vacio.");
            $objRestaurant->setDocumento( $documento );
        }

        if($nombre !== FALSE) {
            if($nombre == "") throw new Exception("El nombre no puede estar vacio.");
            $objRestaurant->setNombre( $nombre );
        }

        if($direccion !== FALSE) $objRestaurant->setDireccion( $direccion );
        if($telefono !== FALSE) $objRestaurant->setTelefono( $telefono );
        if($correo !== FALSE) $objRestaurant->setCorreo( $correo );
        if($activo !== FALSE) $objRestaurant->setActivo( $activo );

        $whatsapp = Input::POST("whatsapp", FALSE);
        $facebook = Input::POST("facebook", FALSE);
        $twitter = Input::POST("twitter", FALSE);
        $instagram = Input::POST("instagram", FALSE);
        
        if($whatsapp !== FALSE) $objRestaurant->setWhatsapp( $whatsapp );
        if($facebook !== FALSE) $objRestaurant->setFacebook( $facebook );
        if($twitter !== FALSE) $objRestaurant->setTwitter( $twitter );
        if($instagram !== FALSE) $objRestaurant->setInstagram( $instagram );
        
        Conexion::getMysql()->Commit();

        $respuesta['data'] = [
            "id" => $objRestaurant->getId(),
            "documento" => $objRestaurant->getDocumento(),
            "nombre" => $objRestaurant->getNombre(),
            "direccion" => $objRestaurant->getDireccion(),
            "telefono" => $objRestaurant->getTelefono(),
            "correo" => $objRestaurant->getCorreo(),
            "whatsapp" => $objRestaurant->getWhatsapp(),
            "twitter" => $objRestaurant->getTwitter(),
            "instagram" => $objRestaurant->getInstagram(),
            "facebook" => $objRestaurant->getFacebook(),
            "activo" => $objRestaurant->getActivo()
        ];
    break;

    case "ELIMINAR":
        /**
         * Tomamos los parametros esperados
         */
        $idRestaurant = Input::POST("idRestaurant");

        /**
         * Verificamos los parametros
         */
        $objRestaurant = new RestaurantModel($idRestaurant);

        /**
         * Ejecutamos la operación dependiendo del estado actual
         */
        if($objRestaurant->getActivo()) {
            $objRestaurant->setActivo(FALSE);
        } else {
            $objRestaurant->setActivo(TRUE);
        }

        /**
         * Guardamos los cambios ejecutados
         */
        Conexion::getMysql()->Commit();

        /**
         * Preparamos la data a retornar
         */
        $respuesta['data'] = [
            "id" => $objRestaurant->getId(),
            "nombre" => $objRestaurant->getNombre(),
            "activo" => $objRestaurant->getActivo()
        ];
    break;

    default:
        throw new Exception("Acción invalida.");
    break;
}

/**
 * Retornamos la respuesta
 */
echo json_encode($respuesta);