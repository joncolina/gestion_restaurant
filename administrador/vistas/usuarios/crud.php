<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	CRUD DE USUARIOS
 *
 *--------------------------------------------------------------------------------
================================================================================*/

/*================================================================================
 * Tomamos los parametros
================================================================================*/
$accion = Input::POST("accion");

/*================================================================================
 * 
================================================================================*/
switch($accion)
{
    case "CONSULTAR":
        $buscar = Input::POST("buscar", FALSE);
        $filtros = Input::POST("filtros", FALSE);

        if($buscar !== FALSE)
        {
            $usuarios = UsuariosModel::Listado( $buscar );
        }
        elseif($filtros !== FALSE)
        {
            $idRestaurant = "";
            $usuario = "";
            $nombre = "";
            $activo = "";

            if( Input::POST("idRestaurant", FALSE) !== FALSE ) $idRestaurant = Input::POST("idRestaurant", FALSE);
            if( Input::POST("usuario", FALSE) !== FALSE ) $idRestaurant = Input::POST("usuario", FALSE);
            if( Input::POST("nombre", FALSE) !== FALSE ) $idRestaurant = Input::POST("nombre", FALSE);
            if( Input::POST("activo", FALSE) !== FALSE ) $idRestaurant = Input::POST("activo", FALSE);

            $usuarios = UsuariosModel::Filtros( $idRestaurant, $usuario, $nombre, $activo );
        }
        else
        {
            $usuarios = UsuariosModel::Listado(  );
        }
        
        $datos = [];
        for($I=0; $I<sizeof($usuarios); $I++)
        {
            $objUsuario = new UsuarioModel( $usuarios[$I]['usuario'] );
            $objRestaurant = new RestaurantModel( $objUsuario->getIdRestaurant() );
            $datos[$I] = [
                "foto" => $objUsuario->getFoto(),
                "usuario" => $objUsuario->getUsuario(),
                "nombre" => $objUsuario->getNombre(),
                "restaurant" => $objRestaurant->getNombre(),
                "activo" => $objUsuario->getActivo(),
                "fecha_registro" => $objUsuario->getFechaRegistro()
            ];
        }

        $respuesta['data'] = $datos;
    break;
    
    case "REGISTRAR":
        $idRestaurant = Input::POST("idRestaurant");
        $documento = Input::POST("documento");
        $nombre = Input::POST("nombre");
        $direccion = Input::POST("direccion", FALSE);
        $telefono = Input::POST("telefono", FALSE);
        $correo = Input::POST("correo", FALSE);
        $usuario = Input::POST("usuario");
        $idRol = Input::POST("rol");
        $clave = Input::POST("clave");
        $clave2 = Input::POST("clave2");

        if($idRestaurant == "") throw new Exception("Debe seleccionar un restaurant.");
        if($documento == "") throw new Exception("El campo de <b>documento</b> no puede estar vacio.");
        if($nombre == "") throw new Exception("El campo de <b>nombre</b> no puede estar vacio.");
        if($usuario == "") throw new Exception("El campo de <b>usuario</b> no puede estar vacio.");
        if($idRol == "") throw new Exception("El campo de <b>rol</b> no puede estar vacio.");
        if($clave == "") throw new Exception("El campo de <b>clave</b> no puede estar vacio.");

        if($clave != $clave2) throw new Exception("Las contraseñas deben ser iguales.");
        if( UsuariosModel::Existe( $usuario ) ) throw new Exception("El usuario <b>{$usuario}</b> ya existe.");

        $objUsuario = UsuariosModel::Registrar(
            $usuario,
            $idRestaurant,
            $clave,
            $documento,
            $nombre,
            $idRol,
            $direccion,
            $telefono,
            $correo
        );

        Conexion::getMysql()->Commit();

        $respuesta['data'] = [
            "usuario" => $objUsuario->getUsuario(),
            "idRestaurant" => $objUsuario->getIdRestaurant(),
            "documento" => $objUsuario->getDocumento(),
            "nombre" => $objUsuario->getNombre(),
            "rol" =>  $objUsuario->getRol()->getId()
        ];
    break;
    
    case "MODIFICAR":
        $usuario = Input::POST("usuario");
        $objUsuario = new UsuarioModel( $usuario );

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
            $carpetaImg = DIR_IMG_REST."/".$objUsuario->getIdRestaurant();
            $nombreImg = "usuario-{$objUsuario->getUsuario()}";
            $aux = explode(".", $img['name']);
            $extensionImg = $aux[ sizeof($aux) - 1 ];
            
            /**
             * Subimos la imagen
             */
            SubirImagen($carpetaImg, $nombreImg, $img);

            /**
             * Guardamos en la base de datos
             */
            $objUsuario->setFoto( "{$nombreImg}.{$extensionImg}" );
        }

        /**
         * Otros datos
         */
        if($documento !== FALSE) {
            if($documento == "") throw new Exception("El campo <b>documento</b> es obligatorio.");
            $objUsuario->setDocumento( $documento );
        }

        if($nombre !== FALSE) {
            if($nombre == "") throw new Exception("El campo <b>nombre</b> es obligatorio.");
            $objUsuario->setNombre( $nombre );
        }

        if($direccion !== FALSE) $objUsuario->setDireccion( $direccion );
        if($telefono !== FALSE) $objUsuario->setTelefono( $telefono );
        if($correo !== FALSE) $objUsuario->setCorreo( $correo );
        
        $clave = Input::POST("clave", FALSE);
        $idRol = Input::POST("idRol", FALSE);
        $activo = Input::POST("activo", FALSE);

        if($clave !== FALSE && $clave != "") {
            $objUsuario->setClave( $clave );
        }

        if($idRol !== FALSE) {
            if($idRol == "") throw new Exception("El campo <b>rol</b> es obligatorio.");
            $objUsuario->setRol( $idRol );
            
            if( RestaurantesModel::CantidadResponsables( $objUsuario->getIdRestaurant() ) <= 0 ) {
                throw new Exception("El resturant debe tener al menos un responsable.");
            }
        }

        if($activo !== FALSE) {
            if($activo == "") throw new Exception("El campo <b>activo</b> es obligatorio.");
            $objUsuario->setActivo( $activo );
        }

        Conexion::getMysql()->Commit();

        $respuesta['data'] = [
            "documento" => $objUsuario->getDocumento(),
            "nombre" => $objUsuario->getNombre(),
            "direccion" => $objUsuario->getDireccion(),
            "correo" => $objUsuario->getCorreo(),
            "telefono" => $objUsuario->getTelefono(),
            "usuario" => $objUsuario->getUsuario(),
            "idRol" => $objUsuario->getRol()->getId(),
            "activo" => $objUsuario->getActivo()
        ];
    break;

    case "ELIMINAR":
        $usuario = Input::POST("usuario");
        $objUsuario = new UsuarioModel( $usuario );
        $objUsuario->Eliminar();
        Conexion::getMysql()->Commit();

        $respuesta['data'] = [
            "usuario" => $objUsuario->getUsuario(),
            "nombre" => $objUsuario->getNombre(),
            "documento" => $objUsuario->getDocumento(),
            "fecha_registro" => $objUsuario->getFechaRegistro()
        ];
    break;

    default:
        throw new Exception("Acción invalida.");
    break;
}

/*================================================================================
 * Retornamos la salida
================================================================================*/
echo json_encode( $respuesta );