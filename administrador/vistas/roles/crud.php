<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	CRUD DE LOS ROLES
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
        $idRestaurant = Input::POST("idRestaurant");
        $roles = RolesModel::Listado( $idRestaurant );
        $datos = [];
        for($I=0; $I<sizeof($roles); $I++)
        {
            $datos[$I] = [
                "id" => $roles[$I]['idRol'],
                "nombre" => $roles[$I]['nombre'],
                "descripcion" => $roles[$I]['descripcion'],
                "fecha_registro" => $roles[$I]['fecha_registro']
            ];
        }

        $respuesta['data'] = $datos;
    break;
    
    case "REGISTRAR":
        $idRestaurant = Input::POST("idRestaurant");
        $nombre = Input::POST("nombre");
        $descripcion = Input::POST("descripcion");

        $objRol = RolesModel::Registrar($idRestaurant, $nombre, $descripcion);
        Conexion::getMysql()->Commit();

        $respuesta['data'] = [
            "id" => $objRol->getId(),
            "nombre" => $objRol->getNombre(),
            "descripcion" => $objRol->getDescripcion(),
            "fecha_registro" => $objRol->getFechaRegistro()
        ];
    break;
    
    case "MODIFICAR":
        $idRol = Input::POST("idRol");
        $nombre = Input::POST("nombre");
        $descripcion = Input::POST("descripcion");

        $objRol = new RolModel($idRol);

        if($nombre !== FALSE) $objRol->setNombre( $nombre );
        if($descripcion !== FALSE) $objRol->setDescripcion( $descripcion );
        Conexion::getMysql()->Commit();

        $respuesta['data'] = [
            "id" => $objRol->getId(),
            "nombre" => $objRol->getNombre(),
            "descripcion" => $objRol->getDescripcion(),
            "fecha_registro" => $objRol->getFechaRegistro()
        ];
    break;

    case "ELIMINAR":
        $idRol = Input::POST("idRol");
        $idRolReemplazo = Input::POST("idRolReemplazo");

        if($idRol == $idRolReemplazo) throw new Exception("El rol a eliminar y el de reemplazo deben ser diferentes.");

        $objRol = new RolModel($idRol);
        $objRolReemplazo = new RolModel($idRolReemplazo);

        $objRol->Eliminar( $objRolReemplazo->getId() );
        Conexion::getMysql()->Commit();

        $respuesta['data'] = [
            "id" => $objRol->getId(),
            "nombre" => $objRol->getNombre(),
            "descripcion" => $objRol->getDescripcion(),
            "fecha_registro" => $objRol->getFechaRegistro()
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