<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	CRUD DE RESTAURANTES
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
    case "MODIFICAR":
        $documento = Input::POST("documento", FALSE);
        $nombre = Input::POST("nombre", FALSE);
        $direccion = Input::POST("direccion", FALSE);
        $telefono = Input::POST("telefono", FALSE);
        $correo = Input::POST("correo", FALSE);

        /**
         * Imagen
         */
        if($_FILES && $_FILES['img'] && $_FILES['img']['name'] != "")
        {
            /**
             * Extraemos la data
             */
            $img = $_FILES['img'];
            $carpetaImg = DIR_IMG_REST."/".$objRestaurant->getId();
            $nombreImg = "logo";
            $aux = explode(".", $img['name']);
            $extensionImg = $aux[ sizeof($aux) - 1 ];
            
            /**
             * Subimos la imagen
             */
            SubirImagen($carpetaImg, $nombreImg, $img);

            /**
             * Guardamos en la base de datos
             */
            $objRestaurant->setLogo( "{$nombreImg}.{$extensionImg}" );
        }

        /**
         * Otros datos
         */
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

    default:
        throw new Exception("Acción invalida.");
    break;
}

/*================================================================================
 * Retornamos la salida
================================================================================*/
echo json_encode($respuesta);